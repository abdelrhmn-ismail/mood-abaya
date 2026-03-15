<?php

namespace Modules\Admin\Services;

use App\Models\ContactMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactMessageService
{
    /** @param  array{read?: string, search?: string, sort?: string, order?: string}  $filters */
    public function getMessages(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = ContactMessage::query();
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
        $sort = $filters['sort'] ?? 'created_at';
        $order = isset($filters['order']) && strtolower($filters['order']) === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['name', 'email', 'subject', 'created_at', 'read_at'];
        if (in_array($sort, $allowedSort, true)) {
            $query->orderBy($sort, $order);
        } else {
            $query->latest();
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
