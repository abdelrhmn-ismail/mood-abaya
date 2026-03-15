<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Contact\Services\ContactService;

class ContactController extends Controller
{
    public function __construct(
        private ContactService $contactService
    ) {}

    public function showForm(): View
    {
        $faqs = Faq::active()->ordered()->get();

        return view('frontend.contact', compact('faqs'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
        ]);

        $this->contactService->submitMessage($validated);

        return redirect()
            ->route('contact')
            ->with('success', __('Thank you! Your message has been sent.'));
    }
}
