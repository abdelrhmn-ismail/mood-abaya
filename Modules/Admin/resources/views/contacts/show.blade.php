@extends('admin::layouts.app')

@section('title', __('Message from') . ' ' . $contactMessage->name)
@section('heading', __('Contact message'))

@section('content')
<div class="rounded-lg bg-white p-6 shadow">
    <p><strong>{{ __('Name') }}:</strong> {{ $contactMessage->name }}</p>
    <p><strong>{{ __('Email') }}:</strong> {{ $contactMessage->email }}</p>
    <p><strong>{{ __('Subject') }}:</strong> {{ $contactMessage->subject }}</p>
    <p><strong>{{ __('Date') }}:</strong> {{ $contactMessage->created_at->format('Y-m-d H:i') }}</p>
    <div class="mt-4 border-t pt-4">
        <strong>{{ __('Message') }}:</strong>
        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $contactMessage->message }}</p>
    </div>
</div>
<p class="mt-4"><a href="{{ route('admin.contacts.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Back to messages') }}</a></p>
@endsection
