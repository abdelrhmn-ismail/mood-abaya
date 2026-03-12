<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Abayas', 'slug' => 'abayas', 'description' => 'Elegant abayas for every occasion', 'sort_order' => 1],
            ['name' => 'Jilbabs', 'slug' => 'jilbabs', 'description' => 'Comfortable jilbabs', 'sort_order' => 2],
            ['name' => 'Hijabs', 'slug' => 'hijabs', 'description' => 'Quality hijabs and scarves', 'sort_order' => 3],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['active' => true])
            );
        }
    }
}
