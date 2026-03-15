<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Modules\Admin\Services\OrderService;
use Modules\Admin\Services\ShippingService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController
{
    public function __construct(
        private OrderService $orderService,
        private ShippingService $shippingService
    ) {}

    public function index(Request $request): View
    {
        $orders = $this->orderService->getOrders(
            $request->only('status', 'payment_status', 'order_number', 'sort', 'order'),
            admin_per_page()
        );

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
        return redirect()->route('admin.orders.index', $request->only('status', 'payment_status', 'order_number', 'per_page', 'sort', 'order'))
            ->with('success', __(':count order(s) updated.', ['count' => $count]));
    }

    /** Export orders as CSV (optionally with order items as separate rows). */
    public function export(Request $request): StreamedResponse
    {
        $orders = $this->orderService->getOrdersForExport($request->only('status', 'payment_status', 'order_number'));
        $withItems = $request->boolean('with_items');

        $filename = 'orders_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($orders, $withItems) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel

            if ($withItems) {
                $orderHeaders = ['Order #', 'Order Date', 'Customer', 'Email', 'Status', 'Payment Status', 'Total (SAR)', 'Shipping (SAR)', 'Shipping Address', 'Billing Address', 'Notes', 'Item Product', 'Item SKU', 'Item Qty', 'Item Price (SAR)', 'Item Subtotal (SAR)'];
                fputcsv($out, $orderHeaders);
                foreach ($orders as $order) {
                    $order->load(['user', 'items.product']);
                    $customerName = $order->user?->name ?? '';
                    $customerEmail = $order->user?->email ?? '';
                    $base = [$order->order_number, $order->created_at?->format('Y-m-d H:i'), $customerName, $customerEmail, $order->status, $order->payment_status, $order->total, $order->shipping_amount ?? 0, $order->shipping_address ?? '', $order->billing_address ?? '', $order->notes ?? ''];
                    if ($order->items->isEmpty()) {
                        fputcsv($out, array_merge($base, ['', '', '', '', '']));
                    } else {
                        foreach ($order->items as $item) {
                            $productName = $item->product?->name ?? '';
                            $sku = $item->product?->sku ?? '';
                            $subtotal = $item->quantity * $item->price;
                            fputcsv($out, array_merge($base, [$productName, $sku, $item->quantity, $item->price, $subtotal]));
                        }
                    }
                }
            } else {
                fputcsv($out, ['Order #', 'Date', 'Customer', 'Email', 'Status', 'Payment Status', 'Total (SAR)', 'Shipping (SAR)', 'Shipping Address', 'Billing Address', 'Notes']);
                foreach ($orders as $order) {
                    $order->load('user');
                    fputcsv($out, [
                        $order->order_number,
                        $order->created_at?->format('Y-m-d H:i'),
                        $order->user?->name ?? '',
                        $order->user?->email ?? '',
                        $order->status,
                        $order->payment_status,
                        $order->total,
                        $order->shipping_amount ?? 0,
                        $order->shipping_address ?? '',
                        $order->billing_address ?? '',
                        $order->notes ?? '',
                    ]);
                }
            }
            fclose($out);
        }, 200, $headers);
    }
}
