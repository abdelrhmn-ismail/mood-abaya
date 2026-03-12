<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $abaya = Category::where('slug', 'abayas')->first();
        $jilbab = Category::where('slug', 'jilbabs')->first();
        $hijab = Category::where('slug', 'hijabs')->first();

        $products = [
            [
                'category_id' => $abaya?->id,
                'name' => 'Classic Black Abaya',
                'slug' => 'classic-black-abaya',
                'description' => 'Elegant classic black abaya, perfect for daily wear.',
                'price' => 199.00,
                'stock' => 25,
            ],
            [
                'category_id' => $abaya?->id,
                'name' => 'Embroidered Abaya',
                'slug' => 'embroidered-abaya',
                'description' => 'Beautiful embroidered abaya for special occasions.',
                'price' => 349.00,
                'stock' => 15,
            ],
            [
                'category_id' => $jilbab?->id,
                'name' => 'Casual Jilbab',
                'slug' => 'casual-jilbab',
                'description' => 'Comfortable casual jilbab in soft fabric.',
                'price' => 129.00,
                'stock' => 30,
            ],
            [
                'category_id' => $hijab?->id,
                'name' => 'Premium Hijab Set',
                'slug' => 'premium-hijab-set',
                'description' => 'Set of three premium quality hijabs.',
                'price' => 59.00,
                'stock' => 50,
            ],
        ];

        foreach ($products as $data) {
            if (empty($data['category_id'])) {
                continue;
            }
            Product::updateOrCreate(
                [
                    'category_id' => $data['category_id'],
                    'slug' => $data['slug'],
                ],
                array_merge($data, ['active' => true])
            );
        }
    }
}
