<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ServePublicMediaController extends Controller
{
    /**
     * Stream files from public/media (avoids Apache/IIS 403 when OS permissions block the web server from reading static files).
     */
    public function __invoke(Request $request): BinaryFileResponse|Response
    {
        $path = $request->route('path') ?? '';
        if (! is_string($path) || $path === '') {
            abort(404);
        }

        $relative = str_replace(['..', '\\'], '', $path);
        $relative = ltrim(str_replace('\\', '/', $relative), '/');

        $mediaRoot = public_path('media');
        $full = $mediaRoot.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relative);

        $baseReal = realpath($mediaRoot);
        if ($baseReal === false || ! is_dir($baseReal)) {
            abort(404);
        }

        $fileReal = realpath($full);
        if ($fileReal === false || ! is_file($fileReal)) {
            abort(404);
        }

        if (! str_starts_with($fileReal, $baseReal)) {
            abort(404);
        }

        if (! is_readable($fileReal)) {
            abort(404);
        }

        return response()->file($fileReal);
    }
}
