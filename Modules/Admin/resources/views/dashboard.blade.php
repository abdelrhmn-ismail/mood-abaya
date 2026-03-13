@extends('admin::layouts.app')

@section('title', __('Dashboard'))
@section('heading', __('Dashboard'))

@section('content')
<div class="grid gap-6 md:grid-cols-3">
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="text-sm font-medium text-gray-500">{{ __('Total orders') }}</h3>
        <p class="mt-2 text-3xl font-semibold">{{ $counts['orders'] }}</p>
    </div>
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="text-sm font-medium text-gray-500">{{ __('Pending payments') }}</h3>
        <p class="mt-2 text-3xl font-semibold">{{ $counts['pending_payments'] }}</p>
    </div>
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="text-sm font-medium text-gray-500">{{ __('Unread contact messages') }}</h3>
        <p class="mt-2 text-3xl font-semibold">{{ $counts['unread_contacts'] }}</p>
    </div>
</div>

<div class="mt-8 rounded-lg bg-white p-6 shadow">
    <h2 class="mb-4 text-lg font-semibold">{{ __('Recent orders') }}</h2>
    @if($recentOrders->isEmpty())
        <p class="text-gray-500">{{ __('No orders yet.') }}</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Order #') }}</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Customer') }}</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Total') }}</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Status') }}</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Date') }}</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-2 font-mono text-sm">{{ $order->order_number }}</td>
                            <td class="px-4 py-2 text-sm">{{ $order->user?->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ number_format($order->total, 2) }} SAR</td>
                            <td class="px-4 py-2 text-sm">{{ $order->status }}</td>
                            <td class="px-4 py-2 text-sm">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
