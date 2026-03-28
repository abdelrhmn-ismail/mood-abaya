<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Legacy placeholders used media/products/{slug}.png and media/products/{slug}-gallery-n.png.
 * Align with nested public paths: media/products/{slug}/main.png and .../gallery-n.png.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->migrateMainImages();
        $this->migrateGalleryImages();
    }

    private function migrateMainImages(): void
    {
        $rows = DB::table('products')
            ->whereNotNull('image')
            ->where('image', 'like', 'media/products/%')
            ->where('image', 'not like', 'media/products/%/%')
            ->get(['id', 'image']);

        foreach ($rows as $row) {
            if (! preg_match('#^media/products/(.+)\.png$#', $row->image, $m)) {
                continue;
            }
            $slug = $m[1];
            if ($slug === '' || str_contains($slug, '/')) {
                continue;
            }
            if (preg_match('#-gallery-\d+$#', $slug)) {
                continue;
            }

            $newPath = 'media/products/'.$slug.'/main.png';
            $this->movePublicMediaFile($row->image, $newPath);
            DB::table('products')->where('id', $row->id)->update(['image' => $newPath]);
        }
    }

    private function migrateGalleryImages(): void
    {
        $rows = DB::table('product_images')
            ->whereNotNull('image')
            ->where('image', 'like', 'media/products/%')
            ->where('image', 'not like', 'media/products/%/%')
            ->get(['id', 'image']);

        foreach ($rows as $row) {
            if (! preg_match('#^media/products/(.+)-gallery-(\d+)\.png$#', $row->image, $m)) {
                continue;
            }
            $slug = $m[1];
            $n = $m[2];
            if ($slug === '' || str_contains($slug, '/')) {
                continue;
            }

            $newPath = 'media/products/'.$slug.'/gallery-'.$n.'.png';
            $this->movePublicMediaFile($row->image, $newPath);
            DB::table('product_images')->where('id', $row->id)->update(['image' => $newPath]);
        }
    }

    private function movePublicMediaFile(string $oldRelative, string $newRelative): void
    {
        $oldFull = public_path($oldRelative);
        $newFull = public_path($newRelative);

        if (! is_file($oldFull)) {
            return;
        }

        File::makeDirectory(dirname($newFull), 0755, true, true);

        if (is_file($newFull)) {
            @unlink($oldFull);
        } else {
            File::move($oldFull, $newFull);
        }
    }

    public function down(): void
    {
        // Intentionally empty: reversing could break real nested uploads that replaced placeholders.
    }
};
