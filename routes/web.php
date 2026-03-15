<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend routes (/, /about, /categories, /cart, /contact, etc.) are registered by Core, Shop, Contact, Cart modules.

Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show')->where('slug', '[a-z0-9\-]+');

Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'], true)) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('locale.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/account', [\App\Http\Controllers\AccountController::class, 'index'])->name('account')->middleware('verified');
    Route::post('/account/order-review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('account.order-review.store')->middleware('verified');
    Route::get('/account/orders/{orderNumber}', [\App\Http\Controllers\AccountController::class, 'showOrder'])->name('orders.show')->middleware('verified');
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{productId}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy')->where('productId', '[0-9]+');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/account/billing-addresses', [\App\Http\Controllers\BillingAddressController::class, 'store'])->name('billing-addresses.store');
    Route::put('/account/billing-addresses/{billingAddress}', [\App\Http\Controllers\BillingAddressController::class, 'update'])->name('billing-addresses.update');
    Route::delete('/account/billing-addresses/{billingAddress}', [\App\Http\Controllers\BillingAddressController::class, 'destroy'])->name('billing-addresses.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
