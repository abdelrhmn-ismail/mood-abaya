<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class TransferMediaFromStorageCommand extends Command
{
    protected $signature = 'media:transfer-from-storage
                            {--dry-run : List actions without copying or deleting}
                            {--keep-storage : Keep files under storage/app/public after a successful copy}';

    protected $description = 'Copy all files from storage/app/public into public/media (same relative paths), sync DB paths to media/, then remove originals unless --keep-storage';

    public function handle(): int
    {
        $from = storage_path('app/public');
        $toBase = public_path('media');

        if (! is_dir($from)) {
            $this->warn('Nothing to do: storage/app/public does not exist.');

            return self::SUCCESS;
        }

        File::makeDirectory($toBase, 0755, true, true);

        $dryRun = (bool) $this->option('dry-run');
        $keepStorage = (bool) $this->option('keep-storage');

        $copied = 0;
        $skipped = 0;
        $removed = 0;
        $errors = 0;

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($from, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }

            if ($file->getFilename() === '.gitignore') {
                continue;
            }

            $full = $file->getPathname();
            $relativePath = substr($full, strlen($from) + 1);
            $relativePath = str_replace('\\', '/', $relativePath);

            if ($relativePath === '' || str_contains($relativePath, '..')) {
                continue;
            }

            $dest = $toBase.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

            if ($dryRun) {
                $this->line("[copy] {$relativePath} -> media/{$relativePath}");
                $copied++;

                continue;
            }

            File::makeDirectory(dirname($dest), 0755, true, true);

            if (is_file($dest)) {
                $srcSize = filesize($full);
                $dstSize = filesize($dest);
                if ($srcSize === $dstSize) {
                    $skipped++;
                    if (! $keepStorage) {
                        @unlink($full);
                        $removed++;
                    }

                    continue;
                }
            }

            try {
                if (! File::copy($full, $dest)) {
                    $this->error("Failed to copy: {$relativePath}");
                    $errors++;

                    continue;
                }
                $copied++;
                if (! $keepStorage) {
                    if (@unlink($full)) {
                        $removed++;
                    }
                }
            } catch (\Throwable $e) {
                $this->error("{$relativePath}: {$e->getMessage()}");
                $errors++;
            }
        }

        if (! $dryRun) {
            $this->syncDatabasePaths();
            $this->removeEmptyStorageDirs($from);
        }

        if ($dryRun) {
            $this->info("Dry run: {$copied} file(s) would be copied. Run without --dry-run to apply.");
        } else {
            $this->info("Copied: {$copied}, skipped (already same size): {$skipped}, removed from storage: {$removed}, errors: {$errors}.");
        }

        return $errors > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function syncDatabasePaths(): void
    {
        $total = 0;

        foreach (['products' => 'image', 'product_images' => 'image', 'categories' => 'image', 'posts' => 'image', 'testimonials' => 'photo', 'payments' => 'proof_path'] as $table => $column) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
                continue;
            }
            DB::table($table)
                ->whereNotNull($column)
                ->where($column, 'not like', 'http%')
                ->where($column, 'not like', 'media/%')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use ($table, $column, &$total): void {
                    foreach ($rows as $row) {
                        DB::table($table)->where('id', $row->id)->update([
                            $column => 'media/'.$row->{$column},
                        ]);
                        $total++;
                    }
                });
        }

        if (Schema::hasTable('settings')) {
            foreach (DB::table('settings')->get(['key', 'value']) as $row) {
                $value = $row->value;
                if (! is_string($value) || $value === '') {
                    continue;
                }
                if (str_starts_with($value, 'http') || str_starts_with($value, 'media/')) {
                    continue;
                }
                if (preg_match('#^(products|categories|hero|branding|posts|testimonials|popup|payments)/#', $value)) {
                    Setting::set($row->key, 'media/'.$value);
                    $total++;
                }
            }
        }

        if ($total > 0) {
            $this->info("Database paths prefixed with media/: {$total} row(s) updated.");
        } else {
            $this->comment('No database paths needed updating (already using media/ or external URLs).');
        }
    }

    private function removeEmptyStorageDirs(string $root): void
    {
        $dirs = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($dirs as $item) {
            if ($item->isDir()) {
                $path = $item->getPathname();
                if ($path === $root) {
                    continue;
                }
                @rmdir($path);
            }
        }
    }
}
