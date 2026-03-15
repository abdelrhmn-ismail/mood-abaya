<?php

namespace Modules\Admin\Services;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    /** @param  array{status?: string, payment_status?: string, order_number?: string, sort?: string, order?: string}  $filters */
    public function getOrders(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = Order::with('user');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }
        if (!empty($filters['order_number'])) {
            $query->where('order_number', 'like', '%' . $filters['order_number'] . '%');
        }

        $sort = $filters['sort'] ?? 'created_at';
        $order = isset($filters['order']) && strtolower($filters['order']) === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['order_number', 'total', 'status', 'created_at', 'payment_status', 'payment_method', 'user_name'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'created_at';
        }
        if ($sort === 'user_name') {
            $query->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->orderBy('users.name', $order)
                ->select('orders.*');
        } else {
            $query->orderBy('orders.' . $sort, $order);
        }

        return $query->paginate($perPage);
    }

    /** Same filters as getOrders but returns all matching orders (for export). */
    public function getOrdersForExport(array $filters = []): Collection
    {
        $query = Order::with('user')->latest();

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (! empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }
        if (! empty($filters['order_number'])) {
            $query->where('order_number', 'like', '%' . $filters['order_number'] . '%');
        }

        return $query->get();
    }

    public function getOrder(int $id): ?Order
    {
        return Order::with(['user', 'items.product', 'payments', 'shippings'])->find($id);
    }

    public function updateOrderStatus(Order $order, string $status): void
    {
        $order->update(['status' => $status]);
    }

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return Order::whereIn('id', $ids)->update(['status' => $status]);
    }
}
