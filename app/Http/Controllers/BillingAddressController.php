<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingAddressController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $codes = array_column(config('phone_codes', []), 'code');
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'label' => ['nullable', 'string', 'max:100'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone_country_code' => ['required', 'string', 'in:' . implode(',', $codes)],
            'phone_number' => ['required', 'string', 'max:20'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('account')->withFragment('addresses')->withInput()->withErrors($validator);
        }

        $validated = $validator->validated();
        $validated['user_id'] = $request->user()->id;
        $validated['phone'] = $request->phoneWithCode('phone');
        unset($validated['phone_country_code'], $validated['phone_number']);
        $validated['country'] = $validated['country'] ?? 'Saudi Arabia';
        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            BillingAddress::where('user_id', $request->user()->id)->update(['is_default' => false]);
        }

        BillingAddress::create($validated);

        return redirect()->route('account')->withFragment('addresses')
            ->with('success', __('Address added.'));
    }

    public function update(Request $request, BillingAddress $billingAddress): RedirectResponse
    {
        if ($billingAddress->user_id !== $request->user()->id) {
            abort(403);
        }

        $codes = array_column(config('phone_codes', []), 'code');
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:100'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone_country_code' => ['required', 'string', 'in:' . implode(',', $codes)],
            'phone_number' => ['required', 'string', 'max:20'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $validated['phone'] = $request->phoneWithCode('phone');
        unset($validated['phone_country_code'], $validated['phone_number']);
        $validated['is_default'] = $request->boolean('is_default');
        if ($validated['is_default']) {
            BillingAddress::where('user_id', $request->user()->id)
                ->where('id', '!=', $billingAddress->id)
                ->update(['is_default' => false]);
        }

        $billingAddress->update($validated);

        return redirect()->route('account')->withFragment('addresses')
            ->with('success', __('Address updated.'));
    }

    public function destroy(Request $request, BillingAddress $billingAddress): RedirectResponse
    {
        if ($billingAddress->user_id !== $request->user()->id) {
            abort(403);
        }
        $billingAddress->delete();
        return redirect()->route('account')->withFragment('addresses')
            ->with('success', __('Address removed.'));
    }
}
