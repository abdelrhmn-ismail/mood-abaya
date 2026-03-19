<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\StorePostRequest;
use Modules\Admin\Services\PostService;

class PostController
{
    public function __construct(private PostService $postService) {}

    public function index(Request $request): View
    {
        $posts = $this->postService->getAll(
            $request->only('sort', 'order'),
            admin_per_page()
        );

        return view('admin::posts.index', compact('posts'));
    }

    public function create(): View
    {
        $post = new Post;

        return view('admin::posts.create', compact('post'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->postService->create($request->validated());

        return redirect()->route('admin.posts.index')->with('success', __('Post created.'));
    }

    public function edit(Post $post): View
    {
        return view('admin::posts.edit', compact('post'));
    }

    public function update(StorePostRequest $request, Post $post): RedirectResponse
    {
        $this->postService->update($post, $request->validated());

        return redirect()->route('admin.posts.index')->with('success', __('Post updated.'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postService->delete($post);

        return redirect()->route('admin.posts.index')->with('success', __('Post deleted.'));
    }
}
