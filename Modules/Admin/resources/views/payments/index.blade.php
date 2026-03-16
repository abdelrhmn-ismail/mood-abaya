@extends('admin::layouts.app')

@section('title', __('Payments'))
@section('heading', __('Payments'))

@section('content')
@component('admin::components.filter-bar')
    <select name="status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value="">{{ __('All statuses') }}</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('pending') }}</option>
        <option value="pending_approval" {{ request('status') === 'pending_approval' ? 'selected' : '' }}>{{ __('pending_approval') }}</option>
        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>{{ __('paid') }}</option>
        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ __('rejected') }}</option>
    </select>
    <select name="method" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value="">{{ __('All methods') }}</option>
        <option value="cash" {{ request('method') === 'cash' ? 'selected' : '' }}>cash</option>
        <option value="bank" {{ request('method') === 'bank' ? 'selected' : '' }}>bank</option>
    </select>
@endcomponent

@include('admin::components.table', [
    'columns' => [
        ['label' => __('ID'), 'key' => 'id', 'sort_key' => 'id'],
        ['label' => __('Order'), 'key' => 'order.order_number', 'class' => 'font-mono'],
        ['label' => __('Method'), 'key' => 'method', 'sort_key' => 'method'],
        ['label' => __('Status'), 'key' => 'status', 'sort_key' => 'status'],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $payments,
    'emptyMessage' => __('No payments found.'),
    'actions' => [
        'view_route' => 'admin.payments.show',
    ],
    'bulk_actions' => [
        ['value' => 'approve', 'label' => __('Approve (bank pending)')],
        ['value' => 'reject', 'label' => __('Reject (bank pending)')],
        ['value' => 'mark_paid', 'label' => __('Mark as paid')],
    ],
    'bulk_form_action' => route('admin.payments.bulk'),
    'pagination' => $payments,
])
@endsection
