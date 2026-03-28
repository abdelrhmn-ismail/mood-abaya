<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Luxury Winter Abayas',
                    'ar' => 'عبايات شتوية فاخرة',
                ],
                'slug' => 'luxury-winter-abayas',
                'description' => [
                    'en' => 'Warm fabrics, luxury feel, and winter-ready designs. Includes suede & fur abayas, heavy crepe winter styles, and velvet varieties.',
                    'ar' => 'خامات دافئة وإحساس بالفخامة وتصاميم مناسبة للشتاء. تشمل عبايات الشامواه والفرو، عبايات كريب شتوية ثقيلة، وأنواع المخمل.',
                ],
                'sort_order' => 1,
                'image' => 'https://images.unsplash.com/photo-1750190321743-516413df29d0?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'name' => [
                    'en' => 'Evening & Occasion Abayas',
                    'ar' => 'عبايات مناسبات وسهرات',
                ],
                'slug' => 'evening-occasion-abayas',
                'description' => [
                    'en' => 'Elegant pieces for occasions, evenings, and formal looks. Velvet with shawl, embellishments, and pearl details.',
                    'ar' => 'قطع أنيقة للمناسبات والسهرات والإطلالات الرسمية. مخمل مع شال، تزيينات، وتفاصيل لؤلؤ.',
                ],
                'sort_order' => 2,
                'image' => 'https://images.unsplash.com/photo-1772474500365-c2c520545f44?q=80&w=687',
            ],
            [
                'name' => [
                    'en' => 'Ramadan & Oriental Collection',
                    'ar' => 'تشكيلة رمضان والقطع الشرقية',
                ],
                'slug' => 'ramadan-oriental-collection',
                'description' => [
                    'en' => 'Designs with a Ramadan spirit and an oriental touch—perfect for gatherings. Ramadan abayas, occasion dresses, and makhawar.',
                    'ar' => 'موديلات بروح رمضانية ولمسة شرقية مناسبة للتجمعات. عبايات رمضانية، فساتين مناسبات، ومخاور.',
                ],
                'sort_order' => 3,
                'image' => 'https://images.unsplash.com/photo-1556468644-cc4565f9b38b?q=80&w=1468',
            ],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['active' => true])
            );
        }
    }
}
