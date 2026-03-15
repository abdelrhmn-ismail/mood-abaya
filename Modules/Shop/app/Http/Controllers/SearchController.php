<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
        $filters = [
            'sort' => $request->get('sort', 'name_asc'),
            'in_stock' => $request->boolean('in_stock'),
            'price_min' => $request->get('price_min'),
            'price_max' => $request->get('price_max'),
        ];
        $products = $q !== '' ? $this->productService->search($q, $filters) : new LengthAwarePaginator([], 0, 12);

        return view('frontend.search', [
            'q' => $q,
            'products' => $products,
            'filters' => $filters,
        ]);
    }
}
