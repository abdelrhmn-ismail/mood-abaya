<?php

namespace App\Services;

use App\Models\Category;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Product;

class SitemapService
{
    public function generateXml(): string
    {
        $base = rtrim(config('app.url'), '/');
        $urls = [];

        $urls[] = ['loc' => $base . '/', 'changefreq' => 'daily', 'priority' => '1.0'];

        foreach (['about', 'contact', 'categories', 'blog', 'cart'] as $path) {
            $urls[] = [
                'loc' => $base . '/' . $path,
                'changefreq' => 'weekly',
                'priority' => in_array($path, ['about', 'contact']) ? '0.9' : '0.8',
            ];
        }

        foreach (Category::where('active', true)->get() as $cat) {
            $urls[] = ['loc' => $base . '/categories/' . $cat->slug, 'changefreq' => 'weekly', 'priority' => '0.8'];
        }

        foreach (Product::where('active', true)->get() as $product) {
            $urls[] = ['loc' => $base . '/products/' . $product->slug, 'changefreq' => 'weekly', 'priority' => '0.7'];
        }

        foreach (Post::published()->get() as $post) {
            $urls[] = ['loc' => $base . '/blog/' . $post->slug, 'changefreq' => 'monthly', 'priority' => '0.6'];
        }

        foreach (PageContent::pluck('page_slug') as $slug) {
            if ($slug === 'about') {
                continue;
            }
            $urls[] = ['loc' => $base . '/page/' . $slug, 'changefreq' => 'monthly', 'priority' => '0.5'];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc']) . '</loc>' . "\n";
            $xml .= '    <changefreq>' . $u['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $u['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }
        $xml .= '</urlset>';

        return $xml;
    }
}
