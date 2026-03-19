<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class ColorPaletteSeeder extends Seeder
{
    /**
     * Brand color palette – seeds the current design system colors into the settings table.
     * Existing values are preserved; only missing keys get the defaults.
     */
    public function run(): void
    {
        $colors = [
            'color_brand_black'     => '#000000',
            'color_brand_teal'      => '#144034',
            'color_brand_teal_dark' => '#0f2d26',
            'color_brand_white'     => '#FFFFFF',
            'color_brand_gold'      => '#D3AE72',
            'color_brand_gold_dark' => '#b8945c',
        ];

        foreach ($colors as $key => $hex) {
            $existing = Setting::find($key);
            if (!$existing) {
                Setting::create(['key' => $key, 'value' => $hex]);
            }
        }

        $this->command->info('Color palette seeded (' . count($colors) . ' colors).');
    }
}
