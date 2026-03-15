@extends('admin::layouts.app')

@section('title', __('Add FAQ'))
@section('heading', __('Add FAQ'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-6">
    @csrf
    @include('admin::faqs.form', ['faq' => null])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Add FAQ'),
        'cancelUrl' => route('admin.faqs.index'),
    ])
</form>
@endcomponent
@endsection
