@extends('admin.layouts.app')

@section('title', __('Add FAQ'))
@section('heading', __('Add FAQ'))

@section('content')
@component('components.admin.card', ['title' => null])
<form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-6">
    @csrf
    @include('faq::admin.form', ['faq' => null])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Add FAQ'),
        'cancelUrl' => route('admin.faqs.index'),
    ])
</form>
@endcomponent
@endsection
