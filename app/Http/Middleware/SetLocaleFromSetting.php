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
                app()->setLocale(Setting::locale());
            }
        } catch (\Throwable) {
            // Fallback if settings table missing or not migrated
        }

        return $next($request);
    }
}
