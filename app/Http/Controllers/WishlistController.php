<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /** Redirect to account page with wishlist tab. */
    public function index(): RedirectResponse
    {
        return redirect()->route('account')->withFragment('wishlist');
    }

    /** Add product to wishlist. */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $productId = (int) $request->product_id;
        Wishlist::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $productId],
            ['user_id' => auth()->id(), 'product_id' => $productId]
        );
        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'message' => __('Added to wishlist.')]);
        }
        return redirect()->back()->with('success', __('Added to wishlist.'));
    }

    /** Remove product from wishlist. */
    public function destroy(Request $request, int $productId): RedirectResponse
    {
        Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->delete();
        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'message' => __('Removed from wishlist.')]);
        }
        return redirect()->back()->with('success', __('Removed from wishlist.'));
    }

    /** Toggle: add if not in wishlist, remove if in wishlist. */
    public function toggle(Request $request): RedirectResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $productId = (int) $request->product_id;
        $exists = Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->exists();
        if ($exists) {
            Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->delete();
            $message = __('Removed from wishlist.');
        } else {
            Wishlist::firstOrCreate(
                ['user_id' => auth()->id(), 'product_id' => $productId],
                ['user_id' => auth()->id(), 'product_id' => $productId]
            );
            $message = __('Added to wishlist.');
        }
        return redirect()->back()->with('success', $message);
    }
}
