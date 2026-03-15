<?php

namespace Modules\Admin\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductService
{
    /** @param  array{category_id?: int, search?: string, active?: string, featured?: string, sort?: string, order?: string}  $filters */
    public function getAll(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = Product::with('category');

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (!empty($filters['search'])) {
            $term = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name->en', 'like', $term)
                    ->orWhere('name->ar', 'like', $term)
                    ->orWhere('slug', 'like', $term);
            });
        }
        if (isset($filters['active']) && $filters['active'] !== '') {
            $query->where('active', (bool) $filters['active']);
        }
        if (isset($filters['featured']) && $filters['featured'] !== '') {
            $query->where('featured', (bool) $filters['featured']);
        }

        $sort = $filters['sort'] ?? 'created_at';
        $order = isset($filters['order']) && strtolower($filters['order']) === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['name', 'price', 'stock', 'active', 'created_at', 'id'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'created_at';
        }
        if ($sort === 'name') {
            $locale = config('app.fallback_locale', 'en');
            $query->orderBy("name->{$locale}", $order);
        } else {
            $query->orderBy($sort, $order);
        }

        return $query->paginate($perPage);
    }

    public function bulkActivate(array $ids): int
    {
        return Product::whereIn('id', $ids)->update(['active' => true]);
    }

    public function bulkDeactivate(array $ids): int
    {
        return Product::whereIn('id', $ids)->update(['active' => false]);
    }

    public function bulkDelete(array $ids): int
    {
        return Product::whereIn('id', $ids)->delete();
    }

    public function create(array $data): Product
    {
        $nameForSlug = $this->getNameForSlug($data['name'] ?? []);
        $data['slug'] = $data['slug'] ?: Str::slug($nameForSlug);
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('products', 'public');
        } else {
            unset($data['image']);
        }
        $data['active'] = isset($data['active']);
        $data['featured'] = isset($data['featured']);
        $data['stock'] = (int) ($data['stock'] ?? 0);
        $data['price'] = (float) ($data['price'] ?? 0);
        $data['weight_kg'] = isset($data['weight_kg']) && $data['weight_kg'] !== '' ? (float) $data['weight_kg'] : null;
        $data['compare_at_price'] = isset($data['compare_at_price']) && $data['compare_at_price'] !== '' ? (float) $data['compare_at_price'] : null;
        $data['min_order_qty'] = isset($data['min_order_qty']) ? max(1, (int) $data['min_order_qty']) : 1;
        $data['max_order_qty'] = isset($data['max_order_qty']) && $data['max_order_qty'] !== '' ? (int) $data['max_order_qty'] : null;
        $product = Product::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'] ?? [],
            'description' => $data['description'] ?? [],
            'short_description' => $data['short_description'] ?? null,
            'tags' => $data['tags'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
            'og_image' => $data['og_image'] ?? null,
            'sku' => $data['sku'] ?? null,
            'barcode' => $data['barcode'] ?? null,
            'slug' => $data['slug'],
            'price' => $data['price'],
            'compare_at_price' => $data['compare_at_price'],
            'image' => $data['image'] ?? null,
            'stock' => $data['stock'],
            'min_order_qty' => $data['min_order_qty'],
            'max_order_qty' => $data['max_order_qty'],
            'weight_kg' => $data['weight_kg'],
            'active' => $data['active'],
            'featured' => $data['featured'],
        ]);
        $this->syncGalleryImages($product, $data['gallery_images'] ?? []);
        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        if (!empty($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($this->getNameForSlug($data['name']));
        }
        if (isset($data['slug'])) {
            $data['slug'] = $this->ensureUniqueSlug($data['slug'], $product->id);
        }
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('products', 'public');
        } else {
            unset($data['image']);
        }
        $product->name = $data['name'] ?? $product->getTranslations('name');
        $product->description = $data['description'] ?? $product->getTranslations('description');
        $product->active = isset($data['active']);
        $product->featured = isset($data['featured']);
        if (array_key_exists('short_description', $data)) {
            $product->short_description = $data['short_description'] ?: null;
        }
        if (array_key_exists('meta_title', $data)) {
            $product->meta_title = $data['meta_title'] ?: null;
        }
        if (array_key_exists('meta_description', $data)) {
            $product->meta_description = $data['meta_description'] ?: null;
        }
        if (array_key_exists('meta_keywords', $data)) {
            $product->meta_keywords = $data['meta_keywords'] ?: null;
        }
        if (array_key_exists('og_image', $data)) {
            $product->og_image = $data['og_image'] ?: null;
        }
        if (array_key_exists('tags', $data)) {
            $product->tags = $data['tags'] ?: null;
        }
        if (array_key_exists('sku', $data)) {
            $product->sku = $data['sku'] ?: null;
        }
        if (array_key_exists('barcode', $data)) {
            $product->barcode = $data['barcode'] ?: null;
        }
        if (array_key_exists('compare_at_price', $data)) {
            $product->compare_at_price = $data['compare_at_price'] !== '' && $data['compare_at_price'] !== null ? (float) $data['compare_at_price'] : null;
        }
        if (array_key_exists('min_order_qty', $data)) {
            $product->min_order_qty = max(1, (int) ($data['min_order_qty'] ?? 1));
        }
        if (array_key_exists('max_order_qty', $data)) {
            $product->max_order_qty = $data['max_order_qty'] !== '' && $data['max_order_qty'] !== null ? (int) $data['max_order_qty'] : null;
        }
        if (array_key_exists('weight_kg', $data)) {
            $product->weight_kg = $data['weight_kg'] !== '' && $data['weight_kg'] !== null ? (float) $data['weight_kg'] : null;
        }
        if (isset($data['stock'])) {
            $product->stock = (int) $data['stock'];
        }
        if (isset($data['price'])) {
            $product->price = (float) $data['price'];
        }
        if (isset($data['category_id'])) {
            $product->category_id = $data['category_id'];
        }
        if (array_key_exists('slug', $data)) {
            $product->slug = $data['slug'];
        }
        if (array_key_exists('image', $data) && $data['image'] !== null) {
            $product->image = $data['image'];
        }
        $product->save();
        if (array_key_exists('delete_image_ids', $data) && is_array($data['delete_image_ids'])) {
            $product->images()->whereIn('id', $data['delete_image_ids'])->delete();
        }
        $this->syncGalleryImages($product, $data['gallery_images'] ?? []);
        return $product;
    }

    /**
     * @param  array<int, UploadedFile>  $files
     */
    private function syncGalleryImages(Product $product, array $files): void
    {
        $sortOrder = (int) $product->images()->max('sort_order');
        foreach ($files as $file) {
            if (!$file instanceof UploadedFile || !$file->isValid()) {
                continue;
            }
            $path = $file->store('products', 'public');
            $product->images()->create(['image' => $path, 'sort_order' => ++$sortOrder]);
        }
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    private function ensureUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $base = $slug;
        $count = 0;
        while (true) {
            $q = Product::where('slug', $slug);
            if ($excludeId) {
                $q->where('id', '!=', $excludeId);
            }
            if (!$q->exists()) {
                return $slug;
            }
            $slug = $base . '-' . (++$count);
        }
    }

    private function getNameForSlug(array $nameTranslations): string
    {
        $locale = config('app.fallback_locale', 'en');
        return trim((string) ($nameTranslations[$locale] ?? $nameTranslations['en'] ?? reset($nameTranslations) ?: ''));
    }
}
