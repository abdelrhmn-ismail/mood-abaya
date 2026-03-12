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

    public function searchByName(string $q): Collection
    {
        return Product::with('category')
            ->active()
            ->where('name', 'like', '%' . $q . '%')
            ->orderBy('name')
            ->get();
    }
}
