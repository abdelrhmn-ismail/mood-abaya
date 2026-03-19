<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\HomeController;
use Modules\Core\Http\Controllers\SitemapController;

Route::get('/', HomeController::class)->name('home');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/dashboard', function () {
    return view('core::frontend.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/announcement-dismiss', function () {
    session()->put('announcement_bar_dismissed', true);
    return back();
})->name('announcement.dismiss');

Route::post('/home-popup-dismiss', function () {
    session()->put('home_popup_shown', true);
    return response()->json(['ok' => true]);
})->name('home.popup.dismiss');
