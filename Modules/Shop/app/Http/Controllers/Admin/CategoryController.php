<?php

namespace Modules\Shop\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Shop\Http\Requests\Admin\BulkCategoryActionRequest;
use Modules\Shop\Http\Requests\Admin\StoreCategoryRequest;
use Modules\Shop\Services\Admin\CategoryService;

class CategoryController
{
    public function __construct(
        private CategoryService $categoryService
    ) {}

    public function index(Request $request): View
    {
        $categories = $this->categoryService->getForIndex(
            $request->only('search', 'active', 'sort', 'order'),
            admin_per_page()
        );

        return view('shop::admin.categories.index', compact('categories'));
    }

    public function bulkAction(BulkCategoryActionRequest $request): RedirectResponse
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        $count = 0;
        if ($action === 'activate') {
            $count = $this->categoryService->bulkActivate($ids);
        } elseif ($action === 'deactivate') {
            $count = $this->categoryService->bulkDeactivate($ids);
        } elseif ($action === 'delete') {
            $count = $this->categoryService->bulkDelete($ids);
        }

        return redirect()->route('admin.categories.index', $request->only('search', 'active', 'per_page', 'sort', 'order'))
            ->with('success', __(':count record(s) updated.', ['count' => $count]));
    }

    public function create(): View
    {
        return view('shop::admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['name'] = array_filter($data['name'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['description'] = array_filter($data['description'] ?? [], fn ($v) => $v !== null && $v !== '');
        if (empty($data['name'])) {
            return back()->withErrors(['name' => __('At least one language is required for name.')])->withInput();
        }
        $data['active'] = $request->boolean('active');
        $this->categoryService->create($data);

        return redirect()->route('admin.categories.index')->with('success', __('Category created.'));
    }

    public function edit(Category $category): View
    {
        return view('shop::admin.categories.edit', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['name'] = array_filter($data['name'] ?? [], fn ($v) => $v !== null && $v !== '');
        $data['description'] = array_filter($data['description'] ?? [], fn ($v) => $v !== null && $v !== '');
        if (empty($data['name'])) {
            return back()->withErrors(['name' => __('At least one language is required for name.')])->withInput();
        }
        $data['active'] = $request->boolean('active');
        $this->categoryService->update($category, $data);

        return redirect()->route('admin.categories.index')->with('success', __('Category updated.'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->delete($category);

        return redirect()->route('admin.categories.index')->with('success', __('Category deleted.'));
    }
}
