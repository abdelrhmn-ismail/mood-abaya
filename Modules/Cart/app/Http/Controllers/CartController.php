<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function items(Request $request): JsonResponse
    {
        $cart = $this->cartService->getCart();

        $items = $cart->map(function ($item) {
            $product = $item->product;
            $variant = $item->productVariant ?? null;
            $image = $variant?->image ?? $product->image;

            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'image' => $image ? get_image_url($image) : null,
                'variant_name' => $variant?->getDisplayName(),
                'quantity' => $item->quantity,
                'price' => (float) $item->getEffectivePrice(),
                'line_total' => round($item->getEffectivePrice() * $item->quantity, 2),
            ];
        })->values();

        return response()->json([
            'items' => $items,
            'subtotal' => $this->cartService->getTotal(),
            'count' => $this->cartService->getItemCount(),
        ]);
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
                'cart' => $this->getCartPayload(),
            ]);
        }

        return redirect()->route('account')->withFragment('cart')->with('success', __('Item added to cart.'));
    }

    public function update(UpdateCartItemRequest $request, int|string $item): RedirectResponse|JsonResponse
    {
        $this->cartService->updateQuantity($item, (int) $request->quantity);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart' => $this->getCartPayload(),
            ]);
        }

        return redirect()->route('account')->withFragment('cart')->with('success', __('Cart updated.'));
    }

    public function destroy(Request $request, int|string $item): RedirectResponse|JsonResponse
    {
        $this->cartService->removeItem($item);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart' => $this->getCartPayload(),
            ]);
        }

        return redirect()->route('account')->withFragment('cart')->with('success', __('Item removed from cart.'));
    }

    private function getCartPayload(): array
    {
        $cart = $this->cartService->getCart();

        $items = $cart->map(function ($item) {
            $product = $item->product;
            $variant = $item->productVariant ?? null;
            $image = $variant?->image ?? $product->image;

            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'image' => $image ? get_image_url($image) : null,
                'variant_name' => $variant?->getDisplayName(),
                'quantity' => $item->quantity,
                'price' => (float) $item->getEffectivePrice(),
                'line_total' => round($item->getEffectivePrice() * $item->quantity, 2),
            ];
        })->values();

        return [
            'items' => $items,
            'subtotal' => $this->cartService->getTotal(),
            'count' => $this->cartService->getItemCount(),
        ];
    }
}
