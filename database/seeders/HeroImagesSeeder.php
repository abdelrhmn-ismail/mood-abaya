<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Seeds hero/slider images for the Mood Abaya store (women's modest wear: Abayas, Jilbabs, Hijabs).
 * Uses Unsplash URLs as defaults; replace with your own images via Admin → Settings.
 * Ensures every hero key has a default image (no missed keys).
 */
class HeroImagesSeeder extends Seeder
{
    /**
     * All hero setting keys and their default image URLs.
     * Elegant / modest fashion themed (abaya, jilbab, hijab, fabrics, lifestyle).
     */
    private const HERO_DEFAULTS = [
        // Home slider (3 images for hero carousel)
        'hero_home_1' => 'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=1920',
        'hero_home_2' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1920',
        'hero_home_3' => 'https://images.unsplash.com/photo-1583391733982-1cfec2046952?w=1920',
        // Page heroes (elegant / modest look – distinct per context where useful)
        'hero_page'       => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1920',
        'hero_contact'    => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920',
        'hero_categories' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920',
        'hero_products'   => 'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=1920',
        'hero_search'     => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=1920',
        // Cart & Account (softer / lifestyle)
        'hero_cart'    => 'https://images.unsplash.com/photo-1524504388940-b1c172dc3dc1?w=1920',
        'hero_account' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=1920',
    ];

    public function run(): void
    {
        foreach (self::HERO_DEFAULTS as $key => $defaultUrl) {
            $current = Setting::get($key, '');
            if ($this->isEmpty($current)) {
                Setting::set($key, $defaultUrl);
            }
        }
    }

    private function isEmpty(mixed $value): bool
    {
        if ($value === null) {
            return true;
        }
        $trimmed = is_string($value) ? trim($value) : (string) $value;

        return $trimmed === '';
    }
}
