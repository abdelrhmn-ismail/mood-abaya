<?php

namespace App\Services;

use App\Models\BillingAddress;

class BillingAddressService
{
    public function create(int $userId, array $data): BillingAddress
    {
        $data['user_id'] = $userId;

        if (!empty($data['is_default'])) {
            BillingAddress::where('user_id', $userId)->update(['is_default' => false]);
        }

        return BillingAddress::create($data);
    }

    public function update(BillingAddress $billingAddress, array $data): BillingAddress
    {
        if (!empty($data['is_default'])) {
            BillingAddress::where('user_id', $billingAddress->user_id)
                ->where('id', '!=', $billingAddress->id)
                ->update(['is_default' => false]);
        }

        $billingAddress->update($data);

        return $billingAddress;
    }

    public function delete(BillingAddress $billingAddress): void
    {
        $billingAddress->delete();
    }
}
