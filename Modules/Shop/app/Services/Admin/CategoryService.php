<?php

namespace Modules\Shop\Services\Admin;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CategoryService
{
    public function getAll()
    {
        $locale = config('app.fallback_locale', 'en');
        return Category::orderBy('sort_order')->orderBy("name->{$locale}")->get();
    }

    /** @param  array{search?: string, active?: string, sort?: string, order?: string}  $filters */
    public function getForIndex(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $locale = config('app.fallback_locale', 'en');
        $query = Category::query();

        if (isset($filters['search']) && $filters['search'] !== '') {
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

        $sort = $filters['sort'] ?? 'sort_order';
        $order = isset($filters['order']) && strtolower($filters['order']) === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['sort_order', 'name', 'slug', 'active', 'created_at'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'sort_order';
        }
        if ($sort === 'name') {
            $query->orderBy("name->{$locale}", $order);
        } else {
            $query->orderBy($sort, $order);
        }

        return $query->paginate($perPage);
    }

    public function bulkActivate(array $ids): int
    {
        return Category::whereIn('id', $ids)->update(['active' => true]);
    }

    public function bulkDeactivate(array $ids): int
    {
        return Category::whereIn('id', $ids)->update(['active' => false]);
    }

    public function bulkDelete(array $ids): int
    {
        return Category::whereIn('id', $ids)->delete();
    }

    public function create(array $data): Category
    {
        $nameForSlug = $this->getNameForSlug($data['name'] ?? []);
        $data['slug'] = $data['slug'] ?: Str::slug($nameForSlug);
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('categories', 'public');
        } else {
            unset($data['image']);
        }
        $data['active'] = isset($data['active']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        return Category::create([
            'name' => $data['name'] ?? [],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? [],
            'image' => $data['image'] ?? null,
            'sort_order' => $data['sort_order'],
            'active' => $data['active'],
        ]);
    }

    public function update(Category $category, array $data): Category
    {
        if (!empty($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($this->getNameForSlug($data['name']));
        }
        if (isset($data['slug'])) {
            $data['slug'] = $this->ensureUniqueSlug($data['slug'], $category->id);
        }
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('categories', 'public');
        } else {
            unset($data['image']);
        }
        $category->name = $data['name'] ?? $category->getTranslations('name');
        $category->description = $data['description'] ?? $category->getTranslations('description');
        $category->active = isset($data['active']);
        $category->sort_order = (int) ($data['sort_order'] ?? $category->sort_order);
        if (array_key_exists('slug', $data)) {
            $category->slug = $data['slug'];
        }
        if (array_key_exists('image', $data) && $data['image'] !== null) {
            $category->image = $data['image'];
        }
        $category->save();
        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    private function ensureUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $base = $slug;
        $count = 0;
        while (true) {
            $q = Category::where('slug', $slug);
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
