<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Contact\Http\Requests\StoreContactRequest;
use Modules\Contact\Services\ContactService;

class ContactController extends Controller
{
    public function __construct(
        private ContactService $contactService
    ) {}

    public function showForm(): View
    {
        $faqs = Faq::active()->ordered()->get();

        return view('contact::frontend.contact', compact('faqs'));
    }

    public function submit(StoreContactRequest $request): RedirectResponse
    {
        $this->contactService->submitMessage($request->validated());

        return redirect()
            ->route('contact')
            ->with('success', __('Thank you! Your message has been sent.'));
    }
}
