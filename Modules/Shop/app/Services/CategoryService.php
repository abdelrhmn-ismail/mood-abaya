<?php

namespace Modules\Shop\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function getActiveCategories(): Collection
    {
        return Category::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function findBySlug(string $slug): ?Category
    {
        return Category::active()->where('slug', $slug)->first();
    }

    /**
     * @param  array{sort?: string, in_stock?: bool, price_min?: float, price_max?: float}  $filters
     */
    public function getProductsByCategory(Category $category, array $filters = []): LengthAwarePaginator
    {
        $query = $category->products()->active()->with('images', 'variants');

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
