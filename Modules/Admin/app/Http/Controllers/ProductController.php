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
        $products = $this->productService->getAll(
            $request->only('category_id', 'search', 'active', 'featured', 'sort', 'order'),
            admin_per_page()
        );
        $categories = $this->categoryService->getAll();

        return view('admin::products.index', compact('products', 'categories'));
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:products,id',
            'action' => 'required|in:activate,deactivate,delete',
        ]);
        $ids = $request->input('ids');
        $action = $request->input('action');
        $count = 0;
        if ($action === 'activate') {
            $count = $this->productService->bulkActivate($ids);
        } elseif ($action === 'deactivate') {
            $count = $this->productService->bulkDeactivate($ids);
        } elseif ($action === 'delete') {
            $count = $this->productService->bulkDelete($ids);
        }
        return redirect()->route('admin.products.index', $request->only('category_id', 'search', 'active', 'featured', 'per_page', 'sort', 'order'))
            ->with('success', __(':count record(s) updated.', ['count' => $count]));
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
            'name' => 'required|array',
            'name.en' => 'nullable|string|max:255',
            'name.ar' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'sku' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'stock' => 'nullable|integer|min:0',
            'min_order_qty' => 'nullable|integer|min:1',
            'max_order_qty' => 'nullable|integer|min:1',
            'weight_kg' => 'nullable|numeric|min:0',
            'active' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
        ]);
        $data['name'] = array_filter($data['name'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['description'] = array_filter($data['description'] ?? [], fn ($v) => $v !== null && $v !== '');
        if (empty($data['name'])) {
            return back()->withErrors(['name' => __('At least one language is required for name.')])->withInput();
        }
        $data['active'] = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');
        $data['stock'] = (int) ($data['stock'] ?? 0);
        $data['gallery_images'] = $request->file('images') ?? [];
        $this->productService->create($data);

        return redirect()->route('admin.products.index')->with('success', __('Product created.'));
    }

    public function edit(Product $product): View
    {
        $product->load('images', 'variants');
        $categories = $this->categoryService->getAll();

        return view('admin::products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|array',
            'name.en' => 'nullable|string|max:255',
            'name.ar' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'sku' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'delete_image_ids' => 'nullable|array',
            'delete_image_ids.*' => 'integer|exists:product_images,id',
            'stock' => 'nullable|integer|min:0',
            'min_order_qty' => 'nullable|integer|min:1',
            'max_order_qty' => 'nullable|integer|min:1',
            'weight_kg' => 'nullable|numeric|min:0',
            'active' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
        ]);
        $data['name'] = array_filter($data['name'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['description'] = array_filter($data['description'] ?? [], fn ($v) => $v !== null && $v !== '');
        if (empty($data['name'])) {
            return back()->withErrors(['name' => __('At least one language is required for name.')])->withInput();
        }
        $data['active'] = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');
        if (isset($data['stock'])) {
            $data['stock'] = (int) $data['stock'];
        }
        $data['gallery_images'] = $request->file('images') ?? [];
        $data['delete_image_ids'] = $request->input('delete_image_ids', []);
        $this->productService->update($product, $data);

        return redirect()->route('admin.products.index')->with('success', __('Product updated.'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->delete($product);

        return redirect()->route('admin.products.index')->with('success', __('Product deleted.'));
    }
}
