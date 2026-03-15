<?php

namespace Modules\Core\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class HomeService
{
    public function getFeaturedCategories(int $limit = 6): Collection
    {
        return Category::active()
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    public function getLatestProducts(int $limit = 8): Collection
    {
        return Product::with(['category', 'images'])
            ->active()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getFeaturedProducts(int $limit = 4): Collection
    {
        return Product::with(['category', 'images'])
            ->active()
            ->where('featured', true)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
