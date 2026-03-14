<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use CreatesTestImages;

    public function run(): void
    {
        $categories = [
            [
                'name' => ['en' => 'Abayas', 'ar' => 'عبايات'],
                'slug' => 'abayas',
                'description' => ['en' => 'Elegant abayas for every occasion', 'ar' => 'عبايات أنيقة لكل مناسبة'],
                'sort_order' => 1,
            ],
            [
                'name' => ['en' => 'Jilbabs', 'ar' => 'جلابيات'],
                'slug' => 'jilbabs',
                'description' => ['en' => 'Comfortable jilbabs', 'ar' => 'جلابيات مريحة'],
                'sort_order' => 2,
            ],
            [
                'name' => ['en' => 'Hijabs', 'ar' => 'حجاب'],
                'slug' => 'hijabs',
                'description' => ['en' => 'Quality hijabs and scarves', 'ar' => 'حجاب وشارات عالية الجودة'],
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $data) {
            $slug = $data['slug'];
            $imagePath = $this->createTestImage('categories', $slug);
            Category::updateOrCreate(
                ['slug' => $slug],
                array_merge($data, ['image' => $imagePath, 'active' => true])
            );
        }
    }
}
