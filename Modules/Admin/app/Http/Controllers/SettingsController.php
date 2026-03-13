<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Admin\Services\SettingsService;

class SettingsController
{
    public function edit(SettingsService $settingsService): View
    {
        $settings = $settingsService->getSettings();

        return view('admin::settings.edit', compact('settings'));
    }

    public function update(Request $request, SettingsService $settingsService): RedirectResponse
    {
        $request->validate([
            'locale' => 'required|in:en,ar',
            'theme' => 'required|in:light,dark,system',
            'labels' => 'nullable|array',
            'labels.*' => 'nullable|string|max:255',
        ]);

        $settingsService->updateSettings($request->only('locale', 'theme', 'labels'));

        return redirect()->route('admin.settings.edit')->with('success', __('Settings saved.'));
    }
}
