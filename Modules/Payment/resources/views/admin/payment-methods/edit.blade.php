@extends('admin.layouts.app')

@section('title', __('Edit payment method'))
@section('heading', __('Edit payment method'))

@section('content')
@component('components.admin.card', ['title' => $paymentMethod->code])
    <p class="mb-4 text-sm text-gray-500">{{ __('Internal code') }}: <code class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-sm">{{ $paymentMethod->code }}</code>
        @if($paymentMethod->is_system)
            <span class="ml-2 text-amber-700">({{ __('System method — code cannot be changed') }})</span>
        @endif
    </p>
    <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        @include('payment::admin.payment-methods.form', ['paymentMethod' => $paymentMethod])
        @include('components.admin.form-actions', [
            'submitLabel' => __('Save'),
            'cancelUrl' => route('admin.payment-methods.index'),
        ])
    </form>
@endcomponent
@endsection
