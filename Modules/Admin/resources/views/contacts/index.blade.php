@extends('admin::layouts.app')

@section('title', __('Contact messages'))
@section('heading', __('Contact messages'))

@section('content')
@include('admin::components.table', [
    'columns' => [
        ['label' => __('Name'), 'key' => 'name'],
        ['label' => __('Email'), 'key' => 'email'],
        ['label' => __('Subject'), 'key' => 'subject', 'limit' => 40],
        ['label' => __('Read'), 'key' => 'read_at', 'format' => 'boolean'],
        ['label' => __('Date'), 'key' => 'created_at', 'format' => 'datetime'],
    ],
    'rows' => $messages,
    'emptyMessage' => __('No messages yet.'),
    'actions' => [
        'view_route' => 'admin.contacts.show',
    ],
    'pagination' => $messages,
    'rowHighlightKey' => 'read_at',
    'rowHighlightClass' => 'bg-blue-50/50',
])
@endsection
