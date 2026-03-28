<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Payment\Services\PaymentMethodService;

class StoreCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $codes = array_column(config('phone_codes', []), 'code');
        $activeCodes = app(PaymentMethodService::class)->getActiveCodes();
        if ($activeCodes === []) {
            $activeCodes = ['__none__'];
        }

        return [
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', Rule::in($activeCodes)],
            'proof' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
                Rule::requiredIf(function () {
                    $code = $this->input('payment_method');
                    $m = app(PaymentMethodService::class)->getActiveByCode($code);

                    return $m && $m->requires_proof;
                }),
            ],
            'billing_use' => ['required', 'in:saved,new'],
            'billing_address_id' => [
                'required_if:billing_use,saved',
                'nullable',
                'integer',
                Rule::exists('billing_addresses', 'id')->where('user_id', $this->user()->id),
            ],
            'billing_full_name' => ['required_if:billing_use,new', 'nullable', 'string', 'max:255'],
            'billing_phone_country_code' => ['required_if:billing_use,new', 'nullable', 'string', 'in:' . implode(',', $codes)],
            'billing_phone_number' => ['required_if:billing_use,new', 'nullable', 'string', 'max:20'],
            'billing_address_line_1' => ['required_if:billing_use,new', 'nullable', 'string', 'max:255'],
            'billing_address_line_2' => ['nullable', 'string', 'max:255'],
            'billing_city' => ['required_if:billing_use,new', 'nullable', 'string', 'max:100'],
            'billing_state' => ['nullable', 'string', 'max:100'],
            'billing_postal_code' => ['nullable', 'string', 'max:20'],
            'billing_country' => ['nullable', 'string', 'max:100'],
            'save_billing_address' => ['nullable', 'boolean'],
            'shipping_zone_id' => ['nullable', 'string', 'max:50'],
        ];
    }
}
