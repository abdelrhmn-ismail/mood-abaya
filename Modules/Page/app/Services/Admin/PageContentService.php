<?php

namespace Modules\Page\Services\Admin;

use App\Models\PageContent;
use Illuminate\Database\Eloquent\Collection;

class PageContentService
{
    public function getAll(?string $search = null): Collection
    {
        $query = PageContent::orderBy('page_name');

        if ($search) {
            $term = '%' . $search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('page_name', 'like', $term)->orWhere('page_slug', 'like', $term);
            });
        }

        return $query->get();
    }

    public function update(PageContent $pageContent, array $data): PageContent
    {
        $pageContent->page_content_en = $data['page_content_en'] ?? null;
        $pageContent->page_content_ar = $data['page_content_ar'] ?? null;
        $pageContent->save();

        return $pageContent;
    }
}
