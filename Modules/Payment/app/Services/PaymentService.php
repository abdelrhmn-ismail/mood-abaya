<?php

namespace Modules\Payment\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentService
{

    public function createPaymentForOrder(Order $order, string $method, ?string $proofPath = null): Payment
    {
        $status = $method === 'bank' ? 'pending_approval' : 'pending';
        return Payment::create([
            'order_id' => $order->id,
            'method' => $method,
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
        $payment->order->update(['payment_status' => 'paid']);
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
