@extends('admin.layouts.app')

@section('title', __('Users'))
@section('heading', __('Users'))

@section('content')
@component('components.admin.filter-bar')
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search name, email, phone') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
    <select name="is_admin" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        <option value="">{{ __('All') }}</option>
        <option value="1" {{ request('is_admin') === '1' ? 'selected' : '' }}>{{ __('Admin') }}</option>
        <option value="0" {{ request('is_admin') === '0' ? 'selected' : '' }}>{{ __('Customer') }}</option>
    </select>
@endcomponent

@include('components.admin.table', [
    'columns' => [
        ['label' => __('ID'), 'key' => 'id', 'sort_key' => 'id'],
        ['label' => __('Name'), 'key' => 'name', 'sort_key' => 'name'],
        ['label' => __('Email'), 'key' => 'email', 'sort_key' => 'email'],
        ['label' => __('Phone'), 'key' => 'phone'],
        ['label' => __('Admin'), 'key' => 'is_admin', 'format' => 'boolean', 'sort_key' => 'is_admin'],
        ['label' => __('Orders'), 'key' => 'orders_count'],
        ['label' => __('Registered'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $users,
    'emptyMessage' => __('No users found.'),
    'pagination' => $users,
])
@endsection
