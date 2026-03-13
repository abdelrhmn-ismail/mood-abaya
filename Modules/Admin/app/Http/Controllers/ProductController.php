<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Admin\Services\CategoryService;
use Modules\Admin\Services\ProductService as AdminProductService;

class ProductController
{
    public function __construct(
        private AdminProductService $productService,
        private CategoryService $categoryService
    ) {}

    public function index(Request $request): View
    {
        $products = $this->productService->getAll($request->only('category_id', 'search'));
        $categories = $this->categoryService->getAll();

        return view('admin::products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = $this->categoryService->getAll();

        return view('admin::products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'stock' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);
        $data['active'] = $request->boolean('active');
        $data['stock'] = (int) ($data['stock'] ?? 0);
        $this->productService->create($data);

        return redirect()->route('admin.products.index')->with('success', __('Product created.'));
    }

    public function edit(Product $product): View
    {
        $categories = $this->categoryService->getAll();

        return view('admin::products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'stock' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);
        $data['active'] = $request->boolean('active');
        if (isset($data['stock'])) {
            $data['stock'] = (int) $data['stock'];
        }
        $this->productService->update($product, $data);

        return redirect()->route('admin.products.index')->with('success', __('Product updated.'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->delete($product);

        return redirect()->route('admin.products.index')->with('success', __('Product deleted.'));
    }
}
