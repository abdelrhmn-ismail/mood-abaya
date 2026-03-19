<?php

namespace Modules\Admin\Services;

use App\Models\ProductReview;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewService
{
    public function getAll(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = ProductReview::with(['product', 'user', 'order']);

        if (isset($filters['rating']) && $filters['rating'] !== '') {
            $query->where('rating', (int) $filters['rating']);
        }
        if (isset($filters['visible']) && $filters['visible'] !== '') {
            $query->where('is_visible', (bool) $filters['visible']);
        }
        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }
        if (!empty($filters['search'])) {
            $term = '%' . $filters['search'] . '%';
            $query->where('comment', 'like', $term);
        }

        $sort = $filters['sort'] ?? 'created_at';
        $order = strtolower($filters['order'] ?? 'desc') === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['id', 'rating', 'is_visible', 'created_at'];

        if (in_array($sort, $allowedSort, true)) {
            $query->orderBy($sort, $order);
        } else {
            $query->orderByDesc('created_at');
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function toggleVisibility(ProductReview $review): ProductReview
    {
        $review->update(['is_visible' => !$review->is_visible]);

        return $review;
    }

    public function bulkAction(array $ids, string $action): int
    {
        return match ($action) {
            'show' => ProductReview::whereIn('id', $ids)->update(['is_visible' => true]),
            'hide' => ProductReview::whereIn('id', $ids)->update(['is_visible' => false]),
            'delete' => ProductReview::whereIn('id', $ids)->delete(),
            default => 0,
        };
    }
}
