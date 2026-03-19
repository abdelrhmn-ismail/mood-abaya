<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $reviewService) {}

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $result = $this->reviewService->storeReview(Auth::id(), $request->only('order_id', 'product_id', 'rating', 'comment'));

        if ($result === 'already_reviewed') {
            return redirect()->back()->with('error', __('You already reviewed this product for this order.'));
        }

        return redirect()->back()->with('success', __('Thank you! Your review has been submitted.'));
    }
}
