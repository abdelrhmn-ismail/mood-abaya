<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_en' => 'required|string|max:500',
            'question_ar' => 'nullable|string|max:500',
            'answer_en' => 'required|string|max:10000',
            'answer_ar' => 'nullable|string|max:10000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }
}
