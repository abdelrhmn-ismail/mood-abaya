@extends('admin::layouts.app')

@section('title', __('Categories'))
@section('heading', __('Categories'))

@section('content')
@component('admin::components.page-header', [
    'actionUrl' => route('admin.categories.create'),
    'actionLabel' => __('Add category'),
])
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
])
@endsection
