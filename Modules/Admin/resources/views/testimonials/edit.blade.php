@extends('admin::layouts.app')

@section('title', __('Edit testimonial'))
@section('heading', __('Edit testimonial'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    @include('admin::testimonials.form', ['testimonial' => $testimonial])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Update testimonial'),
        'cancelUrl' => route('admin.testimonials.index'),
    ])
</form>
@endcomponent
@endsection
