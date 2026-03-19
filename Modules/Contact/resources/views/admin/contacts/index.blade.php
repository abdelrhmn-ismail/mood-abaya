@extends('admin.layouts.app')

@section('title', __('Contact messages'))
@section('heading', __('Contact messages'))

@section('content')
@component('components.admin.filter-bar')
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search name, email, subject') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    <select name="read" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">{{ __('All') }}</option>
        <option value="0" {{ request('read') === '0' ? 'selected' : '' }}>{{ __('Unread') }}</option>
        <option value="1" {{ request('read') === '1' ? 'selected' : '' }}>{{ __('Read') }}</option>
    </select>
@endcomponent

@include('components.admin.table', [
    'columns' => [
        ['label' => __('Name'), 'key' => 'name', 'sort_key' => 'name'],
        ['label' => __('Email'), 'key' => 'email', 'sort_key' => 'email'],
        ['label' => __('Subject'), 'key' => 'subject', 'limit' => 40, 'sort_key' => 'subject'],
        ['label' => __('Read'), 'key' => 'read_at', 'format' => 'boolean', 'sort_key' => 'read_at'],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $messages,
    'emptyMessage' => __('No messages yet.'),
    'actions' => [
        'view_route' => 'admin.contacts.show',
    ],
    'bulk_actions' => [
        ['value' => 'mark_read', 'label' => __('Mark as read')],
        ['value' => 'delete', 'label' => __('Delete')],
    ],
    'bulk_form_action' => route('admin.contacts.bulk'),
    'pagination' => $messages,
    'rowHighlightKey' => 'read_at',
    'rowHighlightClass' => 'bg-blue-50/50',
])
@endsection
