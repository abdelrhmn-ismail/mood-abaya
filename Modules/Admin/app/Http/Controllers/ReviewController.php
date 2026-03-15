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
        $query = ProductReview::with(['product', 'user', 'order'])->orderByDesc('created_at');

        if (request('rating') !== null && request('rating') !== '') {
            $query->where('rating', (int) request('rating'));
        }
        if (request('visible') !== null && request('visible') !== '') {
            $query->where('is_visible', (bool) request('visible'));
        }
        if (!empty(request('product_id'))) {
            $query->where('product_id', request('product_id'));
        }
        if (!empty(request('search'))) {
            $term = '%' . request('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('comment', 'like', $term);
            });
        }

        $reviews = $query->paginate(20);
        $products = \App\Models\Product::orderBy('id')->get(['id', 'name']);

        return view('admin::reviews.index', compact('reviews', 'products'));
    }

    public function toggleVisibility(ProductReview $review): RedirectResponse
    {
        $review->update(['is_visible' => ! $review->is_visible]);

        return redirect()->route('admin.reviews.index')
            ->with('success', $review->is_visible ? __('Review is now visible.') : __('Review is now hidden.'));
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:product_reviews,id',
            'action' => 'required|in:show,hide,delete',
        ]);
        $ids = $request->input('ids');
        $action = $request->input('action');
        $count = 0;
        if ($action === 'show') {
            $count = ProductReview::whereIn('id', $ids)->update(['is_visible' => true]);
        } elseif ($action === 'hide') {
            $count = ProductReview::whereIn('id', $ids)->update(['is_visible' => false]);
        } elseif ($action === 'delete') {
            $count = ProductReview::whereIn('id', $ids)->delete();
        }
        return redirect()->route('admin.reviews.index', $request->only('rating', 'visible', 'product_id', 'search'))
            ->with('success', __(':count record(s) updated.', ['count' => $count]));
    }
}
