@extends('admin.layouts.app')

@section('title', __('Add testimonial'))
@section('heading', __('Add testimonial'))

@section('content')
@component('components.admin.card', ['title' => null])
<form action="{{ route('testimonial::admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @include('testimonial::admin.form', ['testimonial' => null])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Add testimonial'),
        'cancelUrl' => route('testimonial::admin.index'),
    ])
</form>
@endcomponent
@endsection
