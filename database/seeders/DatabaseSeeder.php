<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SiteSettingsSeeder::class,
            FrontendBrandingSeeder::class,
            DesignSystemSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PageContentSeeder::class,
            HeroImagesSeeder::class,
            FaqSeeder::class,
            TestimonialSeeder::class,
            PostSeeder::class,
            AdminUserSeeder::class,
            PaymentGatewaySeeder::class,
        ]);
    }
}
