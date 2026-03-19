<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\UpdateFrontendSettingsRequest;
use Modules\Admin\Http\Requests\UpdateSettingsRequest;
use Modules\Admin\Http\Requests\UpdateTranslationsRequest;
use Modules\Admin\Services\SettingsService;

class SettingsController
{
    private const HERO_KEYS = [
        'hero_account', 'hero_cart', 'hero_checkout', 'hero_contact', 'hero_page', 'hero_search',
        'hero_categories', 'hero_products', 'hero_home_1', 'hero_home_2', 'hero_home_3',
    ];

    public function edit(SettingsService $settingsService): View
    {
        $settings = $settingsService->getSettings();

        return view('admin::settings.edit', compact('settings'));
    }

    public function update(UpdateSettingsRequest $request, SettingsService $settingsService): RedirectResponse
    {
        $settingsService->updateSettings($request->only(
            'locale', 'site_name', 'meta_title', 'meta_description', 'meta_keywords',
            'og_image', 'tinymce_api_key', 'whatsapp_url', 'instagram_url', 'facebook_url',
            'twitter_url', 'contact_email', 'contact_email_secondary', 'contact_location',
            'contact_phone', 'contact_phone_secondary', 'custom_code_header', 'custom_code_footer',
            'shipping_type', 'shipping_flat_rate', 'shipping_free_over', 'shipping_zones',
        ));

        return redirect()->route('admin.settings.edit')->with('success', __('Settings saved.'));
    }

    public function translations(SettingsService $settingsService): View
    {
        $translations = $settingsService->getTranslationKeys();

        return view('admin::settings.translations', compact('translations'));
    }

    public function updateTranslations(UpdateTranslationsRequest $request, SettingsService $settingsService): RedirectResponse
    {
        $translations = $request->input('translations', []);
        $en = [];
        $ar = [];
        foreach ($translations as $key => $vals) {
            if (is_string($key) && is_array($vals)) {
                $en[$key] = trim($vals['en'] ?? '');
                $ar[$key] = trim($vals['ar'] ?? '');
            }
        }

        $settingsService->updateSettings(['lang_overrides' => ['en' => $en, 'ar' => $ar]]);

        return redirect()->route('admin.translations.index')->with('success', __('Translations saved.'));
    }

    public function frontend(SettingsService $settingsService): View
    {
        $settings = $settingsService->getSettings();

        return view('admin::settings.frontend', compact('settings'));
    }

    public function updateFrontend(UpdateFrontendSettingsRequest $request, SettingsService $settingsService): RedirectResponse
    {
        $frontendKeys = array_merge(
            ['site_logo', 'favicon', 'footer_tagline'],
            self::HERO_KEYS,
            [
                'announcement_bar_enabled', 'announcement_bar_text', 'announcement_bar_link',
                'maintenance_mode_enabled', 'maintenance_coming_back_at', 'maintenance_ip_allowlist',
                'trust_badge_1', 'trust_badge_2', 'trust_badge_3',
                'home_popup_enabled', 'home_popup_title', 'home_popup_content', 'home_popup_image',
                'home_popup_button_text', 'home_popup_button_url', 'home_popup_delay_seconds',
                'home_popup_show_once_per_session',
            ],
            $settingsService->getColorKeys()
        );

        $data = $request->only($frontendKeys);
        $data['announcement_bar_enabled'] = $request->boolean('announcement_bar_enabled');
        $data['maintenance_mode_enabled'] = $request->boolean('maintenance_mode_enabled');
        $data['home_popup_enabled'] = $request->boolean('home_popup_enabled');
        $data['home_popup_show_once_per_session'] = $request->boolean('home_popup_show_once_per_session');

        $settingsService->processFileUploads($request, $data);
        $settingsService->updateSettings($data);

        return redirect()->route('admin.settings.frontend')->with('success', __('Settings saved.'));
    }
}
