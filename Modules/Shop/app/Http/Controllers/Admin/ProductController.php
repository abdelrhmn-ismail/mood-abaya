<?php

namespace Modules\Shop\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Shop\Http\Requests\Admin\BulkProductActionRequest;
use Modules\Shop\Http\Requests\Admin\StoreProductRequest;
use Modules\Shop\Http\Requests\Admin\UpdateProductRequest;
use Modules\Shop\Services\Admin\CategoryService;
use Modules\Shop\Services\Admin\ProductService as AdminProductService;

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

        return view('shop::admin.products.index', compact('products', 'categories'));
    }

    public function bulkAction(BulkProductActionRequest $request): RedirectResponse
    {
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

        return view('shop::admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['name'] = array_filter($data['name'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['description'] = array_filter($data['description'] ?? [], fn ($v) => $v !== null && $v !== '');
        if (empty($data['name'])) {
            return back()->withErrors(['name' => __('At least one language is required for name.')])->withInput();
        }
        $data['active'] = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');
        $data['stock'] = (int) ($data['stock'] ?? 0);
        $data['gallery_images'] = $request->file('images') ?? [];
        $data['video_file'] = $request->file('video_file');
        $this->productService->create($data);

        return redirect()->route('admin.products.index')->with('success', __('Product created.'));
    }

    public function edit(Product $product): View
    {
        $product->load('images', 'variants');
        $categories = $this->categoryService->getAll();

        return view('shop::admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
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
        $data['video_file'] = $request->file('video_file');
        $data['remove_video'] = $request->boolean('remove_video');
        $this->productService->update($product, $data);

        return redirect()->route('admin.products.index')->with('success', __('Product updated.'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->delete($product);

        return redirect()->route('admin.products.index')->with('success', __('Product deleted.'));
    }
}
