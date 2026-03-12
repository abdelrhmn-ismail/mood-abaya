<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Order\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(
        private CheckoutService $checkoutService
    ) {
        $this->middleware('auth');
    }

    public function show(): View|RedirectResponse
    {
        $data = $this->checkoutService->getCheckoutData();
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

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash,bank'],
            'proof' => ['required_if:payment_method,bank', 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $address = [
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'notes' => $validated['notes'] ?? null,
        ];

        try {
            $order = $this->checkoutService->placeOrder(
                $address,
                $validated['payment_method'],
                $request->file('proof')
            );
            return redirect()
                ->route('order.confirmed', $order->order_number)
                ->with('success', __('Order placed successfully.'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('cart')->with('error', $e->getMessage());
        }
    }
}
