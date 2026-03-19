<?php

namespace Modules\Order\Services;

use App\Models\Setting;

class ShippingService
{
    public function getType(): string
    {
        return Setting::get('shipping_type', 'flat') ?: 'flat';
    }

    public function getFlatRate(): float
    {
        return (float) Setting::get('shipping_flat_rate', 0);
    }

    /** Minimum order amount (SAR) for free shipping when type is free_over. */
    public function getFreeOver(): ?float
    {
        $v = Setting::get('shipping_free_over', '');
        if ($v === '' || $v === null) {
            return null;
        }
        return (float) $v;
    }

    /** @return array<int, array{id: string, label: string, amount: float}> */
    public function getZones(): array
    {
        $json = Setting::get('shipping_zones', '');
        if ($json === '' || $json === null) {
            return [];
        }
        $dec = json_decode($json, true);
        if (! is_array($dec)) {
            return [];
        }
        $zones = [];
        foreach ($dec as $z) {
            if (isset($z['id'], $z['label'], $z['amount'])) {
                $zones[] = [
                    'id' => (string) $z['id'],
                    'label' => (string) $z['label'],
                    'amount' => (float) $z['amount'],
                ];
            }
        }
        return $zones;
    }

    /**
     * Calculate shipping amount and label.
     *
     * @param  float  $subtotal  Cart subtotal (SAR)
     * @param  string|null  $zoneId  For zones: selected zone id (e.g. riyadh, other). Null = use first zone or 0.
     * @return array{amount: float, label: string}
     */
    public function calculate(float $subtotal, ?string $zoneId = null): array
    {
        $type = $this->getType();

        if ($type === 'free_over') {
            $freeOver = $this->getFreeOver();
            if ($freeOver !== null && $subtotal >= $freeOver) {
                return ['amount' => 0.0, 'label' => __('Free shipping')];
            }
            $flat = $this->getFlatRate();
            return ['amount' => $flat, 'label' => $flat > 0 ? __('Shipping') : __('Free shipping')];
        }

        if ($type === 'zones') {
            $zones = $this->getZones();
            if ($zones === []) {
                return ['amount' => 0.0, 'label' => __('Shipping')];
            }
            foreach ($zones as $z) {
                if ($z['id'] === $zoneId) {
                    return ['amount' => $z['amount'], 'label' => $z['label']];
                }
            }
            $first = $zones[0];
            return ['amount' => $first['amount'], 'label' => $first['label']];
        }

        $flat = $this->getFlatRate();
        return ['amount' => $flat, 'label' => $flat > 0 ? __('Shipping') : __('Free shipping')];
    }
}
