<?php

namespace App\Http\Controllers;

use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(
        private WishlistService $wishlistService
    ) {}

    /** Redirect to account page with wishlist tab (auth) or login with return url (guest). */
    public function index(): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('account')->withFragment('wishlist');
        }
        return redirect()->route('login', ['redirect' => route('account') . '#wishlist']);
    }

    /** Add product to wishlist (guest: stored in cache until login). */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $productId = (int) $request->product_id;
        $this->wishlistService->add($productId);
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok' => true,
                'message' => __('Added to wishlist.'),
                'wishlist_count' => $this->wishlistService->count(),
                'in_wishlist' => true,
            ]);
        }
        return redirect()->back()->with('success', __('Added to wishlist.'));
    }

    /** Remove product from wishlist. */
    public function destroy(Request $request, int $productId): RedirectResponse|JsonResponse
    {
        $this->wishlistService->remove($productId);
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok' => true,
                'message' => __('Removed from wishlist.'),
                'wishlist_count' => $this->wishlistService->count(),
                'in_wishlist' => false,
            ]);
        }
        return redirect()->back()->with('success', __('Removed from wishlist.'));
    }

    /** Toggle: add if not in wishlist, remove if in wishlist. */
    public function toggle(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $productId = (int) $request->product_id;
        $added = $this->wishlistService->toggle($productId);
        $message = $added ? __('Added to wishlist.') : __('Removed from wishlist.');
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok' => true,
                'added' => $added,
                'message' => $message,
                'wishlist_count' => $this->wishlistService->count(),
                'in_wishlist' => $added,
            ]);
        }
        return redirect()->back()->with('success', $message);
    }
}
