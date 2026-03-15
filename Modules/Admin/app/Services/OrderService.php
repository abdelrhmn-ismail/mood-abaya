<?php

namespace Modules\Admin\Services;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function getOrders(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Order::with('user')->latest();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }
        if (!empty($filters['order_number'])) {
            $query->where('order_number', 'like', '%' . $filters['order_number'] . '%');
        }

        return $query->paginate($perPage);
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
