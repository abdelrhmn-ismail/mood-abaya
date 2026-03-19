@extends('admin.layouts.app')

@section('title', __('Edit FAQ'))
@section('heading', __('Edit FAQ'))

@section('content')
@component('components.admin.card', ['title' => null])
<form action="{{ route('faq::admin.update', $faq) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    @include('faq::admin.form', ['faq' => $faq])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Save'),
        'cancelUrl' => route('faq::admin.index'),
    ])
</form>
@endcomponent
@endsection
