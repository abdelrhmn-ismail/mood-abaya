<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWishlistRequest;
use Modules\Shop\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(
        private WishlistService $wishlistService
    ) {}

    public function index(): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('account')->withFragment('wishlist');
        }

        return redirect()->route('login', ['redirect' => route('account') . '#wishlist']);
    }

    public function store(StoreWishlistRequest $request): RedirectResponse|JsonResponse
    {
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

    public function toggle(StoreWishlistRequest $request): RedirectResponse|JsonResponse
    {
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
