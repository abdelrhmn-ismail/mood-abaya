<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\StoreFaqRequest;
use Modules\Admin\Services\FaqService;

class FaqController
{
    public function __construct(private FaqService $faqService) {}

    public function index(): View
    {
        $faqs = $this->faqService->getAll();

        return view('admin::faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin::faqs.create');
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
        return view('admin::faqs.edit', compact('faq'));
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
