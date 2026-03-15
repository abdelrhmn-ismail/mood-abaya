<?php

namespace Modules\Admin\Services;

use App\Models\ContactMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactMessageService
{
    public function getMessages(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = ContactMessage::latest();
        if (isset($filters['read']) && $filters['read'] !== '') {
            if ($filters['read']) {
                $query->whereNotNull('read_at');
            } else {
                $query->whereNull('read_at');
            }
        }
        if (!empty($filters['search'])) {
            $term = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('subject', 'like', $term);
            });
        }
        return $query->paginate($perPage);
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

    public function bulkMarkAsRead(array $ids): int
    {
        return ContactMessage::whereIn('id', $ids)->whereNull('read_at')->update(['read_at' => now()]);
    }

    public function bulkDelete(array $ids): int
    {
        return ContactMessage::whereIn('id', $ids)->delete();
    }
}
