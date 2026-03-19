<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFrontendSettingsRequest extends FormRequest
{
    private const HERO_KEYS = [
        'hero_account', 'hero_cart', 'hero_checkout', 'hero_contact', 'hero_page', 'hero_search',
        'hero_categories', 'hero_products', 'hero_home_1', 'hero_home_2', 'hero_home_3',
    ];

    private const COLOR_KEYS = [
        'color_brand_black', 'color_brand_teal', 'color_brand_teal_dark',
        'color_brand_white', 'color_brand_gold', 'color_brand_gold_dark',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'site_logo' => 'nullable|string|max:500',
            'favicon' => 'nullable|string|max:500',
            'footer_tagline' => 'nullable|string|max:500',
            'logo_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'favicon_file' => 'nullable|file|mimes:ico,png,jpg|max:512',
            'announcement_bar_enabled' => 'nullable|boolean',
            'announcement_bar_text' => 'nullable|string|max:500',
            'announcement_bar_link' => 'nullable|string|max:500',
            'maintenance_mode_enabled' => 'nullable|boolean',
            'maintenance_coming_back_at' => 'nullable|string|max:100',
            'maintenance_ip_allowlist' => 'nullable|string|max:2000',
            'trust_badge_1' => 'nullable|string|max:255',
            'trust_badge_2' => 'nullable|string|max:255',
            'trust_badge_3' => 'nullable|string|max:255',
            'home_popup_enabled' => 'nullable|boolean',
            'home_popup_title' => 'nullable|string|max:255',
            'home_popup_content' => 'nullable|string|max:5000',
            'home_popup_image' => 'nullable|string|max:500',
            'home_popup_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'home_popup_button_text' => 'nullable|string|max:100',
            'home_popup_button_url' => 'nullable|string|max:500',
            'home_popup_delay_seconds' => 'nullable|integer|min:0|max:30',
            'home_popup_show_once_per_session' => 'nullable|boolean',
        ];

        foreach (self::HERO_KEYS as $key) {
            $rules[$key] = 'nullable|string|max:500';
            $rules['hero_file_' . $key] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        foreach (self::COLOR_KEYS as $k) {
            $rules[$k] = 'nullable|string|max:20';
        }

        return $rules;
    }
}
