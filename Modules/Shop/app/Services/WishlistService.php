<?php

namespace Modules\Shop\Services;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class WishlistService
{
    private const GUEST_WISHLIST_CACHE_KEY_PREFIX = 'guest_wishlist_';

    private const GUEST_WISHLIST_TTL_MINUTES = 60 * 24 * 365; // 1 year

    public function getProductIds(): array
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->pluck('product_id')->all();
        }
        return $this->getGuestWishlistProductIds();
    }

    public function getItems(): Collection
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())
                ->with('product.category')
                ->latest()
                ->get();
        }
        return $this->getGuestWishlistItems();
    }

    public function count(): int
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->count();
        }
        return count($this->getGuestWishlistProductIds());
    }

    public function add(int $productId): bool
    {
        if (Auth::check()) {
            Wishlist::firstOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $productId],
                ['user_id' => Auth::id(), 'product_id' => $productId]
            );
            return true;
        }
        $ids = $this->getGuestWishlistProductIds();
        if (! in_array($productId, $ids, true)) {
            $ids[] = $productId;
            $this->putGuestWishlist($ids);
        }
        return true;
    }

    public function remove(int $productId): bool
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->delete() > 0;
        }
        $ids = $this->getGuestWishlistProductIds();
        $ids = array_values(array_filter($ids, fn ($id) => (int) $id !== $productId));
        $this->putGuestWishlist($ids);
        return true;
    }

    public function has(int $productId): bool
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->exists();
        }
        return in_array($productId, $this->getGuestWishlistProductIds(), true);
    }

    public function toggle(int $productId): bool
    {
        if ($this->has($productId)) {
            $this->remove($productId);
            return false;
        }
        $this->add($productId);
        return true;
    }

    public function mergeGuestWishlistToUser(int $userId): void
    {
        $ids = $this->getGuestWishlistProductIds();
        if (empty($ids)) {
            return;
        }
        foreach ($ids as $productId) {
            Wishlist::firstOrCreate(
                ['user_id' => $userId, 'product_id' => (int) $productId],
                ['user_id' => $userId, 'product_id' => (int) $productId]
            );
        }
        $this->forgetGuestWishlist();
    }

    protected function getGuestWishlistCacheKey(): string
    {
        return self::GUEST_WISHLIST_CACHE_KEY_PREFIX . Session::getId();
    }

    /** @return array<int, int> */
    protected function getGuestWishlistProductIds(): array
    {
        $key = $this->getGuestWishlistCacheKey();
        $data = Cache::get($key, []);
        return is_array($data) ? array_map('intval', $data) : [];
    }

    /** @param array<int, int> $productIds */
    protected function putGuestWishlist(array $productIds): void
    {
        Cache::put($this->getGuestWishlistCacheKey(), $productIds, self::GUEST_WISHLIST_TTL_MINUTES);
    }

    protected function forgetGuestWishlist(): void
    {
        Cache::forget($this->getGuestWishlistCacheKey());
    }

    protected function getGuestWishlistItems(): Collection
    {
        $ids = $this->getGuestWishlistProductIds();
        if (empty($ids)) {
            return collect();
        }
        $products = Product::with('category')->whereIn('id', $ids)->get()->keyBy('id');
        $items = collect();
        foreach ($ids as $productId) {
            $product = $products->get($productId);
            if ($product) {
                $items->push((object) [
                    'id' => 'g_' . $productId,
                    'product_id' => $productId,
                    'product' => $product,
                ]);
            }
        }
        return $items;
    }
}
