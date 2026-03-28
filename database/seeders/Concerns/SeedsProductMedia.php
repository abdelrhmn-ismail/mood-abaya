<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\File;

trait SeedsProductMedia
{
    /**
     * Expected layout: `storage/app/seed-assets/product-media/{product-slug}/`
     * with JPG/PNG/WebP images and optional MP4/WebM/MOV videos (recurses into subfolders).
     */
    private function productMediaSourceRoot(): string
    {
        return storage_path('app/seed-assets/product-media');
    }

    /**
     * @return array{main: ?string, gallery: array<int, string>, video: ?string}
     */
    protected function importProductMediaFromSeedFolder(string $slug): array
    {
        $base = $this->productMediaSourceRoot().DIRECTORY_SEPARATOR.$slug;
        if (! is_dir($base)) {
            return ['main' => null, 'gallery' => [], 'video' => null];
        }

        $images = [];
        $videos = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($base, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                $images[] = $file->getPathname();
            } elseif (in_array($ext, ['mp4', 'webm', 'mov'], true)) {
                $videos[] = $file->getPathname();
            }
        }

        usort($images, 'strnatcasecmp');
        usort($videos, 'strnatcasecmp');

        $videoPath = $this->copyVideoToPublic($slug, $videos[0] ?? null);

        if ($images === []) {
            return ['main' => null, 'gallery' => [], 'video' => $videoPath];
        }

        $relBase = 'products/'.$slug;
        $main = $this->copyFileToPublic($relBase, 'main', $images[0]);
        $gallery = [];
        foreach (array_slice($images, 1) as $i => $src) {
            $gallery[] = $this->copyFileToPublic($relBase, 'gallery-'.($i + 1), $src);
        }

        return ['main' => $main, 'gallery' => $gallery, 'video' => $videoPath];
    }

    private function copyFileToPublic(string $relBase, string $name, string $src): string
    {
        $ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
        $relative = $relBase.'/'.$name.'.'.$ext;
        $full = storage_path('app/public/'.$relative);
        File::makeDirectory(dirname($full), 0755, true, true);
        if (! File::copy($src, $full)) {
            throw new \RuntimeException('Failed to copy media file to: '.$full);
        }

        return $relative;
    }

    private function copyVideoToPublic(string $slug, ?string $src): ?string
    {
        if ($src === null || ! is_file($src)) {
            return null;
        }

        return $this->copyFileToPublic('products/'.$slug, 'video', $src);
    }
}
