<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'key';

    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = 'setting.' . $key;

        return Cache::rememberForever($cacheKey, function () use ($key, $default) {
            $row = static::find($key);

            return $row ? $row->value : $default;
        });
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_string($value) ? $value : json_encode($value)]
        );
        Cache::forget('setting.' . $key);
    }

    public static function locale(): string
    {
        $locale = static::get('locale', config('app.locale', 'en'));

        return in_array($locale, ['ar', 'en'], true) ? $locale : 'en';
    }

    public static function defaultTheme(): string
    {
        $theme = static::get('theme', 'light');

        return in_array($theme, ['light', 'dark', 'system'], true) ? $theme : 'light';
    }
}
