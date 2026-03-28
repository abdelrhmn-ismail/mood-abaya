<?php

namespace Modules\Payment\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'description_en' => ['nullable', 'string', 'max:500'],
            'description_ar' => ['nullable', 'string', 'max:500'],
            'instructions_en' => ['nullable', 'string', 'max:10000'],
            'instructions_ar' => ['nullable', 'string', 'max:10000'],
            'is_active' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'requires_proof' => ['boolean'],
            'requires_admin_approval' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
            'requires_proof' => $this->has('requires_proof'),
            'requires_admin_approval' => $this->has('requires_admin_approval'),
        ]);
    }
}
