<?php

namespace Modules\Admin\Services;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DashboardService
{
    public function getCounts(): array
    {
        return [
            'orders' => Order::count(),
            'pending_payments' => Payment::whereIn('status', ['pending', 'pending_approval'])->count(),
            'unread_contacts' => ContactMessage::whereNull('read_at')->count(),
        ];
    }

    public function getRecentOrders(int $limit = 10): Collection
    {
        return Order::with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /** Total revenue (sum of order totals). */
    public function getTotalRevenue(): float
    {
        return (float) Order::whereIn('status', ['processing', 'shipped', 'delivered'])->sum('total');
    }

    /** Revenue for the current month. */
    public function getRevenueThisMonth(): float
    {
        $start = Carbon::now()->startOfMonth();
        return (float) Order::whereIn('status', ['processing', 'shipped', 'delivered'])
            ->where('created_at', '>=', $start)
            ->sum('total');
    }

    /** Number of orders in the last 7 days. */
    public function getOrdersThisWeek(): int
    {
        return Order::where('created_at', '>=', Carbon::now()->subDays(7))->count();
    }

    /** Orders per day for the last 7 days (for chart). */
    public function getOrdersLast7Days(): array
    {
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $days[$date] = Order::whereDate('created_at', $date)->count();
        }
        return $days;
    }

    /** Products with stock below 5 (or zero). */
    public function getLowStockProducts(int $threshold = 5): Collection
    {
        return Product::where('stock', '<=', $threshold)
            ->where('active', true)
            ->orderBy('stock')
            ->limit(10)
            ->get();
    }

    /** Top products by quantity sold (from order_items). */
    public function getTopProducts(int $limit = 5): Collection
    {
        return OrderItem::query()
            ->selectRaw('product_id, sum(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit($limit)
            ->get()
            ->load('product')
            ->filter(fn ($item) => $item->product !== null);
    }
}
