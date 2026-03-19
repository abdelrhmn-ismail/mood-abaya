<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;

use Modules\Core\Services\SitemapService;
use Illuminate\Http\Response;

class SitemapController
{
    public function __invoke(SitemapService $sitemapService): Response
    {
        return response($sitemapService->generateXml(), 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
