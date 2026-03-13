<?php

namespace Modules\Admin\Services;

use App\Models\Setting;

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
            'theme' => Setting::defaultTheme(),
            'labels' => $labels,
        ];
    }

    public function updateSettings(array $data): void
    {
        if (isset($data['locale']) && in_array($data['locale'], ['en', 'ar'], true)) {
            Setting::set('locale', $data['locale']);
        }
        if (isset($data['theme']) && in_array($data['theme'], ['light', 'dark', 'system'], true)) {
            Setting::set('theme', $data['theme']);
        }
        if (isset($data['labels']) && is_array($data['labels'])) {
            foreach (self::LABEL_KEYS as $key) {
                $value = trim($data['labels'][$key] ?? '');
                Setting::set('label_' . $key, $value);
            }
        }
    }
}
