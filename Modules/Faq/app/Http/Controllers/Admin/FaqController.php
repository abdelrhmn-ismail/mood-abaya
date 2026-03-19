<?php

namespace Modules\Faq\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Faq\Http\Requests\Admin\StoreFaqRequest;
use Modules\Faq\Services\Admin\FaqService;

class FaqController
{
    public function __construct(private FaqService $faqService) {}

    public function index(): View
    {
        $faqs = $this->faqService->getAll();

        return view('faq::admin.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('faq::admin.create');
    }

    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->faqService->create($data);

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ added.'));
    }

    public function edit(Faq $faq): View
    {
        return view('faq::admin.edit', compact('faq'));
    }

    public function update(StoreFaqRequest $request, Faq $faq): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->faqService->update($faq, $data);

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ updated.'));
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $this->faqService->delete($faq);

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ deleted.'));
    }
}
