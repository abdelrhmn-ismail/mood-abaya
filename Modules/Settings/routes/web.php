<?php

use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'], true)) {
        session()->put('locale', $locale);
        return redirect()->back()->cookie('locale', $locale, 60 * 24 * 365, '/', null, false, false);
    }
    return redirect()->back();
})->name('locale.switch');
