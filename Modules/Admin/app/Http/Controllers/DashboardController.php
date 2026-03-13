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

        return view('admin::dashboard', [
            'counts' => $counts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
