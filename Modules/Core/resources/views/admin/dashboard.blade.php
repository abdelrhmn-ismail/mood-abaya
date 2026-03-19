@extends('admin.layouts.app')

@section('title', __('Dashboard'))
@section('heading', __('Dashboard'))

@section('content')
<div class="space-y-8">
    {{-- Overview --}}
    <p class="text-gray-600">{{ __('Last 7 days') }} · {{ __('This month') }}</p>

    {{-- Main KPI cards: orders today, orders this week, low stock, pending bank payments, unread messages --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        @include('components.admin.stat-card', [
            'label' => __('Orders today'),
            'value' => number_format($ordersToday),
            'url' => route('admin.orders.index'),
        ])
        @include('components.admin.stat-card', [
            'label' => __('Orders this week'),
            'value' => number_format($ordersThisWeek),
            'url' => route('admin.orders.index'),
        ])
        @include('components.admin.stat-card', [
            'label' => __('Pending bank payments'),
            'value' => number_format($counts['pending_payments']),
            'url' => route('admin.payments.index'),
        ])
        @include('components.admin.stat-card', [
            'label' => __('Unread contact messages'),
            'value' => number_format($counts['unread_contacts']),
            'url' => route('admin.contacts.index'),
        ])
        @include('components.admin.stat-card', [
            'label' => __('Low stock products'),
            'value' => number_format($lowStockProducts->count()),
            'url' => route('admin.products.index'),
        ])
    </div>

    {{-- Revenue row --}}
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50/80 px-6 py-4">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500">{{ __('Total revenue') }}</h2>
            </div>
            <div class="p-6">
                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalRevenue, 2) }} {{ __('SAR') }}</p>
            </div>
        </div>
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50/80 px-6 py-4">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500">{{ __('Revenue') }} ({{ __('This month') }})</h2>
            </div>
            <div class="p-6">
                <p class="text-3xl font-bold text-indigo-600">{{ number_format($revenueThisMonth, 2) }} {{ __('SAR') }}</p>
            </div>
        </div>
    </div>

    {{-- Charts + Alerts + Top products --}}
    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Orders last 7 days (simple bars) --}}
        @component('components.admin.card', ['title' => __('Orders this week') . ' – ' . __('Last 7 days')])
            <div class="flex items-end justify-between gap-1 pt-4">
                @php $maxDays = max(1, max($ordersLast7Days)); @endphp
                @foreach($ordersLast7Days as $date => $count)
                    <div class="flex flex-1 flex-col items-center gap-1">
                        <span class="text-xs font-medium text-gray-500">{{ \Carbon\Carbon::parse($date)->format('D') }}</span>
                        <div class="w-full rounded-t bg-indigo-500" style="height: {{ max(12, (int)(($count / $maxDays) * 120)) }}px;" title="{{ $count }}"></div>
                        <span class="text-sm font-semibold text-gray-900">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        @endcomponent

        {{-- Low stock --}}
        @component('components.admin.card', ['title' => __('Low stock alerts')])
            @if($lowStockProducts->isEmpty())
                <p class="py-4 text-sm text-gray-500">{{ __('No low stock products.') }}</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach($lowStockProducts as $product)
                        <li class="flex items-center justify-between py-3 first:pt-0">
                            <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $product->name }}</a>
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $product->stock === 0 ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800' }}">{{ $product->stock }} {{ __('In stock') }}</span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('admin.products.index') }}" class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">{{ __('View all products') }}</a>
            @endif
        @endcomponent
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Top products --}}
        @component('components.admin.card', ['title' => __('Top products')])
            @if($topProducts->isEmpty())
                <p class="py-4 text-sm text-gray-500">{{ __('No sales data yet.') }}</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach($topProducts as $item)
                        <li class="flex items-center justify-between py-3 first:pt-0">
                            <a href="{{ route('admin.products.edit', $item->product) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $item->product->name }}</a>
                            <span class="text-sm font-semibold text-gray-600">{{ number_format($item->total_qty) }} {{ __('sold') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endcomponent

        {{-- Recent orders --}}
        @component('components.admin.card', ['title' => __('Recent orders')])
            @if($recentOrders->isEmpty())
                <p class="py-4 text-sm text-gray-500">{{ __('No orders yet.') }}</p>
            @else
                @include('components.admin.table', [
                    'columns' => [
                        ['label' => __('Order #'), 'key' => 'order_number', 'class' => 'font-mono'],
                        ['label' => __('Customer'), 'key' => 'user.name'],
                        ['label' => __('Total'), 'key' => 'total', 'format' => 'price'],
                        ['label' => __('Status'), 'key' => 'status', 'translate' => true],
                        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime'],
                    ],
                    'rows' => $recentOrders,
                    'emptyMessage' => __('No orders yet.'),
                    'actions' => ['view_route' => 'admin.orders.show'],
                ])
                <a href="{{ route('admin.orders.index') }}" class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">{{ __('View all orders') }}</a>
            @endif
        @endcomponent
    </div>
</div>
@endsection
