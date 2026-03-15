@extends('admin::layouts.app')

@section('title', __('Edit FAQ'))
@section('heading', __('Edit FAQ'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    @include('admin::faqs.form', ['faq' => $faq])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Save'),
        'cancelUrl' => route('admin.faqs.index'),
    ])
</form>
@endcomponent
@endsection
