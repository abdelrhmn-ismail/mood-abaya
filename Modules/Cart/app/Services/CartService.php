<?php

namespace Modules\Cart\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function getCart(): Collection
    {
        $query = CartItem::with('product')
            ->where(function ($q) {
                if (Auth::check()) {
                    $q->where('user_id', Auth::id());
                } else {
                    $q->where('session_id', $this->getSessionId())
                        ->whereNull('user_id');
                }
            });

        return $query->with('productVariant')->get();
    }

    public function getItemCount(): int
    {
        $query = CartItem::query();
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->getSessionId())->whereNull('user_id');
        }

        return (int) $query->sum('quantity');
    }

    public function addItem(int $productId, int $quantity = 1, ?int $variantId = null): CartItem
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

        $matchVariant = fn ($q) => $variantId ? $q->where('product_variant_id', $variantId) : $q->whereNull('product_variant_id');

        if (Auth::check()) {
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

        $item = CartItem::where('session_id', $this->getSessionId())
            ->whereNull('user_id')
            ->where('product_id', $productId)
            ->when(true, $matchVariant)
            ->first();
        if ($item) {
            $item->increment('quantity', $quantity);
            return $item->fresh(['product', 'productVariant']);
        }

        return CartItem::create([
            'user_id' => null,
            'session_id' => $this->getSessionId(),
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'quantity' => $quantity,
        ])->load(['product', 'productVariant']);
    }

    public function updateQuantity(int $itemId, int $quantity): ?CartItem
    {
        $item = $this->findItemForCurrentUser($itemId);
        if (! $item) {
            return null;
        }
        $quantity = max(0, min($quantity, (int) ($item->product->stock ?: 999)));
        if ($quantity === 0) {
            $item->delete();
            return null;
        }
        $item->update(['quantity' => $quantity]);
        return $item->fresh(['product']);
    }

    public function removeItem(int $itemId): bool
    {
        $item = $this->findItemForCurrentUser($itemId);
        if ($item) {
            $item->delete();
            return true;
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
        $sessionId = $this->getSessionId();
        $guestItems = CartItem::with('product')
            ->where('session_id', $sessionId)
            ->whereNull('user_id')
            ->get();

        foreach ($guestItems as $guestItem) {
            $existing = CartItem::where('user_id', $userId)
                ->where('product_id', $guestItem->product_id)
                ->first();
            if ($existing) {
                $existing->increment('quantity', $guestItem->quantity);
                $guestItem->delete();
            } else {
                $guestItem->update(['user_id' => $userId, 'session_id' => null]);
            }
        }
    }

    public function clearCart(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            CartItem::where('session_id', $this->getSessionId())->whereNull('user_id')->delete();
        }
    }

    protected function findItemForCurrentUser(int $itemId): ?CartItem
    {
        $query = CartItem::with('product')->where('id', $itemId);
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->getSessionId())->whereNull('user_id');
        }
        return $query->first();
    }

    protected function getSessionId(): string
    {
        return session()->getId();
    }
}
