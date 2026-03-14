<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Order\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function confirmed(Request $request, string $orderNumber): View|\Illuminate\Http\RedirectResponse
    {
        $order = $this->orderService->getOrderByNumberForUser($orderNumber, (int) $request->user()->id);
        if (! $order) {
            abort(404);
        }
        return view('frontend.order-confirmed', compact('order'));
    }
}
