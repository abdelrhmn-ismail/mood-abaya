<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DesignSystemSeeder extends Seeder
{
    /**
     * Default color palette (matches resources/css/app.css).
     */
    public function run(): void
    {
        $defaults = [
            'color_brand_black' => '#000000',
            'color_brand_teal' => '#144034',
            'color_brand_teal_dark' => '#0f2d26',
            'color_brand_white' => '#FFFFFF',
            'color_brand_gold' => '#D3AE72',
            'color_brand_gold_dark' => '#b8945c',
        ];

        foreach ($defaults as $key => $value) {
            if (Setting::get($key, null) === null) {
                Setting::set($key, $value);
            }
        }
    }
}
