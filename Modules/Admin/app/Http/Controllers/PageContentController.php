<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageContentController
{
    public function index(Request $request): View
    {
        $query = PageContent::orderBy('page_name');
        if (!empty($request->get('search'))) {
            $term = '%' . $request->get('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('page_name', 'like', $term)->orWhere('page_slug', 'like', $term);
            });
        }
        $pages = $query->get();

        return view('admin::page-contents.index', compact('pages'));
    }

    public function edit(PageContent $pageContent): View
    {
        return view('admin::page-contents.edit', ['page' => $pageContent]);
    }

    public function update(Request $request, PageContent $pageContent): RedirectResponse
    {
        $request->validate([
            'page_content_en' => 'nullable|string',
            'page_content_ar' => 'nullable|string',
        ]);

        $pageContent->page_content_en = $request->input('page_content_en');
        $pageContent->page_content_ar = $request->input('page_content_ar');
        $pageContent->save();

        return redirect()->route('admin.page-contents.index')->with('success', __('Page content updated.'));
    }
}
