<?php

use App\Models\Setting;

if (!function_exists('site_label')) {
    /**
     * Get a site label (admin-editable). Falls back to translation or config.
     *
     * @param  string  $key  Key without "label_" prefix (e.g. site_name, nav_home)
     * @return string
     */
    function site_label(string $key): string
    {
        try {
            $value = Setting::get('label_' . $key);
            if ($value !== null && $value !== '') {
                return (string) $value;
            }
        } catch (\Throwable) {
            // Table may not exist during install
        }

        $defaults = [
            'site_name' => null,
            'nav_home' => 'Home',
            'nav_categories' => 'Categories',
            'nav_products' => 'Products',
            'nav_contact' => 'Contact',
            'nav_cart' => 'Cart',
            'nav_login' => 'Login',
            'nav_register' => 'Register',
            'nav_account' => 'Account',
            'nav_logout' => 'Logout',
            'nav_admin' => 'Admin',
        ];

        if ($key === 'site_name') {
            return (string) config('app.name');
        }

        $translationKey = $defaults[$key] ?? str_replace('_', ' ', ucfirst($key));

        return (string) __($translationKey);
    }
}

if (!function_exists('site_logo_url')) {
    /**
     * Get the site logo URL (admin-editable). Returns null if not set.
     */
    function site_logo_url(): ?string
    {
        $val = Setting::get('site_logo', '');
        if ($val === null || $val === '') {
            return null;
        }
        return str_starts_with($val, 'http') ? $val : \Illuminate\Support\Facades\Storage::url($val);
    }
}

if (!function_exists('site_favicon_url')) {
    /**
     * Get the site favicon URL (admin-editable). Returns null if not set.
     */
    function site_favicon_url(): ?string
    {
        $val = Setting::get('favicon', '');
        if ($val === null || $val === '') {
            return null;
        }
        return str_starts_with($val, 'http') ? $val : \Illuminate\Support\Facades\Storage::url($val);
    }
}

if (!function_exists('footer_tagline')) {
    /**
     * Get the footer tagline (admin-editable). Falls back to translation if empty.
     */
    function footer_tagline(): string
    {
        $val = Setting::get('footer_tagline', '');
        if ($val !== null && $val !== '') {
            return trim((string) $val);
        }
        return (string) __('Quality products for everyone. Shop with confidence.');
    }
}

if (!function_exists('safe_html')) {
    /**
     * Sanitize HTML for safe output (e.g. rich text descriptions).
     * Allows a limited set of tags to prevent XSS.
     *
     * @param  string|null  $html
     * @return string
     */
    function safe_html(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }
        $allowed = '<p><br><strong><b><em><i><u><ul><ol><li><a><h2><h3><h4><span><div>';
        return strip_tags($html, $allowed);
    }
}
