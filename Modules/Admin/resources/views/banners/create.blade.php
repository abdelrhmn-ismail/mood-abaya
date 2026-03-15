@extends('admin::layouts.app')

@section('title', __('Add banner'))
@section('heading', __('Add banner'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.banners.store') }}" method="POST" class="space-y-6">
    @csrf
    @include('admin::banners.form', ['banner' => null])
    @include('admin::components.form-actions', [
        'submitLabel' => __('Add banner'),
        'cancelUrl' => route('admin.banners.index'),
    ])
</form>
@endcomponent
@endsection
