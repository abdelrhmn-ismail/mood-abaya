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
     * Store a placeholder under public/media and return the path (e.g. "media/posts/foo.png").
     */
    protected function createTestImage(string $directory, string $filename): string
    {
        $filename = str_replace(['..', '/', '\\'], '', $filename);
        $directory = trim(str_replace(['..', '\\'], '', $directory), '/');
        $relativePath = 'media/'.$directory.'/'.$filename.'.png';
        $full = public_path($relativePath);
        File::makeDirectory(dirname($full), 0755, true, true);
        File::put($full, self::minimalPng());

        return $relativePath;
    }
}
