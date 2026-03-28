<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('site_name', 'Mood Abayas');
        Setting::set('tinymce_api_key', '1odorra76r1mkqn8kb9riicnjjrrrq7let8rtaowsmi1mmrm');
    }
}
