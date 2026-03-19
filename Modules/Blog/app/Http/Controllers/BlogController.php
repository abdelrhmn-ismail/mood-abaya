<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::published()
            ->latest('published_at')
            ->paginate(9);

        return view('blog::frontend.index', compact('posts'));
    }

    public function show(string $slug): View|\Illuminate\Http\Response
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        if (! $post->published_at || $post->published_at->isFuture()) {
            abort(404);
        }

        return view('blog::frontend.show', compact('post'));
    }
}