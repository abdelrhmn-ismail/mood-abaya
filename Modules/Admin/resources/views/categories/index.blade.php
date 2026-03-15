@extends('admin::layouts.app')

@section('title', __('Categories'))
@section('heading', __('Categories'))

@section('content')
@component('admin::components.page-header', [
    'actionUrl' => route('admin.categories.create'),
    'actionLabel' => __('Add category'),
])
@endcomponent

@component('admin::components.filter-bar')
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    <select name="active" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">{{ __('All statuses') }}</option>
        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
    </select>
@endcomponent

@include('admin::components.table', [
    'columns' => [
        ['label' => __('Name'), 'key' => 'name'],
        ['label' => __('Slug'), 'key' => 'slug', 'class' => 'font-mono'],
        ['label' => __('Sort'), 'key' => 'sort_order'],
        ['label' => __('Active'), 'key' => 'active', 'format' => 'boolean'],
    ],
    'rows' => $categories,
    'emptyMessage' => __('No categories yet.'),
    'actions' => [
        'edit_route' => 'admin.categories.edit',
        'delete_route' => 'admin.categories.destroy',
        'delete_confirm' => __('Delete this category?'),
    ],
    'bulk_actions' => [
        ['value' => 'activate', 'label' => __('Activate')],
        ['value' => 'deactivate', 'label' => __('Deactivate')],
        ['value' => 'delete', 'label' => __('Delete')],
    ],
    'bulk_form_action' => route('admin.categories.bulk'),
    'pagination' => $categories,
])
@endsection
