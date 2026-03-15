<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController
{
    public function index(): View
    {
        $faqs = Faq::ordered()->get();

        return view('admin::faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin::faqs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'question_en' => 'required|string|max:500',
            'question_ar' => 'nullable|string|max:500',
            'answer_en' => 'required|string|max:10000',
            'answer_ar' => 'nullable|string|max:10000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');
        Faq::create($data);

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ added.'));
    }

    public function edit(Faq $faq): View
    {
        return view('admin::faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $data = $request->validate([
            'question_en' => 'required|string|max:500',
            'question_ar' => 'nullable|string|max:500',
            'answer_en' => 'required|string|max:10000',
            'answer_ar' => 'nullable|string|max:10000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');
        $faq->update($data);

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ updated.'));
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ deleted.'));
    }
}
