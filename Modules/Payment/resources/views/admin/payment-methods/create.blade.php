@extends('admin.layouts.app')

@section('title', __('Add payment method'))
@section('heading', __('Add payment method'))

@section('content')
@component('components.admin.card', ['title' => null])
    <p class="mb-4 text-sm text-gray-600">{{ __('Use a lowercase code without spaces (e.g. stripe, wallet). Wire it in code when you add a real integration.') }}</p>
    <form action="{{ route('admin.payment-methods.store') }}" method="POST" class="space-y-6">
        @csrf
        @include('components.admin.form-field', [
            'name' => 'code',
            'label' => __('Method code'),
            'type' => 'text',
            'value' => old('code'),
            'required' => true,
            'attributes' => ['placeholder' => 'e.g. wallet', 'pattern' => '[a-z][a-z0-9_]*'],
        ])
        @include('payment::admin.payment-methods.form', ['paymentMethod' => null])
        @include('components.admin.form-actions', [
            'submitLabel' => __('Create'),
            'cancelUrl' => route('admin.payment-methods.index'),
        ])
    </form>
@endcomponent
@endsection
