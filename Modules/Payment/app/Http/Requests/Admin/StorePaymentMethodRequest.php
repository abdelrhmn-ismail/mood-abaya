<?php

namespace Modules\Payment\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:64',
                'regex:/^[a-z][a-z0-9_]*$/',
                Rule::unique('payment_methods', 'code'),
            ],
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
        if ($this->has('code')) {
            $this->merge(['code' => strtolower((string) $this->input('code'))]);
        }
        $this->merge([
            'is_active' => $this->has('is_active'),
            'requires_proof' => $this->has('requires_proof'),
            'requires_admin_approval' => $this->has('requires_admin_approval'),
        ]);
    }
}
