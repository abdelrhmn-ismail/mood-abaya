<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use Modules\Shop\Services\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $reviewService) {}

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $result = $this->reviewService->storeReview(Auth::id(), $request->only('order_id', 'product_id', 'rating', 'comment'));

        if ($result === 'already_reviewed') {
            return redirect()->back()->with('error', __('You already reviewed this product for this order.'));
        }

        return redirect()->back()->with('success', __('Thank you! Your review has been submitted.'));
    }
}
