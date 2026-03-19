<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.en' => 'required_with:title|string|max:255',
            'title.ar' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.en' => 'nullable|string|max:1000',
            'excerpt.ar' => 'nullable|string|max:1000',
            'body' => 'nullable|array',
            'body.en' => 'nullable|string',
            'body.ar' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|array',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_title.ar' => 'nullable|string|max:255',
            'meta_description' => 'nullable|array',
            'meta_description.en' => 'nullable|string|max:500',
            'meta_description.ar' => 'nullable|string|max:500',
        ];
    }
}
