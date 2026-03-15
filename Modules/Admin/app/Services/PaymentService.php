<?php

namespace Modules\Admin\Services;

use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Payment\Services\PaymentService as MainPaymentService;

class PaymentService
{
    public function __construct(
        private MainPaymentService $mainPaymentService
    ) {}

    public function getPayments(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Payment::with('order.user')->latest();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['method'])) {
            $query->where('method', $filters['method']);
        }

        return $query->paginate($perPage);
    }

    public function getPayment(int $id): ?Payment
    {
        return Payment::with('order.user')->find($id);
    }

    public function approveBankPayment(Payment $payment): void
    {
        $this->mainPaymentService->approveBankPayment($payment);
    }

    public function rejectBankPayment(Payment $payment): void
    {
        $this->mainPaymentService->rejectBankPayment($payment);
    }

    public function markAsPaid(Payment $payment): void
    {
        $this->mainPaymentService->markAsPaid($payment);
    }

    public function bulkApprove(array $ids): int
    {
        $count = 0;
        /** @var Payment $payment */
        foreach (Payment::whereIn('id', $ids)->get() as $payment) {
            if ($payment->method === 'bank' && $payment->status === 'pending_approval') {
                $this->mainPaymentService->approveBankPayment($payment);
                $count++;
            }
        }
        return $count;
    }

    public function bulkReject(array $ids): int
    {
        $count = 0;
        /** @var Payment $payment */
        foreach (Payment::whereIn('id', $ids)->get() as $payment) {
            if ($payment->method === 'bank' && $payment->status === 'pending_approval') {
                $this->mainPaymentService->rejectBankPayment($payment);
                $count++;
            }
        }
        return $count;
    }

    public function bulkMarkPaid(array $ids): int
    {
        $count = 0;
        $payments = Payment::whereIn('id', $ids)->get();
        foreach ($payments as $payment) {
            if ($payment instanceof Payment && $payment->status !== 'paid') {
                $this->mainPaymentService->markAsPaid($payment);
                $count++;
            }
        }
        return $count;
    }
}
