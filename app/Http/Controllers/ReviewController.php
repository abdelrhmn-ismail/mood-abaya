<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->firstOrFail();

        $order->load('items');
        $hasProduct = $order->items->contains('product_id', (int) $request->product_id);
        if (!$hasProduct) {
            abort(403, __('Product was not in this order.'));
        }

        $exists = ProductReview::where('order_id', $order->id)
            ->where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->exists();
        if ($exists) {
            return redirect()->back()->with('error', __('You already reviewed this product for this order.'));
        }

        ProductReview::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'rating' => (int) $request->rating,
            'comment' => $request->filled('comment') ? $request->comment : null,
            'is_visible' => true,
        ]);

        return redirect()->back()->with('success', __('Thank you! Your review has been submitted.'));
    }
}
