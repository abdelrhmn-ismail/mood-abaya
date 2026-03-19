<?php

namespace Modules\Admin\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PostService
{
    public function getAll(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $sort = $filters['sort'] ?? 'published_at';
        $order = strtolower($filters['order'] ?? 'desc') === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['title', 'published_at', 'created_at', 'id'];

        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'published_at';
        }

        $query = Post::query();

        if ($sort === 'title') {
            $driver = Schema::getConnection()->getDriverName();
            $expr = $driver === 'mysql'
                ? "JSON_UNQUOTE(JSON_EXTRACT(title, '$.en'))"
                : "json_extract(title, '$.en')";
            $query->orderByRaw("{$expr} {$order}");
        } else {
            $query->orderBy($sort, $order);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function create(array $data): Post
    {
        $data = $this->prepareData($data);
        $data['slug'] = $this->ensureUniqueSlug(
            $data['slug'] ?: Str::slug($data['title']['en'] ?? $data['title']['ar'] ?? 'post')
        );

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = upload_image($data['image'], 'posts');
        } else {
            $data['image'] = null;
        }

        $data['published_at'] = !empty($data['published_at']) ? $data['published_at'] : null;

        return Post::create($data);
    }

    public function update(Post $post, array $data): Post
    {
        $data = $this->prepareData($data);
        $data['slug'] = $this->ensureUniqueSlug(
            $data['slug'] ?: Str::slug($data['title']['en'] ?? $data['title']['ar'] ?? $post->slug),
            $post->id
        );

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            delete_image($post->image);
            $data['image'] = upload_image($data['image'], 'posts');
        } else {
            unset($data['image']);
        }

        $data['published_at'] = !empty($data['published_at']) ? $data['published_at'] : null;

        $post->update($data);

        return $post;
    }

    public function delete(Post $post): void
    {
        delete_image($post->image);
        $post->delete();
    }

    private function prepareData(array $data): array
    {
        foreach (['title', 'excerpt', 'body', 'meta_title', 'meta_description'] as $field) {
            $data[$field] = array_filter($data[$field] ?? [], fn ($v) => $v !== null && $v !== '');
        }

        return $data;
    }

    private function ensureUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $base = $slug;
        $count = 0;
        do {
            $q = Post::where('slug', $slug);
            if ($excludeId) {
                $q->where('id', '!=', $excludeId);
            }
            if (!$q->exists()) {
                return $slug;
            }
            $slug = $base . '-' . (++$count);
        } while (true);
    }
}
