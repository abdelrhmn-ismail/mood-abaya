@extends('admin::layouts.app')

@section('title', __('Edit post'))
@section('heading', __('Edit post'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    @include('admin::posts.form', ['post' => $post])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Update post'),
        'cancelUrl' => route('admin.posts.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@include('admin::components.editor-scripts')
@endpush
@endsection
