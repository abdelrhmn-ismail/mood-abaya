<?php

namespace App\Providers;

use Modules\Shop\Services\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Request::macro('phoneWithCode', function (string $prefix = 'phone'): string {
            return trim($this->input($prefix . '_country_code', '') . $this->input($prefix . '_number', ''));
        });

        View::composer(['frontend.layouts.app', 'frontend.partials.navbar'], function ($view) {
            $view->with('wishlistCount', app(WishlistService::class)->count());
        });
    }
}
