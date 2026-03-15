@extends('admin::layouts.app')

@section('title', __('Edit banner'))
@section('heading', __('Edit banner'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.banners.update', $banner) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    @include('admin::banners.form', ['banner' => $banner])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Update banner'),
        'cancelUrl' => route('admin.banners.index'),
    ])
</form>
@endcomponent
@endsection
