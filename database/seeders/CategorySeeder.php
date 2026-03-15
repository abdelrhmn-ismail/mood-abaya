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
                'description' => [
                    'en' => 'Elegant abayas for every occasion. Wide cuts, crepe, chiffon, lace details and back pleats—modest and stylish.',
                    'ar' => 'عبايات أنيقة لكل مناسبة. قصات واسعة، كريب، شيفون، تفاصيل دانتيل وكسرات خلفية—محتشمة وأنيقة.',
                ],
                'sort_order' => 1,
            ],
            [
                'name' => ['en' => 'Jilbabs', 'ar' => 'جلابيب'],
                'slug' => 'jilbabs',
                'description' => [
                    'en' => 'Comfortable jilbabs for daily wear and occasions. Soft fabrics and relaxed fits.',
                    'ar' => 'جلابيب مريحة للارتداء اليومي والمناسبات. أقمشة ناعمة وقصات مريحة.',
                ],
                'sort_order' => 2,
            ],
            [
                'name' => ['en' => 'Hijabs', 'ar' => 'حجاب'],
                'slug' => 'hijabs',
                'description' => [
                    'en' => 'Quality hijabs and scarves. Jersey, chiffon and premium fabrics for a polished look.',
                    'ar' => 'حجاب وشارات عالية الجودة. جيرسي وشيفون وأقمشة مميزة لإطلالة مصقولة.',
                ],
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
