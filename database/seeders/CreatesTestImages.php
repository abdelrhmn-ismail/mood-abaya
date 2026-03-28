<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;

trait CreatesTestImages
{
    /**
     * Minimal valid PNG (1x1 pixel) as binary.
     */
    private static function minimalPng(): string
    {
        return base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='
        );
    }

    /**
     * Store a placeholder under public/media and return the path (e.g. "media/categories/foo.png").
     */
    protected function createTestImage(string $directory, string $filename): string
    {
        $filename = str_replace(['..', '/', '\\'], '', $filename);

        return $this->writeMinimalPngAt('media/'.$directory.'/'.$filename.'.png');
    }

    /**
     * Product main placeholder — nested under media/products/{slug}/main.png.
     */
    protected function createProductMainPlaceholder(string $slug): string
    {
        $slug = str_replace(['..', '/', '\\'], '', $slug);

        return $this->writeMinimalPngAt('media/products/'.$slug.'/main.png');
    }

    /**
     * Product gallery placeholder — same shape as imported gallery files (media/products/{slug}/gallery-n.png).
     */
    protected function createProductGalleryPlaceholder(string $slug, int $index): string
    {
        $slug = str_replace(['..', '/', '\\'], '', $slug);

        return $this->writeMinimalPngAt('media/products/'.$slug.'/gallery-'.$index.'.png');
    }

    protected function writeMinimalPngAt(string $relativePath): string
    {
        $relativePath = ltrim(str_replace(['..', '\\'], '', $relativePath), '/');
        if (! str_starts_with($relativePath, 'media/')) {
            throw new \InvalidArgumentException('Path must be under media/.');
        }
        $full = public_path($relativePath);
        File::makeDirectory(dirname($full), 0755, true, true);
        File::put($full, self::minimalPng());

        return $relativePath;
    }
}
