<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Seeds hero/slider images for the Mood Abaya store (women's modest wear: Abayas, Jilbabs, Hijabs).
 * Uses Unsplash URLs as defaults; replace with your own images via Admin → Settings or by updating these URLs.
 */
class HeroImagesSeeder extends Seeder
{
    /** Abaya / modest fashion themed images (e.g. elegant wear, fabrics, lifestyle). */
    private const HOME_SLIDER_IMAGES = [
        'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=1920', // elegant fashion
        'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1920', // style / fabric
        'https://images.unsplash.com/photo-1583391733982-1cfec2046952?w=1920', // women fashion
    ];

    /** Hero for About, Contact, Categories and other pages (elegant / modest look). */
    private const PAGE_HERO_IMAGE = 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1920';

    /** Cart & Account hero (softer / lifestyle). */
    private const CART_ACCOUNT_HERO = 'https://images.unsplash.com/photo-1524504388940-b1c172dc3dc1?w=1920';

    public function run(): void
    {
        // Home slider (3 images for hero carousel)
        foreach (['hero_home_1', 'hero_home_2', 'hero_home_3'] as $i => $key) {
            if (Setting::get($key, '') === '') {
                Setting::set($key, self::HOME_SLIDER_IMAGES[$i] ?? self::HOME_SLIDER_IMAGES[0]);
            }
        }

        // About page hero (static pages use hero_page)
        if (Setting::get('hero_page', '') === '') {
            Setting::set('hero_page', self::PAGE_HERO_IMAGE);
        }

        // Contact page hero
        if (Setting::get('hero_contact', '') === '') {
            Setting::set('hero_contact', self::PAGE_HERO_IMAGE);
        }

        // Categories page hero
        if (Setting::get('hero_categories', '') === '') {
            Setting::set('hero_categories', self::PAGE_HERO_IMAGE);
        }

        // Cart & Account heroes
        if (Setting::get('hero_cart', '') === '') {
            Setting::set('hero_cart', self::CART_ACCOUNT_HERO);
        }
        if (Setting::get('hero_account', '') === '') {
            Setting::set('hero_account', self::CART_ACCOUNT_HERO);
        }

        // Products list hero (if used)
        if (Setting::get('hero_products', '') === '') {
            Setting::set('hero_products', self::PAGE_HERO_IMAGE);
        }

        // Search hero (if used)
        if (Setting::get('hero_search', '') === '') {
            Setting::set('hero_search', self::PAGE_HERO_IMAGE);
        }
    }
}
