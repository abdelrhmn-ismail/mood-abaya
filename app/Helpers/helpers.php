<?php

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if (!function_exists('site_label')) {
    /**
     * Get a site label. Uses Translations (admin/translations) for navbar/footer text.
     *
     * @param  string  $key  e.g. site_name, nav_home, nav_categories
     * @return string
     */
    function site_label(string $key): string
    {
        $translationKeys = [
            'site_name' => 'Site name',
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
            try {
                $v = \App\Models\Setting::get('site_name', '');
                if ($v !== null && $v !== '') {
                    return (string) $v;
                }
            } catch (\Throwable) {
            }
            $v = __($translationKeys['site_name']);
            return $v !== 'Site name' ? $v : (string) config('app.name');
        }

        $translationKey = $translationKeys[$key] ?? str_replace('_', ' ', ucfirst($key));
        return (string) __($translationKey);
    }
}

if (!function_exists('site_title')) {
    /**
     * Site display name for page titles, admin chrome, and suffixes. Uses Settings site_name, else APP_NAME.
     */
    function site_title(): string
    {
        try {
            $v = Setting::get('site_name', '');
            if ($v !== null && trim((string) $v) !== '') {
                return trim((string) $v);
            }
        } catch (\Throwable) {
        }

        return (string) config('app.name');
    }
}

if (!function_exists('payment_method_label')) {
    /**
     * Human-readable payment method name for order receipts (from configured methods).
     */
    function payment_method_label(?string $code): string
    {
        if ($code === null || $code === '') {
            return '';
        }

        return app(\Modules\Payment\Services\PaymentMethodService::class)->labelForCode($code);
    }
}

if (!function_exists('site_logo_url')) {
    function site_logo_url(): ?string
    {
        return get_image_url(Setting::get('site_logo', ''));
    }
}

if (!function_exists('site_favicon_url')) {
    function site_favicon_url(): ?string
    {
        return get_image_url(Setting::get('favicon', ''));
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

if (!function_exists('upload_image')) {
    /**
     * Upload an image file to the given storage directory.
     *
     * @param  UploadedFile  $file     The uploaded file instance
     * @param  string        $directory  Storage subdirectory (e.g. 'products', 'branding', 'posts')
     * @param  string        $disk       Storage disk name
     * @return string|null  The stored path, or null on failure
     */
    function upload_image(UploadedFile $file, string $directory, string $disk = 'public'): ?string
    {
        if (!$file->isValid()) {
            return null;
        }

        return $file->store($directory, $disk) ?: null;
    }
}

if (!function_exists('delete_image')) {
    /**
     * Delete an image from storage if the path is a local storage path (not an external URL).
     *
     * @param  string|null  $path  The stored path (e.g. 'products/abc.jpg')
     * @param  string       $disk  Storage disk name
     */
    function delete_image(?string $path, string $disk = 'public'): void
    {
        if ($path && !str_starts_with($path, 'http')) {
            Storage::disk($disk)->delete($path);
        }
    }
}

if (!function_exists('get_image_url')) {
    /**
     * Resolve a stored image path or external URL to a full public URL.
     *
     * @param  string|null  $value  Stored path or external URL
     * @return string|null  The public URL, or null if empty
     */
    function get_image_url(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return str_starts_with($value, 'http') ? $value : Storage::url($value);
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
