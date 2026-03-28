<?php

namespace Modules\Payment\Services\Admin;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentMethodAdminService
{
    /** @return \Illuminate\Database\Eloquent\Collection<int, PaymentMethod> */
    public function getAllOrdered()
    {
        return PaymentMethod::query()->ordered()->get();
    }

    public function update(PaymentMethod $paymentMethod, array $data): void
    {
        $newActive = (bool) ($data['is_active'] ?? false);
        if ($paymentMethod->is_active && ! $newActive && $this->countActive() <= 1) {
            throw ValidationException::withMessages([
                'is_active' => [__('At least one payment method must remain active.')],
            ]);
        }

        $paymentMethod->update([
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'description_ar' => $data['description_ar'] ?? null,
            'instructions_en' => $data['instructions_en'] ?? null,
            'instructions_ar' => $data['instructions_ar'] ?? null,
            'is_active' => $newActive,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'requires_proof' => $data['requires_proof'] ?? false,
            'requires_admin_approval' => $data['requires_admin_approval'] ?? false,
        ]);
    }

    public function toggleActive(PaymentMethod $paymentMethod): void
    {
        if ($paymentMethod->is_active && $this->countActive() <= 1) {
            return;
        }

        $paymentMethod->update(['is_active' => ! $paymentMethod->is_active]);
    }

    public function create(array $data): PaymentMethod
    {
        return PaymentMethod::create([
            'code' => $data['code'],
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'description_ar' => $data['description_ar'] ?? null,
            'instructions_en' => $data['instructions_en'] ?? null,
            'instructions_ar' => $data['instructions_ar'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'requires_proof' => $data['requires_proof'] ?? false,
            'requires_admin_approval' => $data['requires_admin_approval'] ?? false,
            'is_system' => false,
        ]);
    }

    public function delete(PaymentMethod $paymentMethod): bool
    {
        if ($paymentMethod->is_system) {
            return false;
        }

        if (DB::table('payments')->where('method', $paymentMethod->code)->exists()) {
            return false;
        }

        $paymentMethod->delete();

        if ($this->countActive() === 0) {
            $first = PaymentMethod::query()->ordered()->first();
            if ($first) {
                $first->update(['is_active' => true]);
            }
        }

        return true;
    }

    private function countActive(): int
    {
        return PaymentMethod::query()->where('is_active', true)->count();
    }
}
