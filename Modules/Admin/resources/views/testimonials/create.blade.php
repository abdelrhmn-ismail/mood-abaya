@extends('admin::layouts.app')

@section('title', __('Add testimonial'))
@section('heading', __('Add testimonial'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @include('admin::testimonials.form', ['testimonial' => null])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Add testimonial'),
        'cancelUrl' => route('admin.testimonials.index'),
    ])
</form>
@endcomponent
@endsection
