<?php

namespace Modules\Contact\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BulkContactMessageActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:contact_messages,id',
            'action' => 'required|in:mark_read,delete',
        ];
    }
}
