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
            }
        } catch (\Throwable) {
            // Fallback if settings table missing or not migrated
        }

        return $next($request);
    }
}
