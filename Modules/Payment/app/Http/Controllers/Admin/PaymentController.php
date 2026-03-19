<?php

namespace Modules\Payment\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Payment\Http\Requests\Admin\BulkPaymentActionRequest;
use Modules\Payment\Services\Admin\PaymentService as AdminPaymentService;

class PaymentController
{
    public function __construct(
        private AdminPaymentService $paymentService
    ) {}

    public function index(Request $request): View
    {
        $payments = $this->paymentService->getPayments(
            $request->only('status', 'method'),
            admin_per_page()
        );

        return view('payment::admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment): View
    {
        $payment->load('order.user');

        return view('payment::admin.payments.show', compact('payment'));
    }

    public function approve(Payment $payment): RedirectResponse
    {
        if ($payment->method !== 'bank' || $payment->status !== 'pending_approval') {
            return redirect()->back()->with('error', __('Invalid payment for approval.'));
        }
        $this->paymentService->approveBankPayment($payment);

        return redirect()->route('admin.payments.show', $payment)->with('success', __('Payment approved.'));
    }

    public function reject(Payment $payment): RedirectResponse
    {
        if ($payment->method !== 'bank' || $payment->status !== 'pending_approval') {
            return redirect()->back()->with('error', __('Invalid payment for rejection.'));
        }
        $this->paymentService->rejectBankPayment($payment);

        return redirect()->route('admin.payments.show', $payment)->with('success', __('Payment rejected.'));
    }

    public function markPaid(Payment $payment): RedirectResponse
    {
        if ($payment->status === 'paid') {
            return redirect()->back()->with('error', __('Payment already marked as paid.'));
        }
        $this->paymentService->markAsPaid($payment);

        return redirect()->route('admin.orders.show', $payment->order)->with('success', __('Payment marked as paid.'));
    }

    public function bulkAction(BulkPaymentActionRequest $request): RedirectResponse
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        $count = 0;
        if ($action === 'approve') {
            $count = $this->paymentService->bulkApprove($ids);
        } elseif ($action === 'reject') {
            $count = $this->paymentService->bulkReject($ids);
        } elseif ($action === 'mark_paid') {
            $count = $this->paymentService->bulkMarkPaid($ids);
        }

        return redirect()->route('admin.payments.index', $request->only('status', 'method', 'per_page', 'sort', 'order'))
            ->with('success', __(':count payment(s) updated.', ['count' => $count]));
    }
}
