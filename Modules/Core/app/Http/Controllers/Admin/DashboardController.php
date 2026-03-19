<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\View\View;
use Modules\Core\Services\Admin\DashboardService;

class DashboardController
{
    public function __invoke(DashboardService $dashboardService): View
    {
        $counts = $dashboardService->getCounts();
        $recentOrders = $dashboardService->getRecentOrders();
        $totalRevenue = $dashboardService->getTotalRevenue();
        $revenueThisMonth = $dashboardService->getRevenueThisMonth();
        $ordersToday = $dashboardService->getOrdersToday();
        $ordersThisWeek = $dashboardService->getOrdersThisWeek();
        $ordersLast7Days = $dashboardService->getOrdersLast7Days();
        $lowStockProducts = $dashboardService->getLowStockProducts();
        $topProducts = $dashboardService->getTopProducts();

        return view('core::admin.dashboard', [
            'counts' => $counts,
            'recentOrders' => $recentOrders,
            'totalRevenue' => $totalRevenue,
            'revenueThisMonth' => $revenueThisMonth,
            'ordersToday' => $ordersToday,
            'ordersThisWeek' => $ordersThisWeek,
            'ordersLast7Days' => $ordersLast7Days,
            'lowStockProducts' => $lowStockProducts,
            'topProducts' => $topProducts,
        ]);
    }
}
