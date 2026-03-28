<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Copy files from storage/app/public/* into public/media/* and prefix DB paths with media/
     * so uploads are served from /media/... without the storage symlink.
     */
    public function up(): void
    {
        $from = storage_path('app/public');
        $to = public_path('media');
        if (! is_dir($to)) {
            File::makeDirectory($to, 0755, true);
        }

        foreach (['products', 'categories', 'hero', 'branding', 'posts', 'testimonials', 'popup', 'payments'] as $dir) {
            $src = $from.DIRECTORY_SEPARATOR.$dir;
            if (is_dir($src)) {
                File::copyDirectory($src, $to.DIRECTORY_SEPARATOR.$dir);
            }
        }

        $prefix = function (string $table, string $column): void {
            DB::table($table)
                ->whereNotNull($column)
                ->where($column, 'not like', 'http%')
                ->where($column, 'not like', 'media/%')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use ($table, $column): void {
                    foreach ($rows as $row) {
                        DB::table($table)->where('id', $row->id)->update([
                            $column => 'media/'.$row->{$column},
                        ]);
                    }
                });
        };

        foreach (['products' => 'image', 'product_images' => 'image', 'categories' => 'image', 'posts' => 'image', 'testimonials' => 'photo', 'payments' => 'proof_path'] as $table => $column) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, $column)) {
                $prefix($table, $column);
            }
        }

        if (Schema::hasTable('settings')) {
            $keys = DB::table('settings')->pluck('value', 'key');
            foreach ($keys as $key => $value) {
                if (! is_string($value) || $value === '') {
                    continue;
                }
                if (str_starts_with($value, 'http') || str_starts_with($value, 'media/')) {
                    continue;
                }
                if (preg_match('#^(products|categories|hero|branding|posts|testimonials|popup|payments)/#', $value)) {
                    Setting::set($key, 'media/'.$value);
                }
            }
        }
    }

    public function down(): void
    {
        // Intentionally empty: files are not moved back.
    }
};
