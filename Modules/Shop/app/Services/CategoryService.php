<?php

namespace Modules\Shop\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

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

    public function getProductsByCategory(Category $category)
    {
        return $category->products()->active()->orderBy('name')->get();
    }
}
