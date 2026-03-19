<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillingAddressRequest;
use App\Models\BillingAddress;
use App\Services\BillingAddressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BillingAddressController extends Controller
{
    public function __construct(private BillingAddressService $billingAddressService) {}

    public function store(StoreBillingAddressRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['phone'] = $request->phoneWithCode('phone');
        unset($validated['phone_country_code'], $validated['phone_number']);
        $validated['country'] = $validated['country'] ?? 'Saudi Arabia';
        $validated['is_default'] = $request->boolean('is_default');

        $this->billingAddressService->create($request->user()->id, $validated);

        return redirect()->route('account')->withFragment('addresses')
            ->with('success', __('Address added.'));
    }

    public function update(StoreBillingAddressRequest $request, BillingAddress $billingAddress): RedirectResponse
    {
        if ($billingAddress->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validated();
        $validated['phone'] = $request->phoneWithCode('phone');
        unset($validated['phone_country_code'], $validated['phone_number']);
        $validated['is_default'] = $request->boolean('is_default');

        $this->billingAddressService->update($billingAddress, $validated);

        return redirect()->route('account')->withFragment('addresses')
            ->with('success', __('Address updated.'));
    }

    public function destroy(Request $request, BillingAddress $billingAddress): RedirectResponse
    {
        if ($billingAddress->user_id !== $request->user()->id) {
            abort(403);
        }

        $this->billingAddressService->delete($billingAddress);

        return redirect()->route('account')->withFragment('addresses')
            ->with('success', __('Address removed.'));
    }
}
