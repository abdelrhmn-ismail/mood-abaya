<?php

namespace Modules\Admin\Services;

use App\Models\ContactMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactMessageService
{
    public function getMessages(int $perPage = 15): LengthAwarePaginator
    {
        return ContactMessage::latest()->paginate($perPage);
    }

    public function getMessage(int $id): ?ContactMessage
    {
        return ContactMessage::find($id);
    }

    public function markAsRead(ContactMessage $message): void
    {
        if (!$message->read_at) {
            $message->update(['read_at' => now()]);
        }
    }
}
