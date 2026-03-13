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
