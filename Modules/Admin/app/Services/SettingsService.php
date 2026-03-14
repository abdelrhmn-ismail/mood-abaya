<?php

namespace Modules\Admin\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingsService
{
    /** Site label keys (navbar, brand). Empty value = use translation. */
    public const LABEL_KEYS = [
        'site_name',
        'nav_home',
        'nav_categories',
        'nav_products',
        'nav_contact',
        'nav_cart',
        'nav_login',
        'nav_register',
        'nav_account',
        'nav_logout',
        'nav_admin',
    ];

    public function getSettings(): array
    {
        $labels = [];
        foreach (self::LABEL_KEYS as $key) {
            $labels[$key] = Setting::get('label_' . $key, '');
        }

        return [
            'locale' => Setting::locale(),
            'labels' => $labels,
            'site_logo' => Setting::get('site_logo', ''),
            'favicon' => Setting::get('favicon', ''),
            'footer_tagline' => Setting::get('footer_tagline', ''),
            'meta_title' => Setting::get('meta_title', ''),
            'meta_description' => Setting::get('meta_description', ''),
            'meta_keywords' => Setting::get('meta_keywords', ''),
            'og_image' => Setting::get('og_image', ''),
            'tinymce_api_key' => Setting::get('tinymce_api_key', ''),
            // Frontend hero/header images
            'hero_account' => Setting::get('hero_account', ''),
            'hero_cart' => Setting::get('hero_cart', ''),
            'hero_contact' => Setting::get('hero_contact', ''),
            'hero_page' => Setting::get('hero_page', ''),
            'hero_search' => Setting::get('hero_search', ''),
            'hero_categories' => Setting::get('hero_categories', ''),
            'hero_products' => Setting::get('hero_products', ''),
            'hero_home_1' => Setting::get('hero_home_1', ''),
            'hero_home_2' => Setting::get('hero_home_2', ''),
            'hero_home_3' => Setting::get('hero_home_3', ''),
        ];
    }

    public function updateSettings(array $data): void
    {
        if (isset($data['locale']) && in_array($data['locale'], ['en', 'ar'], true)) {
            Setting::set('locale', $data['locale']);
        }
        if (array_key_exists('site_logo', $data)) {
            Setting::set('site_logo', trim((string) ($data['site_logo'] ?? '')));
        }
        if (array_key_exists('favicon', $data)) {
            Setting::set('favicon', trim((string) ($data['favicon'] ?? '')));
        }
        if (array_key_exists('footer_tagline', $data)) {
            Setting::set('footer_tagline', trim((string) ($data['footer_tagline'] ?? '')));
        }
        if (isset($data['meta_title'])) {
            Setting::set('meta_title', trim((string) $data['meta_title']));
        }
        if (isset($data['meta_description'])) {
            Setting::set('meta_description', trim((string) $data['meta_description']));
        }
        if (isset($data['meta_keywords'])) {
            Setting::set('meta_keywords', trim((string) $data['meta_keywords']));
        }
        if (isset($data['og_image'])) {
            Setting::set('og_image', trim((string) $data['og_image']));
        }
        if (array_key_exists('tinymce_api_key', $data)) {
            Setting::set('tinymce_api_key', trim((string) ($data['tinymce_api_key'] ?? '')));
        }
        // Frontend hero/header images (simple URL or path strings)
        foreach (['hero_account', 'hero_cart', 'hero_contact', 'hero_page', 'hero_search', 'hero_categories', 'hero_products', 'hero_home_1', 'hero_home_2', 'hero_home_3'] as $key) {
            if (array_key_exists($key, $data)) {
                Setting::set($key, trim((string) ($data[$key] ?? '')));
            }
        }
        if (isset($data['labels']) && is_array($data['labels'])) {
            foreach (self::LABEL_KEYS as $key) {
                $value = trim($data['labels'][$key] ?? '');
                Setting::set('label_' . $key, $value);
            }
        }
        if (isset($data['lang_overrides']) && is_array($data['lang_overrides'])) {
            $en = $data['lang_overrides']['en'] ?? [];
            $ar = $data['lang_overrides']['ar'] ?? [];
            Setting::set('lang_overrides', json_encode(['en' => $en, 'ar' => $ar]));
        }
    }

    /**
     * Get all translation keys from lang JSON files (en + ar merged).
     * Returns [ 'key' => ['en' => '...', 'ar' => '...'], ... ]
     */
    public function getTranslationKeys(): array
    {
        $enPath = lang_path('en.json');
        $arPath = lang_path('ar.json');
        $en = [];
        $ar = [];
        if (File::exists($enPath)) {
            $en = json_decode(File::get($enPath), true) ?? [];
        }
        if (File::exists($arPath)) {
            $ar = json_decode(File::get($arPath), true) ?? [];
        }
        $keys = array_unique(array_merge(array_keys($en), array_keys($ar)));
        sort($keys);
        $overrides = Setting::get('lang_overrides');
        $dec = $overrides ? (json_decode($overrides, true) ?? []) : [];
        $out = [];
        foreach ($keys as $key) {
            $out[$key] = [
                'en' => $dec['en'][$key] ?? $en[$key] ?? '',
                'ar' => $dec['ar'][$key] ?? $ar[$key] ?? '',
            ];
        }
        return $out;
    }
}
