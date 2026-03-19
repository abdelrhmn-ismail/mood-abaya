<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Shop\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function show(Request $request, string $slug): View|\Illuminate\Http\RedirectResponse
    {
        $product = $this->productService->findBySlug($slug);

        if (! $product) {
            abort(404);
        }

        $product->load([
            'images',
            'variants',
            'reviews' => fn ($q) => $q->where('is_visible', true)->with('user')->orderByDesc('created_at'),
        ]);

        // Recently viewed: push current id, keep last 10
        $recent = $request->session()->get('recently_viewed_ids', []);
        $recent = array_values(array_diff($recent, [$product->id]));
        array_unshift($recent, $product->id);
        $request->session()->put('recently_viewed_ids', array_slice($recent, 0, 10));

        $relatedProducts = $this->productService->getRelatedProducts($product, 4);
        $recentlyViewedIds = array_values(array_diff($request->session()->get('recently_viewed_ids', []), [$product->id]));
        $recentlyViewed = $this->productService->getByIds($recentlyViewedIds, 6);

        return view('shop::frontend.product', compact('product', 'relatedProducts', 'recentlyViewed'));
    }
}
