<?php

namespace Modules\Order\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getOrdersForUser(int $userId)
    {
        return Order::with('items.product')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function findOrderForUser(int $orderId, int $userId): ?Order
    {
        return Order::with('items.product', 'payments')
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->first();
    }

    public function getOrderByNumber(string $orderNumber): ?Order
    {
        return Order::with('items.product', 'payments')
            ->where('order_number', $orderNumber)
            ->first();
    }

    public function getOrderByNumberForUser(string $orderNumber, int $userId): ?Order
    {
        return Order::with('items.product', 'payments')
            ->where('order_number', $orderNumber)
            ->where('user_id', $userId)
            ->first();
    }
}
