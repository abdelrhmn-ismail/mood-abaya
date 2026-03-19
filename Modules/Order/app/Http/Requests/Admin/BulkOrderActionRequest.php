<?php

namespace Modules\Order\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BulkOrderActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:orders,id',
            'action' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ];
    }
}
