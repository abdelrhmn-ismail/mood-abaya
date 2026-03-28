<?php

namespace Modules\Payment\Services;

use App\Models\PaymentMethod;
use Illuminate\Support\Collection;

class PaymentMethodService
{
    /** @return Collection<int, PaymentMethod> */
    public function getActiveForCheckout(): Collection
    {
        return PaymentMethod::query()->active()->ordered()->get();
    }

    /** @return array<int, string> */
    public function getActiveCodes(): array
    {
        return $this->getActiveForCheckout()->pluck('code')->all();
    }

    public function getByCode(?string $code): ?PaymentMethod
    {
        if ($code === null || $code === '') {
            return null;
        }

        return PaymentMethod::query()->where('code', $code)->first();
    }

    public function getActiveByCode(?string $code): ?PaymentMethod
    {
        $m = $this->getByCode($code);

        return $m && $m->is_active ? $m : null;
    }

    public function labelForCode(string $code): string
    {
        $m = $this->getByCode($code);

        return $m ? $m->nameForLocale() : $code;
    }
}
