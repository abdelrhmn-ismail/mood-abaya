<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Payment\Services\PaymentService;
use Modules\Payment\Services\TabbyPaymentService;

class TabbyController extends Controller
{
    protected TabbyPaymentService $tabbyService;

    public function __construct(TabbyPaymentService $tabbyService)
    {
        $this->tabbyService = $tabbyService;
    }

    /* ───────────────────────────────────────────────────
     *  Redirect endpoints
     * ─────────────────────────────────────────────────── */

    /**
     * Handle successful payment redirection.
     * Retrieves the payment from Tabby and captures it.
     */
    public function success(Request $request)
    {
        try {
            $paymentId = $request->input('payment_id');

            if (!$paymentId) {
                Log::error('Tabby Success: Payment ID missing');
                return redirect()->route('cart')->with('error', __('Payment ID is missing.'));
            }

            // Server-to-server verification
            Log::info('Tabby Success: Retrieving payment', ['payment_id' => $paymentId]);
            $paymentDetails = $this->tabbyService->retrievePayment($paymentId);

            if (!isset($paymentDetails['status']) || !in_array($paymentDetails['status'], ['AUTHORIZED', 'CLOSED'])) {
                Log::warning('Tabby Success: Payment not authorized', [
                    'payment_id' => $paymentId,
                    'status'     => $paymentDetails['status'] ?? 'unknown',
                ]);
                return redirect()->route('cart')->with('error', __('Payment verification failed.'));
            }

            // Capture the payment
            $this->capturePayment($paymentId, $paymentDetails['amount'] ?? '0');

            // Mark the order payment as paid
            $referenceId = $paymentDetails['order']['reference_id'] ?? null;
            if ($referenceId) {
                $this->markOrderPaid($referenceId, $paymentId);
            }

            return redirect()->route('account')->with('success', __('Payment completed successfully!'));
        } catch (\Exception $e) {
            Log::error('Tabby Success: Exception', ['error' => $e->getMessage()]);
            return redirect()->route('cart')->with('error', $e->getMessage());
        }
    }

    /**
     * Handle failed payment.
     */
    public function failure()
    {
        $message = app()->getLocale() === 'ar'
            ? 'نأسف، تابي غير قادرة على الموافقة على هذه العملية. الرجاء استخدام طريقة دفع أخرى.'
            : 'Sorry, Tabby is unable to approve this purchase. Please use an alternative payment method for your order.';

        return redirect()->route('cart')->with('error', $message);
    }

    /**
     * Handle cancelled payment.
     */
    public function cancel()
    {
        $message = app()->getLocale() === 'ar'
            ? 'لقد ألغيت الدفعة. فضلاً حاول مجددًا أو اختر طريقة دفع أخرى.'
            : 'You cancelled the payment. Please retry or choose another payment method.';

        return redirect()->route('cart')->with('error', $message);
    }

    /* ───────────────────────────────────────────────────
     *  Webhook
     * ─────────────────────────────────────────────────── */

    /**
     * Handle Tabby webhook callbacks.
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('Tabby Webhook received', [
                'payload' => $request->all(),
            ]);

            $payload = $request->all();

            if (!isset($payload['id'])) {
                Log::error('Tabby Webhook: Payment ID missing');
                return response()->json(['error' => 'Payment ID missing'], 400);
            }

            $paymentId = $payload['id'];
            $status = strtoupper($payload['status'] ?? '');
            $referenceId = $payload['order']['reference_id'] ?? null;

            Log::info('Tabby Webhook: Processing', [
                'payment_id'         => $paymentId,
                'status'             => $status,
                'order_reference_id' => $referenceId,
            ]);

            if ($status === 'AUTHORIZED') {
                // Capture + mark paid
                $this->capturePayment($paymentId, $payload['amount'] ?? '0');
                if ($referenceId) {
                    $this->markOrderPaid($referenceId, $paymentId);
                }
            } elseif (in_array($status, ['REJECTED', 'EXPIRED'])) {
                Log::warning("Tabby Webhook: Payment {$status}", ['payment_id' => $paymentId]);
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('Tabby Webhook: Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }

    /* ───────────────────────────────────────────────────
     *  Internal helpers
     * ─────────────────────────────────────────────────── */

    /**
     * Capture an authorized Tabby payment.
     */
    protected function capturePayment(string $paymentId, string $amount): bool
    {
        try {
            $result = $this->tabbyService->capturePayment($paymentId, ['amount' => $amount]);

            if (!in_array($result['status'] ?? '', ['CREATED', 'AUTHORIZED', 'CLOSED'])) {
                throw new \Exception('Capture failed, status: ' . ($result['status'] ?? 'unknown'));
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Tabby: Capture failed', [
                'payment_id' => $paymentId,
                'amount'     => $amount,
                'error'      => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Mark the local order payment as paid using the order number (reference ID).
     */
    protected function markOrderPaid(string $orderNumber, string $tabbyPaymentId): void
    {
        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            Log::warning('Tabby: Order not found for reference', ['reference' => $orderNumber]);
            return;
        }

        $payment = $order->payments()->where('method', 'tabby')->first();
        if (!$payment) {
            Log::warning('Tabby: Payment record not found', ['order_number' => $orderNumber]);
            return;
        }

        if ($payment->status !== 'paid') {
            $payment->update([
                'status'    => 'paid',
                'reference' => $tabbyPaymentId,
            ]);
            $order->update([
                'payment_status' => 'paid',
                'status'         => $order->status === 'pending' ? 'processing' : $order->status,
            ]);
            Log::info('Tabby: Order marked as paid', ['order_number' => $orderNumber]);
        }
    }
}
