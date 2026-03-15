<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => __('Please enter your email.'),
            'email.email' => __('Please enter a valid email address.'),
        ]);

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
