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
