@extends('admin::layouts.app')

@section('title', __('Add post'))
@section('heading', __('Add post'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @include('admin::posts.form', ['post' => null])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Create post'),
        'cancelUrl' => route('admin.posts.index'),
    ])
</form>
@endcomponent
@push('admin-scripts')
@include('admin::components.editor-scripts')
@endpush
@endsection
