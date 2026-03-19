<?php

namespace Modules\Order\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShipOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'carrier' => 'required|string|max:255',
            'tracking_number' => 'required|string|max:255',
        ];
    }
}
