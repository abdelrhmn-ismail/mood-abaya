<?php

namespace Modules\Admin\Services;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderExportService
{
    public function exportCsv(Collection $orders, bool $withItems = false): StreamedResponse
    {
        $filename = 'orders_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($orders, $withItems) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            if ($withItems) {
                $this->writeWithItems($out, $orders);
            } else {
                $this->writeOrdersOnly($out, $orders);
            }

            fclose($out);
        }, 200, $headers);
    }

    private function writeWithItems($out, Collection $orders): void
    {
        fputcsv($out, [
            'Order #', 'Order Date', 'Customer', 'Email', 'Status', 'Payment Status',
            'Total (SAR)', 'Shipping (SAR)', 'Shipping Address', 'Billing Address', 'Notes',
            'Item Product', 'Item SKU', 'Item Qty', 'Item Price (SAR)', 'Item Subtotal (SAR)',
        ]);

        foreach ($orders as $order) {
            $order->load(['user', 'items.product']);
            $base = [
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
            ];

            if ($order->items->isEmpty()) {
                fputcsv($out, array_merge($base, ['', '', '', '', '']));
            } else {
                foreach ($order->items as $item) {
                    fputcsv($out, array_merge($base, [
                        $item->product?->name ?? '',
                        $item->product?->sku ?? '',
                        $item->quantity,
                        $item->price,
                        $item->quantity * $item->price,
                    ]));
                }
            }
        }
    }

    private function writeOrdersOnly($out, Collection $orders): void
    {
        fputcsv($out, [
            'Order #', 'Date', 'Customer', 'Email', 'Status', 'Payment Status',
            'Total (SAR)', 'Shipping (SAR)', 'Shipping Address', 'Billing Address', 'Notes',
        ]);

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
}
