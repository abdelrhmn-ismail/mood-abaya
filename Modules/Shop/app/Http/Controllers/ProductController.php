<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Modules\Shop\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function show(string $slug): View|\Illuminate\Http\RedirectResponse
    {
        $product = $this->productService->findBySlug($slug);

        if (! $product) {
            abort(404);
        }

        $product->load([
            'reviews' => fn ($q) => $q->where('is_visible', true)->with('user')->orderByDesc('created_at'),
        ]);

        return view('frontend.product', compact('product'));
    }
}
