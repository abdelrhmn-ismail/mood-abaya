<?php

namespace Modules\Admin\Services;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsService
{
    private const HERO_KEYS = [
        'hero_account', 'hero_cart', 'hero_checkout', 'hero_contact', 'hero_page', 'hero_search',
        'hero_categories', 'hero_products', 'hero_home_1', 'hero_home_2', 'hero_home_3',
    ];

    private const COLOR_KEYS = [
        'color_brand_black', 'color_brand_teal', 'color_brand_teal_dark',
        'color_brand_white', 'color_brand_gold', 'color_brand_gold_dark',
    ];

    private const COLOR_DEFAULTS = [
        'color_brand_black' => '#000000',
        'color_brand_teal' => '#144034',
        'color_brand_teal_dark' => '#0f2d26',
        'color_brand_white' => '#FFFFFF',
        'color_brand_gold' => '#D3AE72',
        'color_brand_gold_dark' => '#b8945c',
    ];

    public function getSettings(): array
    {
        return [
            'locale' => Setting::locale(),
            'site_name' => Setting::get('site_name', ''),
            'site_logo' => Setting::get('site_logo', ''),
            'favicon' => Setting::get('favicon', ''),
            'footer_tagline' => Setting::get('footer_tagline', ''),
            'meta_title' => Setting::get('meta_title', ''),
            'meta_description' => Setting::get('meta_description', ''),
            'meta_keywords' => Setting::get('meta_keywords', ''),
            'og_image' => Setting::get('og_image', ''),
            'tinymce_api_key' => Setting::get('tinymce_api_key', ''),
            ...array_combine(self::HERO_KEYS, array_map(fn ($k) => Setting::get($k, ''), self::HERO_KEYS)),
            'whatsapp_url' => Setting::get('whatsapp_url', ''),
            'instagram_url' => Setting::get('instagram_url', ''),
            'facebook_url' => Setting::get('facebook_url', ''),
            'twitter_url' => Setting::get('twitter_url', ''),
            'contact_email' => Setting::get('contact_email', ''),
            'contact_email_secondary' => Setting::get('contact_email_secondary', ''),
            'contact_location' => Setting::get('contact_location', ''),
            'contact_phone' => Setting::get('contact_phone', ''),
            'contact_phone_secondary' => Setting::get('contact_phone_secondary', ''),
            'custom_code_header' => Setting::get('custom_code_header', ''),
            'custom_code_footer' => Setting::get('custom_code_footer', ''),
            'announcement_bar_enabled' => Setting::get('announcement_bar_enabled', '0'),
            'announcement_bar_text' => Setting::get('announcement_bar_text', ''),
            'announcement_bar_link' => Setting::get('announcement_bar_link', ''),
            'shipping_type' => Setting::get('shipping_type', 'flat'),
            'shipping_flat_rate' => Setting::get('shipping_flat_rate', '0'),
            'shipping_free_over' => Setting::get('shipping_free_over', ''),
            'shipping_zones' => Setting::get('shipping_zones', ''),
            'maintenance_mode_enabled' => Setting::get('maintenance_mode_enabled', '0'),
            'maintenance_coming_back_at' => Setting::get('maintenance_coming_back_at', ''),
            'maintenance_ip_allowlist' => Setting::get('maintenance_ip_allowlist', ''),
            'trust_badge_1' => Setting::get('trust_badge_1', ''),
            'trust_badge_2' => Setting::get('trust_badge_2', ''),
            'trust_badge_3' => Setting::get('trust_badge_3', ''),
            ...array_combine(
                self::COLOR_KEYS,
                array_map(fn ($k) => Setting::get($k, self::COLOR_DEFAULTS[$k]), self::COLOR_KEYS)
            ),
            'home_popup_enabled' => Setting::get('home_popup_enabled', '0'),
            'home_popup_title' => Setting::get('home_popup_title', ''),
            'home_popup_content' => Setting::get('home_popup_content', ''),
            'home_popup_image' => Setting::get('home_popup_image', ''),
            'home_popup_button_text' => Setting::get('home_popup_button_text', ''),
            'home_popup_button_url' => Setting::get('home_popup_button_url', ''),
            'home_popup_delay_seconds' => Setting::get('home_popup_delay_seconds', '2'),
            'home_popup_show_once_per_session' => Setting::get('home_popup_show_once_per_session', '1'),
        ];
    }

    public function getColorDefaults(): array
    {
        return self::COLOR_DEFAULTS;
    }

    public function getColorKeys(): array
    {
        return self::COLOR_KEYS;
    }

    /**
     * Process file uploads from the frontend settings form and merge into data array.
     */
    public function processFileUploads(Request $request, array &$data): void
    {
        foreach (self::HERO_KEYS as $key) {
            if ($request->hasFile('hero_file_' . $key)) {
                $path = upload_image($request->file('hero_file_' . $key), 'hero');
                if ($path) {
                    $data[$key] = $path;
                }
            }
        }

        if ($request->hasFile('logo_file')) {
            $path = upload_image($request->file('logo_file'), 'branding');
            if ($path) {
                $data['site_logo'] = $path;
            }
        }

        if ($request->hasFile('favicon_file')) {
            $path = upload_image($request->file('favicon_file'), 'branding');
            if ($path) {
                $data['favicon'] = $path;
            }
        }

        if ($request->hasFile('home_popup_image_file')) {
            $path = upload_image($request->file('home_popup_image_file'), 'popup');
            if ($path) {
                $data['home_popup_image'] = $path;
            }
        }
    }

    public function updateSettings(array $data): void
    {
        $this->updateStringSettings($data, ['site_name', 'site_logo', 'favicon', 'footer_tagline']);
        $this->updateStringSettings($data, ['meta_title', 'meta_description', 'meta_keywords', 'og_image', 'tinymce_api_key']);
        $this->updateStringSettings($data, self::HERO_KEYS);
        $this->updateStringSettings($data, [
            'whatsapp_url', 'instagram_url', 'facebook_url', 'twitter_url',
            'contact_email', 'contact_email_secondary', 'contact_location',
            'contact_phone', 'contact_phone_secondary',
        ]);
        $this->updateStringSettings($data, ['trust_badge_1', 'trust_badge_2', 'trust_badge_3']);
        $this->updateStringSettings($data, [
            'home_popup_title', 'home_popup_content', 'home_popup_image',
            'home_popup_button_text', 'home_popup_button_url',
        ]);
        $this->updateStringSettings($data, ['announcement_bar_text', 'announcement_bar_link']);
        $this->updateStringSettings($data, ['maintenance_coming_back_at', 'maintenance_ip_allowlist']);

        if (isset($data['locale']) && in_array($data['locale'], ['en', 'ar'], true)) {
            Setting::set('locale', $data['locale']);
        }

        foreach (['custom_code_header', 'custom_code_footer'] as $key) {
            if (array_key_exists($key, $data)) {
                Setting::set($key, (string) ($data[$key] ?? ''));
            }
        }

        $this->updateBooleanSettings($data, [
            'announcement_bar_enabled', 'maintenance_mode_enabled',
            'home_popup_enabled', 'home_popup_show_once_per_session',
        ]);

        foreach (['shipping_type', 'shipping_flat_rate', 'shipping_free_over', 'shipping_zones'] as $key) {
            if (array_key_exists($key, $data)) {
                $v = $data[$key];
                Setting::set($key, is_array($v) ? json_encode($v) : (string) $v);
            }
        }

        $this->updateColorSettings($data);

        if (array_key_exists('home_popup_delay_seconds', $data)) {
            $v = (int) ($data['home_popup_delay_seconds'] ?? 0);
            Setting::set('home_popup_delay_seconds', (string) max(0, min(30, $v)));
        }

        if (isset($data['lang_overrides']) && is_array($data['lang_overrides'])) {
            $en = $data['lang_overrides']['en'] ?? [];
            $ar = $data['lang_overrides']['ar'] ?? [];
            Setting::set('lang_overrides', json_encode(['en' => $en, 'ar' => $ar]));
        }
    }

    public function getTranslationKeys(): array
    {
        $enPath = lang_path('en.json');
        $arPath = lang_path('ar.json');
        $en = File::exists($enPath) ? (json_decode(File::get($enPath), true) ?? []) : [];
        $ar = File::exists($arPath) ? (json_decode(File::get($arPath), true) ?? []) : [];

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

    private function updateStringSettings(array $data, array $keys): void
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                Setting::set($key, trim((string) ($data[$key] ?? '')));
            }
        }
    }

    private function updateBooleanSettings(array $data, array $keys): void
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                Setting::set($key, ($data[$key] ?? false) ? '1' : '0');
            }
        }
    }

    private function updateColorSettings(array $data): void
    {
        foreach (self::COLOR_KEYS as $key) {
            if (array_key_exists($key, $data)) {
                $v = trim((string) ($data[$key] ?? ''));
                if ($v === '') {
                    continue;
                }
                if (!str_starts_with($v, '#')) {
                    $v = '#' . $v;
                }
                if (preg_match('/^#[a-fA-F0-9]{6}$/', $v)) {
                    Setting::set($key, $v);
                }
            }
        }
    }
}
