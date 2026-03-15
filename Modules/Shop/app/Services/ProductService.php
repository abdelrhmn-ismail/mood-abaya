<?php

namespace Modules\Shop\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function getActiveProducts(): Collection
    {
        return Product::with('category')
            ->active()
            ->orderBy('name')
            ->get();
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::with('category')->active()->where('slug', $slug)->first();
    }

    /**
     * Search products by name (searches in both en and ar translatable name).
     */
    /** Related products: same category, exclude given product. */
    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::active()
            ->with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /** Get products by IDs (e.g. recently viewed), preserving order. */
    public function getByIds(array $ids, int $limit = 6): Collection
    {
        if (empty($ids)) {
            return new Collection;
        }
        $ids = array_slice(array_unique(array_map('intval', $ids)), 0, $limit);
        $products = Product::active()->with('images')->whereIn('id', $ids)->get();
        $sorted = $products->sortBy(fn ($p) => array_search($p->id, $ids, true))->values();

        return new Collection($sorted->all());
    }

    public function search(?string $q): Collection
    {
        $q = $q ?? '';
        if (trim($q) === '') {
            return collect();
        }
        $term = '%' . trim($q) . '%';
        return Product::with('category')
            ->active()
            ->where(function ($query) use ($term) {
                $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) LIKE ?", [$term])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar')) LIKE ?", [$term]);
            })
            ->orderBy('name')
            ->get();
    }
}
