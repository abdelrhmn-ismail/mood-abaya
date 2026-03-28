@extends('admin.layouts.app')

@section('title', __('Add post'))
@section('heading', __('Add post'))

@section('content')
@component('components.admin.card', ['title' => null])
<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @include('blog::admin.form', ['post' => null])
    @include('components.admin.form-actions', [
        'submitLabel' => __('Create post'),
        'cancelUrl' => route('admin.posts.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@include('components.admin.editor-scripts')
@endpush
@endsection
