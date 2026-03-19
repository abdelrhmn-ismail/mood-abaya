<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\StoreTestimonialRequest;
use Modules\Admin\Services\TestimonialService;

class TestimonialController
{
    public function __construct(private TestimonialService $testimonialService) {}

    public function index(): View
    {
        $testimonials = $this->testimonialService->getAll();

        return view('admin::testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        $testimonial = new Testimonial;

        return view('admin::testimonials.create', compact('testimonial'));
    }

    public function store(StoreTestimonialRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active');

        $this->testimonialService->create($data);

        return redirect()->route('admin.testimonials.index')->with('success', __('Testimonial added.'));
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin::testimonials.edit', compact('testimonial'));
    }

    public function update(StoreTestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active');

        $this->testimonialService->update($testimonial, $data);

        return redirect()->route('admin.testimonials.index')->with('success', __('Testimonial updated.'));
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->testimonialService->delete($testimonial);

        return redirect()->route('admin.testimonials.index')->with('success', __('Testimonial deleted.'));
    }
}
