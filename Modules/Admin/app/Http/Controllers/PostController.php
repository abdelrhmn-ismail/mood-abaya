<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PostController
{
    public function index(Request $request): View
    {
        $sort = $request->get('sort', 'published_at');
        $order = strtolower($request->get('order', 'desc')) === 'asc' ? 'asc' : 'desc';
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
        $posts = $query->paginate(admin_per_page())->withQueryString();

        return view('admin::posts.index', compact('posts'));
    }

    public function create(): View
    {
        $post = new Post;

        return view('admin::posts.create', compact('post'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required_with:title|string|max:255',
            'title.ar' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.en' => 'nullable|string|max:1000',
            'excerpt.ar' => 'nullable|string|max:1000',
            'body' => 'nullable|array',
            'body.en' => 'nullable|string',
            'body.ar' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|array',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_title.ar' => 'nullable|string|max:255',
            'meta_description' => 'nullable|array',
            'meta_description.en' => 'nullable|string|max:500',
            'meta_description.ar' => 'nullable|string|max:500',
        ]);
        $data['title'] = array_filter($data['title'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['excerpt'] = array_filter($data['excerpt'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['body'] = array_filter($data['body'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['meta_title'] = array_filter($data['meta_title'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['meta_description'] = array_filter($data['meta_description'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']['en'] ?? $data['title']['ar'] ?? 'post');
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        } else {
            $data['image'] = null;
        }
        $data['published_at'] = ! empty($data['published_at']) ? $data['published_at'] : null;
        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', __('Post created.'));
    }

    public function edit(Post $post): View
    {
        return view('admin::posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required_with:title|string|max:255',
            'title.ar' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.en' => 'nullable|string|max:1000',
            'excerpt.ar' => 'nullable|string|max:1000',
            'body' => 'nullable|array',
            'body.en' => 'nullable|string',
            'body.ar' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|array',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_title.ar' => 'nullable|string|max:255',
            'meta_description' => 'nullable|array',
            'meta_description.en' => 'nullable|string|max:500',
            'meta_description.ar' => 'nullable|string|max:500',
        ]);
        $data['title'] = array_filter($data['title'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['excerpt'] = array_filter($data['excerpt'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['body'] = array_filter($data['body'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['meta_title'] = array_filter($data['meta_title'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['meta_description'] = array_filter($data['meta_description'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']['en'] ?? $data['title']['ar'] ?? $post->slug);
        $data['slug'] = $this->ensureUniqueSlug($data['slug'], $post->id);
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        } else {
            unset($data['image']);
        }
        $data['published_at'] = ! empty($data['published_at']) ? $data['published_at'] : null;
        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', __('Post updated.'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', __('Post deleted.'));
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
            if (! $q->exists()) {
                return $slug;
            }
            $slug = $base . '-' . (++$count);
        } while (true);
    }
}
