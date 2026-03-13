<?php

namespace Modules\Admin\Services;

use App\Models\Order;
use App\Models\Shipping;

class ShippingService
{
    public function createOrUpdate(Order $order, array $data): Shipping
    {
        $shipping = $order->shippings()->first();

        $payload = [
            'carrier' => $data['carrier'] ?? '',
            'tracking_number' => $data['tracking_number'] ?? '',
            'status' => $data['status'] ?? 'shipped',
            'shipped_at' => $data['shipped_at'] ?? now(),
        ];

        if ($shipping) {
            $shipping->update($payload);
            return $shipping;
        }

        return $order->shippings()->create($payload);
    }

    public function markShipped(Order $order, string $carrier, string $trackingNumber): Shipping
    {
        return $this->createOrUpdate($order, [
            'carrier' => $carrier,
            'tracking_number' => $trackingNumber,
            'status' => 'shipped',
            'shipped_at' => now(),
        ]);
    }
}
