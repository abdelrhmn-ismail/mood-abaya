<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Shop\Services\ProductService;

class SearchController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function index(Request $request): View
    {
        $q = (string) ($request->input('q') ?? '');
        $products = $q !== '' ? $this->productService->search($q) : collect();

        return view('frontend.search', [
            'q' => $q,
            'products' => $products,
        ]);
    }
}
