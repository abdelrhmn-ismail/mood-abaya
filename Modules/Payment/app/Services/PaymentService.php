<?php

namespace Modules\Payment\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class PaymentService
{

    public function createPaymentForOrder(Order $order, PaymentMethod $method, ?string $proofPath = null): Payment
    {
        $status = $method->requires_admin_approval ? 'pending_approval' : 'pending';

        return Payment::create([
            'order_id' => $order->id,
            'method' => $method->code,
            'status' => $status,
            'proof_path' => $proofPath,
        ]);
    }

    public function markAsPaid(Payment $payment): void
    {
        $payment->update([
            'status' => 'paid',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
        $updates = ['payment_status' => 'paid'];
        if ($payment->order->status === 'pending') {
            $updates['status'] = 'processing';
        }
        $payment->order->update($updates);
    }

    public function approveBankPayment(Payment $payment): void
    {
        $this->markAsPaid($payment);
    }

    public function rejectBankPayment(Payment $payment): void
    {
        $payment->update(['status' => 'rejected']);
        $payment->order->update(['payment_status' => 'rejected']);
    }
}
