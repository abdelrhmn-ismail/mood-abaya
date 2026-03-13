@extends('admin::layouts.app')

@section('title', __('Order') . ' ' . $order->order_number)
@section('heading', __('Order') . ' ' . $order->order_number)

@section('content')
<div class="space-y-6">
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold">{{ __('Customer') }}</h2>
        <p><strong>{{ $order->user?->name ?? '-' }}</strong></p>
        <p class="text-sm text-gray-600">{{ $order->user?->email ?? '-' }}</p>
        <p class="text-sm text-gray-600">{{ $order->user?->phone ?? '-' }}</p>
        @if($order->shipping_address)
            <pre class="mt-2 whitespace-pre-wrap rounded bg-gray-50 p-2 text-sm">{{ is_string($order->shipping_address) ? $order->shipping_address : json_encode($order->shipping_address, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        @endif
    </div>

    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold">{{ __('Items') }}</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">{{ __('Product') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">{{ __('Qty') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">{{ __('Price') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-4 py-2 text-sm">{{ $item->product?->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-sm">{{ number_format($item->price, 2) }} SAR</td>
                        <td class="px-4 py-2 text-sm">{{ number_format($item->quantity * $item->price, 2) }} SAR</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="mt-2 font-semibold">{{ __('Total') }}: {{ number_format($order->total, 2) }} SAR</p>
    </div>

    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold">{{ __('Order status') }}</h2>
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <select name="status" class="rounded-md border-gray-300 text-sm">
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" class="ml-2 rounded-md bg-indigo-600 px-3 py-1 text-sm text-white hover:bg-indigo-700">{{ __('Update status') }}</button>
        </form>
    </div>

    @if($payment)
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold">{{ __('Payment') }}</h2>
            <p>{{ __('Method') }}: {{ $payment->method }}, {{ __('Status') }}: {{ $payment->status }}</p>
            @if($payment->method === 'cash' && $payment->status !== 'paid')
                <form action="{{ route('admin.payments.markPaid', $payment) }}" method="POST" class="mt-2 inline">
                    @csrf
                    <button type="submit" class="rounded-md bg-green-600 px-3 py-1 text-sm text-white hover:bg-green-700">{{ __('Mark as paid') }}</button>
                </form>
            @endif
            @if($payment->method === 'bank' && $payment->status === 'pending_approval')
                @if($payment->proof_path)
                    <p class="mt-2"><a href="{{ \Illuminate\Support\Facades\Storage::url($payment->proof_path) }}" target="_blank" class="text-indigo-600">{{ __('View proof') }}</a></p>
                @endif
                <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="mt-2 inline">
                    @csrf
                    <button type="submit" class="rounded-md bg-green-600 px-3 py-1 text-sm text-white hover:bg-green-700">{{ __('Approve') }}</button>
                </form>
                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="ml-2 inline">
                    @csrf
                    <button type="submit" class="rounded-md bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">{{ __('Reject') }}</button>
                </form>
            @endif
        </div>
    @endif

    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold">{{ __('Shipping') }}</h2>
        @if($order->shippings->isNotEmpty())
            @php $s = $order->shippings->first(); @endphp
            <p>{{ __('Carrier') }}: {{ $s->carrier }}, {{ __('Tracking') }}: {{ $s->tracking_number }}</p>
            <p class="text-sm text-gray-500">{{ __('Shipped at') }}: {{ $s->shipped_at?->format('Y-m-d H:i') }}</p>
        @endif
        <form action="{{ route('admin.orders.ship', $order) }}" method="POST" class="mt-4 flex flex-wrap gap-2">
            @csrf
            <input type="text" name="carrier" placeholder="{{ __('Carrier') }}" class="rounded-md border-gray-300 text-sm" required>
            <input type="text" name="tracking_number" placeholder="{{ __('Tracking number') }}" class="rounded-md border-gray-300 text-sm" required>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-1 text-sm text-white hover:bg-indigo-700">{{ __('Mark as shipped') }}</button>
        </form>
    </div>
</div>
<p class="mt-4"><a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Back to orders') }}</a></p>
@endsection
