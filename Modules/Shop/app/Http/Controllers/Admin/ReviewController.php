<?php

namespace Modules\Shop\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Shop\Http\Requests\Admin\BulkReviewActionRequest;
use Modules\Shop\Services\Admin\ReviewService;

class ReviewController
{
    public function __construct(private ReviewService $reviewService) {}

    public function index(Request $request): View
    {
        $reviews = $this->reviewService->getAll(
            $request->only('rating', 'visible', 'product_id', 'search', 'sort', 'order'),
            admin_per_page()
        );
        $products = Product::orderBy('id')->get(['id', 'name']);

        return view('shop::admin.reviews.index', compact('reviews', 'products'));
    }

    public function toggleVisibility(ProductReview $review): RedirectResponse
    {
        $this->reviewService->toggleVisibility($review);

        return redirect()->route('admin.reviews.index')
            ->with('success', $review->is_visible ? __('Review is now visible.') : __('Review is now hidden.'));
    }

    public function bulkAction(BulkReviewActionRequest $request): RedirectResponse
    {
        $count = $this->reviewService->bulkAction($request->input('ids'), $request->input('action'));

        return redirect()->route('admin.reviews.index', $request->only('rating', 'visible', 'product_id', 'search', 'per_page', 'sort', 'order'))
            ->with('success', __(':count record(s) updated.', ['count' => $count]));
    }
}
