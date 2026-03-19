<?php

use Illuminate\Support\Facades\Route;

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
