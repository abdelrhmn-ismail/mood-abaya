<?php

use App\Http\Controllers\ServePublicMediaController;
use Illuminate\Support\Facades\Route;

// Serve uploads from public/media through PHP (fixes 403 when the web server cannot read files created by CLI/other users).
Route::get('/media/{path}', ServePublicMediaController::class)
    ->where('path', '.*')
    ->name('media.serve');

// All routes are registered by their respective modules.
// Core: /, /sitemap.xml, /dashboard, /announcement-dismiss, /home-popup-dismiss
// Settings: /locale/{locale}
// User: /account, /profile
// Shop: /categories, /products, /search, /wishlist
// Order: /checkout, /order-confirmed, /billing-addresses
// Contact: /contact
// Blog: /blog
// Page: /about, /page/{slug}
// Newsletter: /newsletter
// Cart: /cart

require __DIR__.'/auth.php';
