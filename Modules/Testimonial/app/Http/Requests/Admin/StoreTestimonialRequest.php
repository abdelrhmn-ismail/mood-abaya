<?php

namespace Modules\Testimonial\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quote' => 'required|string|max:2000',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ];
    }
}
