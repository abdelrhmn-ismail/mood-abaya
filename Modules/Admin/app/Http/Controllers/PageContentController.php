<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
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

    public function update(Request $request, PageContent $pageContent): RedirectResponse
    {
        $data = $request->validate([
            'page_content_en' => 'nullable|string',
            'page_content_ar' => 'nullable|string',
        ]);

        $this->pageContentService->update($pageContent, $data);

        return redirect()->route('admin.page-contents.index')->with('success', __('Page content updated.'));
    }
}
