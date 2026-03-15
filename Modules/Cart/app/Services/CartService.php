<?php

namespace Modules\Cart\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Cart\DTOs\GuestCartItem;

class CartService
{
    private const GUEST_CART_CACHE_KEY_PREFIX = 'guest_cart_';

    private const GUEST_CART_TTL_MINUTES = 60 * 24 * 30; // 30 days

    public function getCart(): BaseCollection|Collection
    {
        if (Auth::check()) {
            return CartItem::with('product', 'productVariant')
                ->where('user_id', Auth::id())
                ->get();
        }

        return $this->getGuestCartFromCache();
    }

    public function getItemCount(): int
    {
        if (Auth::check()) {
            return (int) CartItem::where('user_id', Auth::id())->sum('quantity');
        }

        $rows = $this->getGuestCartRows();
        $count = 0;
        foreach ($rows as $row) {
            $count += (int) ($row['quantity'] ?? 1);
        }
        return $count;
    }

    /** Check if product (and optional variant) is already in the current cart. */
    public function hasInCart(int $productId, ?int $variantId = null): bool
    {
        if (Auth::check()) {
            $query = CartItem::where('user_id', Auth::id())->where('product_id', $productId);
            $query = $variantId
                ? $query->where('product_variant_id', $variantId)
                : $query->whereNull('product_variant_id');
            return $query->exists();
        }
        foreach ($this->getGuestCartRows() as $row) {
            $rowVariant = isset($row['product_variant_id']) ? (int) $row['product_variant_id'] : null;
            if ((int) $row['product_id'] === $productId && $rowVariant === $variantId) {
                return true;
            }
        }
        return false;
    }

    public function addItem(int $productId, int $quantity = 1, ?int $variantId = null): CartItem|GuestCartItem
    {
        $product = Product::active()->with('variants')->findOrFail($productId);
        $variant = null;
        if ($variantId) {
            $variant = $product->variants->firstWhere('id', $variantId);
            if (! $variant) {
                abort(404, 'Variant not found');
            }
            $quantity = max(1, min($quantity, (int) $variant->stock ?: 999));
        } else {
            $quantity = max(1, min($quantity, (int) $product->stock ?: 999));
        }

        if (Auth::check()) {
            $matchVariant = fn ($q) => $variantId ? $q->where('product_variant_id', $variantId) : $q->whereNull('product_variant_id');
            $item = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->when(true, $matchVariant)
                ->first();
            if ($item) {
                $item->increment('quantity', $quantity);
                return $item->fresh(['product', 'productVariant']);
            }
            return CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => null,
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
            ])->load(['product', 'productVariant']);
        }

        $this->addGuestCartItem($productId, $quantity, $variantId);
        $items = $this->getGuestCartFromCache();
        return $items->last();
    }

    public function updateQuantity(int|string $itemId, int $quantity): CartItem|GuestCartItem|null
    {
        if (Auth::check()) {
            $item = CartItem::with('product')->where('id', $itemId)->where('user_id', Auth::id())->first();
            if (! $item) {
                return null;
            }
            $quantity = max(0, min($quantity, (int) ($item->product->stock ?: 999)));
            if ($quantity === 0) {
                $item->delete();
                return null;
            }
            $item->update(['quantity' => $quantity]);
            return $item->fresh(['product', 'productVariant']);
        }

        if (is_string($itemId) && str_starts_with($itemId, 'g_')) {
            $index = (int) substr($itemId, 2);
            $rows = $this->getGuestCartRows();
            if (! isset($rows[$index])) {
                return null;
            }
            $row = &$rows[$index];
            $product = Product::active()->find($row['product_id']);
            $maxQty = (int) ($product->stock ?? 999);
            $quantity = max(0, min($quantity, $maxQty));
            if ($quantity === 0) {
                array_splice($rows, $index, 1);
                $this->putGuestCartRows($rows);
                return null;
            }
            $row['quantity'] = $quantity;
            $this->putGuestCartRows($rows);
            $items = $this->getGuestCartFromCache();
            return $items->get($index);
        }

        return null;
    }

    public function removeItem(int|string $itemId): bool
    {
        if (Auth::check()) {
            $item = CartItem::where('id', $itemId)->where('user_id', Auth::id())->first();
            if ($item) {
                $item->delete();
                return true;
            }
            return false;
        }

        if (is_string($itemId) && str_starts_with($itemId, 'g_')) {
            $index = (int) substr($itemId, 2);
            $rows = $this->getGuestCartRows();
            if (isset($rows[$index])) {
                array_splice($rows, $index, 1);
                $this->putGuestCartRows($rows);
                return true;
            }
        }
        return false;
    }

    public function getTotal(): float
    {
        $items = $this->getCart();
        $total = 0;
        foreach ($items as $item) {
            $total += $item->getEffectivePrice() * $item->quantity;
        }
        return round((float) $total, 2);
    }

    public function mergeGuestCartToUser(int $userId): void
    {
        $rows = $this->getGuestCartRows();
        if (empty($rows)) {
            return;
        }

        foreach ($rows as $row) {
            $productId = (int) $row['product_id'];
            $quantity = (int) ($row['quantity'] ?? 1);
            $variantId = isset($row['product_variant_id']) ? (int) $row['product_variant_id'] : null;

            $existing = CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->when($variantId, fn ($q) => $q->where('product_variant_id', $variantId), fn ($q) => $q->whereNull('product_variant_id'))
                ->first();

            if ($existing instanceof CartItem) {
                $existing->increment('quantity', $quantity);
            } else {
                CartItem::create([
                    'user_id' => $userId,
                    'session_id' => null,
                    'product_id' => $productId,
                    'product_variant_id' => $variantId,
                    'quantity' => $quantity,
                ]);
            }
        }

        $this->forgetGuestCart();
    }

    public function clearCart(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            $this->forgetGuestCart();
        }
    }

    protected function getGuestCartCacheKey(): string
    {
        return self::GUEST_CART_CACHE_KEY_PREFIX . $this->getSessionId();
    }

    /** @return array<int, array{product_id: int, quantity: int, product_variant_id: int|null}> */
    protected function getGuestCartRows(): array
    {
        $key = $this->getGuestCartCacheKey();
        $data = Cache::get($key, []);
        return is_array($data) ? $data : [];
    }

    protected function putGuestCartRows(array $rows): void
    {
        Cache::put($this->getGuestCartCacheKey(), $rows, self::GUEST_CART_TTL_MINUTES);
    }

    protected function forgetGuestCart(): void
    {
        Cache::forget($this->getGuestCartCacheKey());
    }

    protected function addGuestCartItem(int $productId, int $quantity, ?int $variantId): void
    {
        $rows = $this->getGuestCartRows();
        foreach ($rows as $i => $row) {
            $sameVariant = (isset($row['product_variant_id']) ? (int) $row['product_variant_id'] : null) === $variantId;
            if ((int) $row['product_id'] === $productId && $sameVariant) {
                $rows[$i]['quantity'] = (int) ($row['quantity'] ?? 1) + $quantity;
                $this->putGuestCartRows($rows);
                return;
            }
        }
        $rows[] = [
            'product_id' => $productId,
            'quantity' => $quantity,
            'product_variant_id' => $variantId,
        ];
        $this->putGuestCartRows($rows);
    }

    protected function getGuestCartFromCache(): BaseCollection
    {
        $rows = $this->getGuestCartRows();
        $items = new BaseCollection;
        $productIds = array_unique(array_column($rows, 'product_id'));
        $products = Product::active()->with('variants')->whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($rows as $index => $row) {
            $productId = (int) $row['product_id'];
            $product = $products->get($productId);
            if (! $product) {
                continue;
            }
            $variantId = isset($row['product_variant_id']) ? (int) $row['product_variant_id'] : null;
            $variant = $variantId ? $product->variants->firstWhere('id', $variantId) : null;
            $quantity = (int) ($row['quantity'] ?? 1);
            $items->push(new GuestCartItem(
                'g_' . $index,
                $productId,
                $variantId ?: null,
                $quantity,
                $product,
                $variant,
            ));
        }

        return $items;
    }

    protected function getSessionId(): string
    {
        return session()->getId();
    }
}
