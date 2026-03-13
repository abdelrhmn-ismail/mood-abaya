<?php

namespace Modules\Admin\Services;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Payment;
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
}
