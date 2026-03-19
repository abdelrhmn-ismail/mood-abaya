@extends('admin.layouts.app')

@section('title', __('Edit post'))
@section('heading', __('Edit post'))

@section('content')
@component('components.admin.card', ['title' => null])
<form action="{{ route('blog::admin.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    @include('blog::admin.form', ['post' => $post])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Update post'),
        'cancelUrl' => route('blog::admin.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@include('components.admin.editor-scripts')
@endpush
@endsection
