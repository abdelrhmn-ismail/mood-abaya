<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController
{
    public function index(Request $request): View
    {
        $reviews = ProductReview::with(['product', 'user', 'order'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin::reviews.index', compact('reviews'));
    }

    public function toggleVisibility(ProductReview $review): RedirectResponse
    {
        $review->update(['is_visible' => ! $review->is_visible]);

        return redirect()->route('admin.reviews.index')
            ->with('success', $review->is_visible ? __('Review is now visible.') : __('Review is now hidden.'));
    }
}
