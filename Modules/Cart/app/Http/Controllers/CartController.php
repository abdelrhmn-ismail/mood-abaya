<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
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

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
            'product_variant_id' => ['nullable', 'integer', 'exists:product_variants,id'],
        ]);
        $this->cartService->addItem(
            (int) $request->product_id,
            (int) ($request->quantity ?? 1),
            $request->filled('product_variant_id') ? (int) $request->product_variant_id : null
        );
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Item added to cart.'),
                'cart_count' => $this->cartService->getItemCount(),
            ]);
        }
        return redirect()->route('account')->withFragment('cart')->with('success', __('Item added to cart.'));
    }

    public function update(Request $request, int|string $item): RedirectResponse
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:0', 'max:999']]);
        $this->cartService->updateQuantity($item, (int) $request->quantity);
        return redirect()->route('account')->withFragment('cart')->with('success', __('Cart updated.'));
    }

    public function destroy(int|string $item): RedirectResponse
    {
        $this->cartService->removeItem($item);
        return redirect()->route('account')->withFragment('cart')->with('success', __('Item removed from cart.'));
    }
}
