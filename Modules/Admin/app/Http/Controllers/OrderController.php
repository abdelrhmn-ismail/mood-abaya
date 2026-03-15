<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Admin\Services\OrderService;
use Modules\Admin\Services\ShippingService;

class OrderController
{
    public function __construct(
        private OrderService $orderService,
        private ShippingService $shippingService
    ) {}

    public function index(Request $request): View
    {
        $orders = $this->orderService->getOrders($request->only('status', 'payment_status', 'order_number'));

        return view('admin::orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product', 'payments', 'shippings']);
        $payment = $order->payments()->first();

        return view('admin::orders.show', compact('order', 'payment'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);

        $this->orderService->updateOrderStatus($order, $request->status);

        return redirect()->route('admin.orders.show', $order)->with('success', __('Order status updated.'));
    }

    public function ship(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'carrier' => 'required|string|max:255',
            'tracking_number' => 'required|string|max:255',
        ]);

        $this->shippingService->markShipped($order, $request->carrier, $request->tracking_number);
        $this->orderService->updateOrderStatus($order, 'shipped');

        return redirect()->route('admin.orders.show', $order)->with('success', __('Shipping updated.'));
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:orders,id',
            'action' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
        $count = $this->orderService->bulkUpdateStatus($request->input('ids'), $request->input('action'));
        return redirect()->route('admin.orders.index', $request->only('status', 'payment_status', 'order_number'))
            ->with('success', __(':count order(s) updated.', ['count' => $count]));
    }
}
