<?php

namespace Modules\Page\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = PageContent::where('page_slug', $slug)->firstOrFail();
        $locale = app()->getLocale();
        $content = $locale === 'ar' && $page->page_content_ar
            ? $page->page_content_ar
            : ($page->page_content_en ?? $page->page_content_ar ?? '');

        return view('page::frontend.page', [
            'page' => $page,
            'content' => $content,
        ]);
    }
}