<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function store(StoreNewsletterRequest $request): JsonResponse|RedirectResponse
    {
        NewsletterSubscriber::firstOrCreate(
            ['email' => strtolower($request->input('email'))],
            ['email' => strtolower($request->input('email'))]
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Thank you! You are subscribed to our newsletter.'),
            ]);
        }

        return back()->with('success', __('Thank you! You are subscribed to our newsletter.'));
    }
}
