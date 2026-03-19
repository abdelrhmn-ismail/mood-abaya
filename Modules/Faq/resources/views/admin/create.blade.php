@extends('admin.layouts.app')

@section('title', __('Add FAQ'))
@section('heading', __('Add FAQ'))

@section('content')
@component('components.admin.card', ['title' => null])
<form action="{{ route('faq::admin.store') }}" method="POST" class="space-y-6">
    @csrf
    @include('faq::admin.form', ['faq' => null])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Add FAQ'),
        'cancelUrl' => route('faq::admin.index'),
    ])
</form>
@endcomponent
@endsection
