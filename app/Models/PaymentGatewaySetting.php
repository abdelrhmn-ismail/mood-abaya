<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PaymentGatewaySetting extends Model
{
    protected $fillable = ['gateway', 'key', 'value'];

    /**
     * Get a single setting value for a gateway.
     */
    public static function getValue(string $gateway, string $key, mixed $default = null): mixed
    {
        $cacheKey = "gateway_setting.{$gateway}.{$key}";

        return Cache::rememberForever($cacheKey, function () use ($gateway, $key, $default) {
            $row = static::where('gateway', $gateway)->where('key', $key)->first();

            return $row ? $row->value : $default;
        });
    }

    /**
     * Set a single setting value for a gateway.
     */
    public static function setValue(string $gateway, string $key, ?string $value): void
    {
        static::updateOrCreate(
            ['gateway' => $gateway, 'key' => $key],
            ['value' => $value]
        );
        Cache::forget("gateway_setting.{$gateway}.{$key}");
    }

    /**
     * Get all settings for a gateway as an associative array.
     */
    public static function allForGateway(string $gateway): array
    {
        return static::where('gateway', $gateway)
            ->pluck('value', 'key')
            ->toArray();
    }
}
