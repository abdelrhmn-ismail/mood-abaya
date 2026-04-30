<?php

namespace Modules\Payment\Http\Controllers\Admin;

use App\Models\PaymentGatewaySetting;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TabbySettingsController
{
    /**
     * Show the Tabby settings form.
     */
    public function edit(): View
    {
        $settings  = PaymentGatewaySetting::allForGateway('tabby');
        $method    = PaymentMethod::where('code', 'tabby')->first();

        return view('payment::admin.tabby-settings', compact('settings', 'method'));
    }

    /**
     * Update Tabby settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'public_key'    => ['required', 'string', 'max:255'],
            'secret_key'    => ['required', 'string', 'max:255'],
            'merchant_code' => ['required', 'string', 'max:64'],
        ]);

        foreach ($validated as $key => $value) {
            PaymentGatewaySetting::setValue('tabby', $key, $value);
        }

        return redirect()
            ->route('admin.tabby-settings.edit')
            ->with('success', __('Tabby settings saved.'));
    }
}
