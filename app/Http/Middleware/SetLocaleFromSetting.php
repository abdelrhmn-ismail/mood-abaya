<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromSetting
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $locale = $request->session()->get('locale') ?? Setting::locale();
                if (in_array($locale, ['en', 'ar'], true)) {
                    app()->setLocale($locale);
                }
                // Apply admin-edited translation overrides (from Settings > Translations)
                $overrides = Setting::get('lang_overrides');
                if ($overrides) {
                    $dec = json_decode($overrides, true);
                    $locale = app()->getLocale();
                    if (is_array($dec) && !empty($dec[$locale])) {
                        $lines = array_filter($dec[$locale], fn ($v) => $v !== null && $v !== '');
                        if (!empty($lines)) {
                            \Illuminate\Support\Facades\Lang::addLines($lines, $locale, '*');
                        }
                    }
                }
            }
        } catch (\Throwable) {
            // Fallback if settings table missing or not migrated
        }

        return $next($request);
    }
}
