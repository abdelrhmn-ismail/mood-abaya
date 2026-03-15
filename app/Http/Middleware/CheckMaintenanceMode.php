<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->isMaintenanceEnabled()) {
            return $next($request);
        }

        // Allow health check
        if ($request->is('up')) {
            return $next($request);
        }

        // Allow admin panel (and auth routes so admin can log in)
        if ($request->is('admin') || $request->is('admin/*') || $request->is('login') || $request->is('logout') || $request->is('register')) {
            return $next($request);
        }

        // Allow IP allowlist
        $ip = $request->ip();
        if ($this->isIpAllowed($ip)) {
            return $next($request);
        }

        // Allow authenticated admin users (e.g. when not under /admin path)
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        return response()->view('frontend.maintenance', [
            'coming_back_at' => $this->getComingBackAt(),
        ], 503);
    }

    private function isMaintenanceEnabled(): bool
    {
        return (bool) Setting::get('maintenance_mode_enabled', '0');
    }

    private function getComingBackAt(): ?string
    {
        $value = Setting::get('maintenance_coming_back_at', '');
        if ($value === '' || $value === null) {
            return null;
        }
        try {
            $dt = \Carbon\Carbon::parse($value);
            return $dt->format('Y-m-d H:i');
        } catch (\Throwable $e) {
            return $value;
        }
    }

    private function isIpAllowed(?string $ip): bool
    {
        if ($ip === null || $ip === '') {
            return false;
        }
        $raw = Setting::get('maintenance_ip_allowlist', '');
        if (trim($raw) === '') {
            return false;
        }
        $list = preg_split('/[\s,]+/', trim($raw), -1, PREG_SPLIT_NO_EMPTY);
        foreach ($list as $allowed) {
            $allowed = trim($allowed);
            if ($allowed === '' || str_starts_with($allowed, '#')) {
                continue;
            }
            if ($ip === $allowed) {
                return true;
            }
        }
        return false;
    }
}
