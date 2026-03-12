<?php

namespace Modules\Contact\Services;

use App\Models\ContactMessage;

class ContactService
{
    public function submitMessage(array $data): ContactMessage
    {
        return ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
        ]);
    }
}
