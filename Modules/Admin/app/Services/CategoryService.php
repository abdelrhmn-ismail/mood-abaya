<?php

namespace Modules\Admin\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CategoryService
{
    public function getAll()
    {
        return Category::orderBy('sort_order')->orderBy('name')->get();
    }

    public function create(array $data): Category
    {
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('categories', 'public');
        } else {
            unset($data['image']);
        }
        $data['active'] = isset($data['active']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        if (!empty($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if (isset($data['slug'])) {
            $data['slug'] = $this->ensureUniqueSlug($data['slug'], $category->id);
        }
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('categories', 'public');
        } else {
            unset($data['image']);
        }
        $data['active'] = isset($data['active']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? $category->sort_order);
        $category->update($data);
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
}
