<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BillingAddress;
use App\Services\ShippingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Modules\Order\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(
        private CheckoutService $checkoutService,
        private ShippingService $shippingService
    ) {}

    public function show(Request $request): View|RedirectResponse
    {
        $zoneId = $request->query('shipping_zone_id');
        $data = $this->checkoutService->getCheckoutData($zoneId);
        if ($data['items']->isEmpty()) {
            return redirect()->route('cart')->with('error', __('Your cart is empty.'));
        }
        return view('frontend.checkout', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->checkoutService->getCheckoutData();
        if ($data['items']->isEmpty()) {
            return redirect()->route('cart')->with('error', __('Your cart is empty.'));
        }

        $codes = array_column(config('phone_codes', []), 'code');

        $rules = [
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash,bank'],
            'proof' => ['required_if:payment_method,bank', 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'billing_use' => ['required', 'in:saved,new'],
            'billing_address_id' => [
                'required_if:billing_use,saved',
                'nullable',
                'integer',
                Rule::exists('billing_addresses', 'id')->where('user_id', $request->user()->id),
            ],
            'billing_full_name' => ['required_if:billing_use,new', 'nullable', 'string', 'max:255'],
            'billing_phone_country_code' => ['required_if:billing_use,new', 'nullable', 'string', 'in:' . implode(',', $codes)],
            'billing_phone_number' => ['required_if:billing_use,new', 'nullable', 'string', 'max:20'],
            'billing_address_line_1' => ['required_if:billing_use,new', 'nullable', 'string', 'max:255'],
            'billing_address_line_2' => ['nullable', 'string', 'max:255'],
            'billing_city' => ['required_if:billing_use,new', 'nullable', 'string', 'max:100'],
            'billing_state' => ['nullable', 'string', 'max:100'],
            'billing_postal_code' => ['nullable', 'string', 'max:20'],
            'billing_country' => ['nullable', 'string', 'max:100'],
            'save_billing_address' => ['nullable', 'boolean'],
            'shipping_zone_id' => ['nullable', 'string', 'max:50'],
        ];

        $validated = $request->validate($rules);

        $subtotal = $this->checkoutService->getCheckoutData()['subtotal'];
        $zoneId = $validated['shipping_zone_id'] ?? null;
        if ($this->shippingService->getType() === 'zones' && $zoneId === null) {
            $zones = $this->shippingService->getZones();
            $zoneId = $zones[0]['id'] ?? null;
        }
        $shipping = $this->shippingService->calculate($subtotal, $zoneId);
        $shippingAmount = $shipping['amount'];
        $shippingLabel = $shipping['label'];

        $notes = $validated['notes'] ?? null;

        if ($validated['billing_use'] === 'saved' && ! empty($validated['billing_address_id'])) {
            $saved = BillingAddress::where('user_id', $request->user()->id)->findOrFail($validated['billing_address_id']);
            $address = [
                'full_name' => $saved->full_name,
                'phone' => $saved->phone,
                'address_line_1' => $saved->address_line_1,
                'address_line_2' => $saved->address_line_2,
                'city' => $saved->city,
                'state' => $saved->state,
                'postal_code' => $saved->postal_code,
                'country' => $saved->country,
                'notes' => $notes,
            ];
        } else {
            $address = [
                'full_name' => $validated['billing_full_name'],
                'phone' => $request->phoneWithCode('billing_phone'),
                'address_line_1' => $validated['billing_address_line_1'],
                'address_line_2' => $validated['billing_address_line_2'] ?? null,
                'city' => $validated['billing_city'],
                'state' => $validated['billing_state'] ?? null,
                'postal_code' => $validated['billing_postal_code'] ?? null,
                'country' => $validated['billing_country'] ?? 'Saudi Arabia',
                'notes' => $notes,
            ];
            // Always save new billing address at checkout so it appears in Account → Addresses
            $setAsDefault = $request->boolean('save_billing_address');
            $hasExisting = BillingAddress::where('user_id', $request->user()->id)->exists();
            if ($setAsDefault && $hasExisting) {
                BillingAddress::where('user_id', $request->user()->id)->update(['is_default' => false]);
            }
            BillingAddress::create([
                'user_id' => $request->user()->id,
                'label' => null,
                'full_name' => $address['full_name'],
                'phone' => $address['phone'],
                'address_line_1' => $address['address_line_1'],
                'address_line_2' => $address['address_line_2'],
                'city' => $address['city'],
                'state' => $address['state'],
                'postal_code' => $address['postal_code'],
                'country' => $address['country'],
                'is_default' => ! $hasExisting || $setAsDefault,
            ]);
        }

        try {
            $order = $this->checkoutService->placeOrder(
                $address,
                $validated['payment_method'],
                $request->file('proof'),
                $address,
                $shippingAmount,
                $shippingLabel
            );
            return redirect()
                ->route('order.confirmed', $order->order_number)
                ->with('success', __('Order placed successfully.'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('cart')->with('error', $e->getMessage());
        }
    }
}
