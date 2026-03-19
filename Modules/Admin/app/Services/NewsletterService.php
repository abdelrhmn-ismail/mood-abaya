<?php

namespace Modules\Admin\Services;

use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NewsletterService
{
    public function getAll(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = NewsletterSubscriber::query();

        if (!empty($filters['search'])) {
            $term = '%' . $filters['search'] . '%';
            $query->where('email', 'like', $term);
        }

        $sort = $filters['sort'] ?? 'created_at';
        $order = strtolower($filters['order'] ?? 'desc') === 'asc' ? 'asc' : 'desc';

        if (in_array($sort, ['id', 'email', 'created_at'], true)) {
            $query->orderBy($sort, $order);
        } else {
            $query->latest();
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function bulkDelete(array $ids): int
    {
        return NewsletterSubscriber::whereIn('id', $ids)->delete();
    }
}
