<?php

namespace Modules\Newsletter\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BulkNewsletterActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:newsletter_subscribers,id',
            'action' => 'required|in:delete',
        ];
    }
}
