<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController
{
    public function __invoke(): Response
    {
        $base = rtrim(config('app.url'), '/');
        $urls = [];

        // Home
        $urls[] = ['loc' => $base . '/', 'changefreq' => 'daily', 'priority' => '1.0'];

        // Static routes
        foreach (['about', 'contact', 'categories', 'blog', 'cart'] as $path) {
            $urls[] = ['loc' => $base . '/' . $path, 'changefreq' => 'weekly', 'priority' => $path === 'about' || $path === 'contact' ? '0.9' : '0.8'];
        }

        // Categories
        $categories = Category::where('active', true)->get();
        foreach ($categories as $cat) {
            $urls[] = ['loc' => $base . '/categories/' . $cat->slug, 'changefreq' => 'weekly', 'priority' => '0.8'];
        }

        // Products
        $products = Product::where('active', true)->get();
        foreach ($products as $product) {
            $urls[] = ['loc' => $base . '/products/' . $product->slug, 'changefreq' => 'weekly', 'priority' => '0.7'];
        }

        // Blog posts
        $posts = Post::published()->get();
        foreach ($posts as $post) {
            $urls[] = ['loc' => $base . '/blog/' . $post->slug, 'changefreq' => 'monthly', 'priority' => '0.6'];
        }

        // Static pages (PageContent)
        $pages = PageContent::pluck('page_slug');
        foreach ($pages as $slug) {
            if (in_array($slug, ['about'], true)) {
                continue; // already added as /about
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

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
