<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DesignSystemSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ColorPaletteSeeder::class);
    }
}
