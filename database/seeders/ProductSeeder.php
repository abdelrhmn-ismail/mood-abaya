<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use CreatesTestImages;

    public function run(): void
    {
        $abaya = Category::where('slug', 'abayas')->first();
        $jilbab = Category::where('slug', 'jilbabs')->first();
        $hijab = Category::where('slug', 'hijabs')->first();

        $products = [
            [
                'category_id' => $abaya?->id,
                'name' => ['en' => 'Classic Black Abaya', 'ar' => 'عباية سوداء كلاسيكية'],
                'slug' => 'classic-black-abaya',
                'description' => ['en' => 'Elegant classic black abaya, perfect for daily wear.', 'ar' => 'عباية سوداء كلاسيكية أنيقة، مثالية للارتداء اليومي.'],
                'short_description' => 'Classic black abaya for daily wear.',
                'price' => 199.00,
                'compare_at_price' => 249.00,
                'stock' => 25,
                'sku' => 'ABY-001',
                'featured' => true,
            ],
            [
                'category_id' => $abaya?->id,
                'name' => ['en' => 'Embroidered Abaya', 'ar' => 'عباية مطرزة'],
                'slug' => 'embroidered-abaya',
                'description' => ['en' => 'Beautiful embroidered abaya for special occasions.', 'ar' => 'عباية مطرزة جميلة للمناسبات الخاصة.'],
                'short_description' => 'Embroidered abaya for special occasions.',
                'price' => 349.00,
                'stock' => 15,
                'sku' => 'ABY-002',
            ],
            [
                'category_id' => $jilbab?->id,
                'name' => ['en' => 'Casual Jilbab', 'ar' => 'جلباب كاجوال'],
                'slug' => 'casual-jilbab',
                'description' => ['en' => 'Comfortable casual jilbab in soft fabric.', 'ar' => 'جلباب كاجوال مريح من قماش ناعم.'],
                'short_description' => 'Comfortable casual jilbab.',
                'price' => 129.00,
                'compare_at_price' => 159.00,
                'stock' => 30,
                'sku' => 'JLB-001',
                'featured' => true,
            ],
            [
                'category_id' => $hijab?->id,
                'name' => ['en' => 'Premium Hijab Set', 'ar' => 'طقم حجاب مميز'],
                'slug' => 'premium-hijab-set',
                'description' => ['en' => 'Set of three premium quality hijabs.', 'ar' => 'طقم من ثلاثة حجابات عالية الجودة.'],
                'short_description' => 'Set of three premium hijabs.',
                'price' => 59.00,
                'stock' => 50,
                'sku' => 'HIJ-001',
            ],
        ];

        foreach ($products as $data) {
            if (empty($data['category_id'])) {
                continue;
            }
            $slug = $data['slug'];
            $imagePath = $this->createTestImage('products', $slug);
            $data['image'] = $imagePath;
            $data['active'] = true;
            Product::updateOrCreate(
                [
                    'category_id' => $data['category_id'],
                    'slug' => $slug,
                ],
                $data
            );
        }
    }
}
