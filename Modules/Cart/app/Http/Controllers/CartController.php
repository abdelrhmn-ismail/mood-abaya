<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Cart\Services\CartService;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function index(): RedirectResponse
    {
        return redirect()->route('account')->withFragment('cart');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);
        $this->cartService->addItem(
            (int) $request->product_id,
            (int) ($request->quantity ?? 1)
        );
        return redirect()->route('account')->withFragment('cart')->with('success', __('Item added to cart.'));
    }

    public function update(Request $request, int $item): RedirectResponse
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:0', 'max:999']]);
        $this->cartService->updateQuantity($item, (int) $request->quantity);
        return redirect()->route('account')->withFragment('cart')->with('success', __('Cart updated.'));
    }

    public function destroy(int $item): RedirectResponse
    {
        $this->cartService->removeItem($item);
        return redirect()->route('account')->withFragment('cart')->with('success', __('Item removed from cart.'));
    }
}
