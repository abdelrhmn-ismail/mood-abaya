<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FrontendBrandingSeeder extends Seeder
{
    /** Web-relative path under public/ (no leading slash). */
    public const LOGO_RELATIVE_PATH = 'media/branding/mood-design-logo.png';

    public function run(): void
    {
        $publicFile = public_path(self::LOGO_RELATIVE_PATH);
        $seedAsset = database_path('seeders/assets/mood-design-logo.png');

        if (! is_file($publicFile) && is_file($seedAsset)) {
            File::ensureDirectoryExists(dirname($publicFile));
            File::copy($seedAsset, $publicFile);
        }

        if (! is_file($publicFile)) {
            $this->command?->warn('Branding file missing at '.self::LOGO_RELATIVE_PATH.' — add database/seeders/assets/mood-design-logo.png or place the PNG in public/.');

            return;
        }

        Setting::set('site_logo', self::LOGO_RELATIVE_PATH);
        Setting::set('favicon', self::LOGO_RELATIVE_PATH);
    }
}
