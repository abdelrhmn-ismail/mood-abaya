<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Shop\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService->getActiveCategories();

        return view('shop::frontend.categories', compact('categories'));
    }

    public function show(Request $request, string $slug): View|\Illuminate\Http\RedirectResponse
    {
        $category = $this->categoryService->findBySlug($slug);

        if (! $category) {
            abort(404);
        }

        $filters = [
            'sort' => $request->get('sort', 'name_asc'),
            'in_stock' => $request->boolean('in_stock'),
            'price_min' => $request->get('price_min'),
            'price_max' => $request->get('price_max'),
        ];
        $products = $this->categoryService->getProductsByCategory($category, $filters);

        return view('shop::frontend.category', compact('category', 'products', 'filters'));
    }
}
