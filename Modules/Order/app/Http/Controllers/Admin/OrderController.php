<?php

namespace Modules\Order\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Order\Http\Requests\Admin\BulkOrderActionRequest;
use Modules\Order\Http\Requests\Admin\ShipOrderRequest;
use Modules\Order\Http\Requests\Admin\UpdateOrderStatusRequest;
use Modules\Order\Services\Admin\OrderExportService;
use Modules\Order\Services\Admin\OrderService;
use Modules\Order\Services\Admin\ShippingService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController
{
    public function __construct(
        private OrderService $orderService,
        private ShippingService $shippingService,
        private OrderExportService $exportService,
    ) {}

    public function index(Request $request): View
    {
        $orders = $this->orderService->getOrders(
            $request->only('status', 'payment_status', 'order_number', 'sort', 'order'),
            admin_per_page()
        );

        return view('order::admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product', 'payments', 'shippings']);
        $payment = $order->payments()->first();

        return view('order::admin.orders.show', compact('order', 'payment'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $this->orderService->updateOrderStatus($order, $request->status);

        return redirect()->route('admin.orders.show', $order)->with('success', __('Order status updated.'));
    }

    public function ship(ShipOrderRequest $request, Order $order): RedirectResponse
    {
        $this->shippingService->markShipped($order, $request->carrier, $request->tracking_number);
        $this->orderService->updateOrderStatus($order, 'shipped');

        return redirect()->route('admin.orders.show', $order)->with('success', __('Shipping updated.'));
    }

    public function bulkAction(BulkOrderActionRequest $request): RedirectResponse
    {
        $count = $this->orderService->bulkUpdateStatus($request->input('ids'), $request->input('action'));

        return redirect()->route('admin.orders.index', $request->only('status', 'payment_status', 'order_number', 'per_page', 'sort', 'order'))
            ->with('success', __(':count order(s) updated.', ['count' => $count]));
    }

    public function export(Request $request): StreamedResponse
    {
        $orders = $this->orderService->getOrdersForExport($request->only('status', 'payment_status', 'order_number'));

        return $this->exportService->exportCsv($orders, $request->boolean('with_items'));
    }
}
