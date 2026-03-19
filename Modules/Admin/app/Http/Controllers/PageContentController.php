<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\UpdatePageContentRequest;
use Modules\Admin\Services\PageContentService;

class PageContentController
{
    public function __construct(private PageContentService $pageContentService) {}

    public function index(Request $request): View
    {
        $pages = $this->pageContentService->getAll($request->get('search'));

        return view('admin::page-contents.index', compact('pages'));
    }

    public function edit(PageContent $pageContent): View
    {
        return view('admin::page-contents.edit', ['page' => $pageContent]);
    }

    public function update(UpdatePageContentRequest $request, PageContent $pageContent): RedirectResponse
    {
        $this->pageContentService->update($pageContent, $request->validated());

        return redirect()->route('admin.page-contents.index')->with('success', __('Page content updated.'));
    }
}
