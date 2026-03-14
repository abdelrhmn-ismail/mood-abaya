<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Admin\Services\SettingsService;
use Illuminate\Support\Facades\Storage;

class SettingsController
{
    private const HERO_KEYS = [
        'hero_account',
        'hero_cart',
        'hero_contact',
        'hero_page',
        'hero_search',
        'hero_categories',
        'hero_products',
        'hero_home_1',
        'hero_home_2',
        'hero_home_3',
    ];

    public function edit(SettingsService $settingsService): View
    {
        $settings = $settingsService->getSettings();

        return view('admin::settings.edit', compact('settings'));
    }

    public function update(Request $request, SettingsService $settingsService): RedirectResponse
    {
        $rules = [
            'locale' => 'required|in:en,ar',
            'site_logo' => 'nullable|string|max:500',
            'favicon' => 'nullable|string|max:500',
            'footer_tagline' => 'nullable|string|max:500',
            'logo_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'favicon_file' => 'nullable|file|mimes:ico,png,jpg|max:512',
            'labels' => 'nullable|array',
            'labels.*' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'tinymce_api_key' => 'nullable|string|max:255',
            'hero_account' => 'nullable|string|max:500',
            'hero_cart' => 'nullable|string|max:500',
            'hero_contact' => 'nullable|string|max:500',
            'hero_page' => 'nullable|string|max:500',
            'hero_search' => 'nullable|string|max:500',
            'hero_categories' => 'nullable|string|max:500',
            'hero_products' => 'nullable|string|max:500',
            'hero_home_1' => 'nullable|string|max:500',
            'hero_home_2' => 'nullable|string|max:500',
            'hero_home_3' => 'nullable|string|max:500',
        ];
        foreach (self::HERO_KEYS as $key) {
            $rules['hero_file_' . $key] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }
        $request->validate($rules);

        $data = $request->only(
            'locale',
            'site_logo',
            'favicon',
            'footer_tagline',
            'labels',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'og_image',
            'tinymce_api_key',
            'hero_account',
            'hero_cart',
            'hero_contact',
            'hero_page',
            'hero_search',
            'hero_categories',
            'hero_products',
            'hero_home_1',
            'hero_home_2',
            'hero_home_3'
        );

        foreach (self::HERO_KEYS as $key) {
            $fileKey = 'hero_file_' . $key;
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $path = $file->store('hero', 'public');
                if ($path) {
                    $data[$key] = $path;
                }
            }
        }

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('branding', 'public');
            if ($path) {
                $data['site_logo'] = $path;
            }
        }
        if ($request->hasFile('favicon_file')) {
            $path = $request->file('favicon_file')->store('branding', 'public');
            if ($path) {
                $data['favicon'] = $path;
            }
        }

        $settingsService->updateSettings($data);

        return redirect()->route('admin.settings.edit')->with('success', __('Settings saved.'));
    }

    public function translations(SettingsService $settingsService): View
    {
        $translations = $settingsService->getTranslationKeys();

        return view('admin::settings.translations', compact('translations'));
    }

    public function updateTranslations(Request $request, SettingsService $settingsService): RedirectResponse
    {
        $request->validate([
            'translations' => 'required|array',
            'translations.*.en' => 'nullable|string|max:1000',
            'translations.*.ar' => 'nullable|string|max:1000',
        ]);
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
}
