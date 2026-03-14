<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\Request;
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

        return view('frontend.page', [
            'page' => $page,
            'content' => $content,
        ]);
    }
}
