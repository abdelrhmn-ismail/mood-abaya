@extends('admin::layouts.app')

@section('title', __('Products'))
@section('heading', __('Products'))

@section('content')
@component('admin::components.page-header', [
    'actionUrl' => route('admin.products.create'),
    'actionLabel' => __('Add product'),
])
@endcomponent

@component('admin::components.filter-bar')
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    <select name="category_id" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">{{ __('All categories') }}</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
@endcomponent

@include('admin::components.table', [
    'columns' => [
        ['label' => __('Name'), 'key' => 'name'],
        ['label' => __('Category'), 'key' => 'category.name'],
        ['label' => __('Price'), 'key' => 'price', 'format' => 'price'],
        ['label' => __('Stock'), 'key' => 'stock'],
        ['label' => __('Active'), 'key' => 'active', 'format' => 'boolean'],
    ],
    'rows' => $products,
    'emptyMessage' => __('No products yet.'),
    'actions' => [
        'edit_route' => 'admin.products.edit',
        'delete_route' => 'admin.products.destroy',
        'delete_confirm' => __('Delete this product?'),
    ],
    'pagination' => $products,
])
@endsection
