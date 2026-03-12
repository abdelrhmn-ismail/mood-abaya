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

        return view('frontend.categories', compact('categories'));
    }

    public function show(Request $request, string $slug): View|\Illuminate\Http\RedirectResponse
    {
        $category = $this->categoryService->findBySlug($slug);

        if (! $category) {
            abort(404);
        }

        $products = $this->categoryService->getProductsByCategory($category);

        return view('frontend.category', compact('category', 'products'));
    }
}
