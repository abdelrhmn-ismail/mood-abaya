<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['page_name' => 'Terms & Conditions', 'page_slug' => 'terms'],
            ['page_name' => 'Privacy Policy', 'page_slug' => 'privacy'],
            ['page_name' => 'Shipping Policy', 'page_slug' => 'shipping'],
            ['page_name' => 'Return & Refund Policy', 'page_slug' => 'return-refund'],
        ];

        foreach ($pages as $page) {
            PageContent::updateOrCreate(
                ['page_slug' => $page['page_slug']],
                array_merge($page, [
                    'page_content_en' => null,
                    'page_content_ar' => null,
                ])
            );
        }
    }
}
