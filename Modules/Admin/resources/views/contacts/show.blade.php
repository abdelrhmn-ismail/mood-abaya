@extends('admin::layouts.app')

@section('title', __('Message from') . ' ' . $contactMessage->name)
@section('heading', __('Contact message'))

@section('content')
@component('admin::components.card', ['title' => null])
    @include('admin::components.detail-list', [
        'items' => [
            ['label' => __('Name'), 'value' => $contactMessage->name],
            ['label' => __('Email'), 'value' => $contactMessage->email],
            ['label' => __('Subject'), 'value' => $contactMessage->subject],
            ['label' => __('Date'), 'value' => $contactMessage->created_at->format('Y-m-d H:i')],
        ],
    ])
    <div class="mt-4 border-t border-gray-200 pt-4">
        <dt class="text-sm font-medium text-gray-500">{{ __('Message') }}</dt>
        <dd class="mt-2 whitespace-pre-wrap text-sm text-gray-900">{{ $contactMessage->message }}</dd>
    </div>
@endcomponent

@include('admin::components.back-link', [
    'url' => route('admin.contacts.index'),
    'text' => __('Back to messages'),
])
@endsection
