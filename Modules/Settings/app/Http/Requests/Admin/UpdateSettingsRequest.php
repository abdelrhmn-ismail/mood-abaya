<?php

namespace Modules\Settings\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'locale' => 'required|in:en,ar',
            'site_name' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'tinymce_api_key' => 'nullable|string|max:255',
            'whatsapp_url' => 'nullable|string|max:500',
            'instagram_url' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|string|max:500',
            'twitter_url' => 'nullable|string|max:500',
            'contact_email' => 'nullable|string|max:255',
            'contact_email_secondary' => 'nullable|string|max:255',
            'contact_location' => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:100',
            'contact_phone_secondary' => 'nullable|string|max:100',
            'custom_code_header' => 'nullable|string|max:15000',
            'custom_code_footer' => 'nullable|string|max:15000',
            'shipping_type' => 'nullable|string|in:flat,free_over,zones',
            'shipping_flat_rate' => 'nullable|numeric|min:0',
            'shipping_free_over' => 'nullable|numeric|min:0',
            'shipping_zones' => 'nullable|string|max:2000',
        ];
    }
}
