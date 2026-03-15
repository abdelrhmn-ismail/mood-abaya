<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['quote' => 'Beautiful abayas and fast shipping. I will definitely order again!', 'name' => 'Sara M.', 'sort_order' => 0],
            ['quote' => 'The quality exceeded my expectations. The jilbab is so comfortable.', 'name' => 'Fatima A.', 'sort_order' => 1],
            ['quote' => 'Great customer service and a lovely collection. Highly recommend Mood Abaya.', 'name' => 'Noor K.', 'sort_order' => 2],
        ];

        foreach ($items as $item) {
            Testimonial::updateOrCreate(
                ['name' => $item['name'], 'quote' => $item['quote']],
                array_merge($item, ['active' => true])
            );
        }
    }
}
