@extends('admin::layouts.app')

@section('title', __('Orders'))
@section('heading', __('Orders'))

@section('content')
@component('admin::components.filter-bar')
    <input type="text" name="order_number" value="{{ request('order_number') }}" placeholder="{{ __('Order #') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
    <select name="status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value="">{{ __('All statuses') }}</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>pending</option>
        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>processing</option>
        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>shipped</option>
        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>delivered</option>
        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>cancelled</option>
    </select>
    <select name="payment_status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value="">{{ __('All payment statuses') }}</option>
        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>pending</option>
        <option value="pending_approval" {{ request('payment_status') === 'pending_approval' ? 'selected' : '' }}>pending_approval</option>
        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>paid</option>
        <option value="rejected" {{ request('payment_status') === 'rejected' ? 'selected' : '' }}>rejected</option>
    </select>
@endcomponent

@include('admin::components.table', [
    'columns' => [
        ['label' => __('Order #'), 'key' => 'order_number', 'class' => 'font-mono'],
        ['label' => __('Customer'), 'key' => 'user.name'],
        ['label' => __('Total'), 'key' => 'total', 'format' => 'price'],
        ['label' => __('Payment'), 'key' => 'payment_method', 'key2' => 'payment_status', 'glue' => ' / '],
        ['label' => __('Status'), 'key' => 'status'],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime'],
    ],
    'rows' => $orders,
    'emptyMessage' => __('No orders found.'),
    'actions' => [
        'view_route' => 'admin.orders.show',
    ],
    'bulk_actions' => [
        ['value' => 'pending', 'label' => __('Set status: Pending')],
        ['value' => 'processing', 'label' => __('Set status: Processing')],
        ['value' => 'shipped', 'label' => __('Set status: Shipped')],
        ['value' => 'delivered', 'label' => __('Set status: Delivered')],
        ['value' => 'cancelled', 'label' => __('Set status: Cancelled')],
    ],
    'bulk_form_action' => route('admin.orders.bulk'),
    'pagination' => $orders,
])
@endsection
