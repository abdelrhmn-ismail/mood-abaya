<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController
{
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();

        return view('admin::testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        $testimonial = new Testimonial;

        return view('admin::testimonials.create', compact('testimonial'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'quote' => 'required|string|max:2000',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['active'] = $request->boolean('active');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        } else {
            $data['photo'] = null;
        }
        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', __('Testimonial added.'));
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin::testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validate([
            'quote' => 'required|string|max:2000',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['active'] = $request->boolean('active');
        if ($request->hasFile('photo')) {
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        } else {
            unset($data['photo']);
        }
        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', __('Testimonial updated.'));
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', __('Testimonial deleted.'));
    }
}
