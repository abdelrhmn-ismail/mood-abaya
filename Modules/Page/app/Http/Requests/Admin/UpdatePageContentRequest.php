<?php

namespace Modules\Page\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page_content_en' => 'nullable|string',
            'page_content_ar' => 'nullable|string',
        ];
    }
}
