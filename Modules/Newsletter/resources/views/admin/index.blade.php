@extends('admin.layouts.app')

@section('title', __('Newsletter subscribers'))
@section('heading', __('Newsletter subscribers'))

@section('content')
@component('components.admin.filter-bar')
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by email') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
@endcomponent

@include('components.admin.table', [
    'columns' => [
        ['label' => __('ID'), 'key' => 'id', 'sort_key' => 'id'],
        ['label' => __('Email'), 'key' => 'email', 'sort_key' => 'email'],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime', 'sort_key' => 'created_at'],
    ],
    'rows' => $subscribers,
    'emptyMessage' => __('No subscribers yet.'),
    'bulk_actions' => [
        ['value' => 'delete', 'label' => __('Delete')],
    ],
    'bulk_form_action' => route('admin.newsletter.bulk'),
    'pagination' => $subscribers,
])
@endsection
