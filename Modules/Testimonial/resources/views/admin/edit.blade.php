@extends('admin.layouts.app')

@section('title', __('Edit testimonial'))
@section('heading', __('Edit testimonial'))

@section('content')
@component('components.admin.card', ['title' => null])
<form action="{{ route('testimonial::admin.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    @include('testimonial::admin.form', ['testimonial' => $testimonial])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Update testimonial'),
        'cancelUrl' => route('testimonial::admin.index'),
    ])
</form>
@endcomponent
@endsection
