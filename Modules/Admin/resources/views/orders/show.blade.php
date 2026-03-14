@extends('admin::layouts.app')

@section('title', __('Order') . ' ' . $order->order_number)
@section('heading', __('Order') . ' ' . $order->order_number)

@section('content')
<div class="space-y-6">
    @component('admin::components.card', ['title' => __('Customer')])
        @include('admin::components.detail-list', [
            'items' => [
                ['label' => __('Name'), 'value' => $order->user?->name ?? '—'],
                ['label' => __('Email'), 'value' => $order->user?->email ?? '—'],
                ['label' => __('Phone'), 'value' => $order->user?->phone ?? '—'],
            ],
        ])
        @if($order->shipping_address)
            <div class="mt-4 border-t border-gray-200 pt-4">
                <dt class="text-sm font-medium text-gray-500">{{ __('Address') }}</dt>
                <dd class="mt-1 whitespace-pre-wrap rounded bg-gray-50 p-2 text-sm">{{ is_string($order->shipping_address) ? $order->shipping_address : json_encode($order->shipping_address, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</dd>
            </div>
        @endif
    @endcomponent

    @component('admin::components.card', ['title' => __('Items')])
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Product') }}</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Qty') }}</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Price') }}</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-2 text-sm">{{ $item->product?->name ?? '—' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-sm">{{ number_format($item->price, 2) }} SAR</td>
                            <td class="px-4 py-2 text-sm">{{ number_format($item->quantity * $item->price, 2) }} SAR</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="mt-3 font-semibold text-gray-900">{{ __('Total') }}: {{ number_format($order->total, 2) }} SAR</p>
    @endcomponent

    @component('admin::components.card', ['title' => __('Order status')])
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-flex flex-wrap items-center gap-2">
            @csrf
            @method('PUT')
            <select name="status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Update status') }}</button>
        </form>
    @endcomponent

    @if($payment)
        @component('admin::components.card', ['title' => __('Payment')])
            @include('admin::components.detail-list', [
                'items' => [
                    ['label' => __('Method'), 'value' => $payment->method],
                    ['label' => __('Status'), 'value' => $payment->status],
                ],
            ])
            @if($payment->method === 'cash' && $payment->status !== 'paid')
                <form action="{{ route('admin.payments.markPaid', $payment) }}" method="POST" class="mt-4 inline">
                    @csrf
                    <button type="submit" class="rounded-lg bg-green-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-green-700">{{ __('Mark as paid') }}</button>
                </form>
            @endif
            @if($payment->method === 'bank' && $payment->status === 'pending_approval')
                @if($payment->proof_path)
                    <p class="mt-2"><a href="{{ \Illuminate\Support\Facades\Storage::url($payment->proof_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ __('View proof') }}</a></p>
                @endif
                <div class="mt-4 flex flex-wrap gap-2">
                    <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-lg bg-green-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-green-700">{{ __('Approve') }}</button>
                    </form>
                    <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-700">{{ __('Reject') }}</button>
                    </form>
                </div>
            @endif
        @endcomponent
    @endif

    @component('admin::components.card', ['title' => __('Shipping')])
        @if($order->shippings->isNotEmpty())
            @php $s = $order->shippings->first(); @endphp
            @include('admin::components.detail-list', [
                'items' => [
                    ['label' => __('Carrier'), 'value' => $s->carrier],
                    ['label' => __('Tracking'), 'value' => $s->tracking_number],
                    ['label' => __('Shipped at'), 'value' => $s->shipped_at?->format('Y-m-d H:i')],
                ],
            ])
        @endif
        <form action="{{ route('admin.orders.ship', $order) }}" method="POST" class="mt-4 flex flex-wrap gap-2">
            @csrf
            <input type="text" name="carrier" placeholder="{{ __('Carrier') }}" class="rounded-lg border-gray-300 text-sm shadow-sm" required>
            <input type="text" name="tracking_number" placeholder="{{ __('Tracking number') }}" class="rounded-lg border-gray-300 text-sm shadow-sm" required>
            <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Mark as shipped') }}</button>
        </form>
    @endcomponent
</div>

@include('admin::components.back-link', ['url' => route('admin.orders.index'), 'text' => __('Back to orders')])
@endsection
