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

/** Contact & social (admin-editable). Return empty string if not set. */
if (!function_exists('site_whatsapp_url')) {
    function site_whatsapp_url(): string
    {
        return trim((string) Setting::get('whatsapp_url', ''));
    }
}
if (!function_exists('site_instagram_url')) {
    function site_instagram_url(): string
    {
        return trim((string) Setting::get('instagram_url', ''));
    }
}
if (!function_exists('site_facebook_url')) {
    function site_facebook_url(): string
    {
        return trim((string) Setting::get('facebook_url', ''));
    }
}
if (!function_exists('site_twitter_url')) {
    function site_twitter_url(): string
    {
        return trim((string) Setting::get('twitter_url', ''));
    }
}
if (!function_exists('site_email')) {
    function site_email(): string
    {
        return trim((string) Setting::get('contact_email', ''));
    }
}
if (!function_exists('site_email_secondary')) {
    function site_email_secondary(): string
    {
        return trim((string) Setting::get('contact_email_secondary', ''));
    }
}
if (!function_exists('site_location')) {
    function site_location(): string
    {
        return trim((string) Setting::get('contact_location', ''));
    }
}
if (!function_exists('site_phone')) {
    function site_phone(): string
    {
        return trim((string) Setting::get('contact_phone', ''));
    }
}
if (!function_exists('site_phone_secondary')) {
    function site_phone_secondary(): string
    {
        return trim((string) Setting::get('contact_phone_secondary', ''));
    }
}

if (!function_exists('trust_badges')) {
    /** @return array{0: string, 1: string, 2: string} */
    function trust_badges(): array
    {
        return [
            trim((string) Setting::get('trust_badge_1', '')),
            trim((string) Setting::get('trust_badge_2', '')),
            trim((string) Setting::get('trust_badge_3', '')),
        ];
    }
}

/** Admin list default per-page and allowed options (for paginated tables). */
if (!function_exists('admin_per_page_default')) {
    function admin_per_page_default(): int
    {
        return 20;
    }
}
if (!function_exists('admin_per_page_options')) {
    /** @return array<int, int> */
    function admin_per_page_options(): array
    {
        return [10, 20, 50, 100];
    }
}
if (!function_exists('admin_per_page')) {
    /** Resolve per_page from request: allowed 10, 20, 50, 100; default 20. */
    function admin_per_page(): int
    {
        $v = (int) request('per_page', admin_per_page_default());
        return in_array($v, admin_per_page_options(), true) ? $v : admin_per_page_default();
    }
}

if (!function_exists('admin_sort_url')) {
    /**
     * Build URL for table column sort: preserves query params, sets sort and order.
     * If sorting by same column, toggles asc/desc; else sorts by column asc.
     *
     * @param  string  $sortKey  Column key to sort by (e.g. created_at, name)
     */
    function admin_sort_url(string $sortKey): string
    {
        $query = request()->query();
        $currentSort = $query['sort'] ?? null;
        $currentOrder = $query['order'] ?? 'desc';
        $order = ($currentSort === $sortKey && $currentOrder === 'asc') ? 'desc' : 'asc';
        $query['sort'] = $sortKey;
        $query['order'] = $order;
        return request()->url() . '?' . http_build_query($query);
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
