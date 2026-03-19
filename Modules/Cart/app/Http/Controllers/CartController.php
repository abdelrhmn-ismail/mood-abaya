<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Cart\Http\Requests\StoreCartItemRequest;
use Modules\Cart\Http\Requests\UpdateCartItemRequest;
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

    public function store(StoreCartItemRequest $request): RedirectResponse|JsonResponse
    {
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

    public function update(UpdateCartItemRequest $request, int|string $item): RedirectResponse
    {
        $this->cartService->updateQuantity($item, (int) $request->quantity);

        return redirect()->route('account')->withFragment('cart')->with('success', __('Cart updated.'));
    }

    public function destroy(int|string $item): RedirectResponse
    {
        $this->cartService->removeItem($item);

        return redirect()->route('account')->withFragment('cart')->with('success', __('Item removed from cart.'));
    }
}
