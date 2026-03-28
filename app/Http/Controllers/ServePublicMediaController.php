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
        $fileReal = realpath($full);

        if ($baseReal === false || $fileReal === false || ! str_starts_with($fileReal, $baseReal) || ! is_file($fileReal)) {
            abort(404);
        }

        return response()->file($fileReal);
    }
}
