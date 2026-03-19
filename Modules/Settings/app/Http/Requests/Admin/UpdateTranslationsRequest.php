<?php

namespace Modules\Settings\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'translations' => 'required|array',
            'translations.*.en' => 'nullable|string|max:1000',
            'translations.*.ar' => 'nullable|string|max:1000',
        ];
    }
}
