<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\View\View;
use Modules\Admin\Services\DashboardService;

class DashboardController
{
    public function __invoke(DashboardService $dashboardService): View
    {
        $counts = $dashboardService->getCounts();
        $recentOrders = $dashboardService->getRecentOrders();
        $totalRevenue = $dashboardService->getTotalRevenue();
        $revenueThisMonth = $dashboardService->getRevenueThisMonth();
        $ordersThisWeek = $dashboardService->getOrdersThisWeek();
        $ordersLast7Days = $dashboardService->getOrdersLast7Days();
        $lowStockProducts = $dashboardService->getLowStockProducts();
        $topProducts = $dashboardService->getTopProducts();

        return view('admin::dashboard', [
            'counts' => $counts,
            'recentOrders' => $recentOrders,
            'totalRevenue' => $totalRevenue,
            'revenueThisMonth' => $revenueThisMonth,
            'ordersThisWeek' => $ordersThisWeek,
            'ordersLast7Days' => $ordersLast7Days,
            'lowStockProducts' => $lowStockProducts,
            'topProducts' => $topProducts,
        ]);
    }
}
