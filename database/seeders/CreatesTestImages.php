<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;

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
     * Store a placeholder image in the given directory and return the path (e.g. "categories/abayas.jpg").
     */
    protected function createTestImage(string $directory, string $filename): string
    {
        $path = $directory . '/' . $filename . '.png';
        Storage::disk('public')->put($path, self::minimalPng());

        return $path;
    }
}
