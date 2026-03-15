<?php

namespace Modules\Shop\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

    /**
     * Search products by name (searches in both en and ar translatable name).
     *
     * @param  array{sort?: string, in_stock?: bool, price_min?: float, price_max?: float}  $filters
     */
    public function search(?string $q, array $filters = []): Collection|LengthAwarePaginator
    {
        $q = $q ?? '';
        if (trim($q) === '') {
            return collect();
        }
        $term = '%' . trim($q) . '%';
        $query = Product::with('category', 'images', 'variants')
            ->active()
            ->where(function ($query) use ($term) {
                $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) LIKE ?", [$term])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar')) LIKE ?", [$term]);
            });

        if (! empty($filters['in_stock'])) {
            $query->where(function (Builder $q) {
                $q->where('stock', '>', 0)
                    ->orWhereHas('variants', fn ($v) => $v->where('stock', '>', 0));
            });
        }
        if (isset($filters['price_min']) && $filters['price_min'] !== '' && is_numeric($filters['price_min'])) {
            $query->where('price', '>=', (float) $filters['price_min']);
        }
        if (isset($filters['price_max']) && $filters['price_max'] !== '' && is_numeric($filters['price_max'])) {
            $query->where('price', '<=', (float) $filters['price_max']);
        }

        $sort = $filters['sort'] ?? 'name_asc';
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest' => $query->orderByDesc('created_at'),
            'name_desc' => $query->orderByDesc('name'),
            default => $query->orderBy('name'),
        };

        return $query->paginate(12)->withQueryString();
    }
}
