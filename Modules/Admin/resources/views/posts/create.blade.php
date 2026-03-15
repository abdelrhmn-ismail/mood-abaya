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
@php $tinymceKey = \App\Models\Setting::get('tinymce_api_key') ?: 'no-api-key'; @endphp
<script src="https://cdn.tiny.cloud/1/{{ $tinymceKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined' && document.querySelectorAll('.rich-editor').length) {
        tinymce.init({
            selector: '.rich-editor',
            height: 280,
            menubar: false,
            plugins: 'lists link code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link | removeformat | code',
            content_style: 'body { font-family: inherit; font-size: 14px; }',
            directionality: document.documentElement.dir || 'ltr',
        });
    }
    document.querySelectorAll('.locale-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var locale = this.getAttribute('data-locale');
            document.querySelectorAll('.locale-tab').forEach(function(b) { b.classList.remove('bg-gray-200', 'text-gray-900'); b.classList.add('text-gray-600'); });
            this.classList.add('bg-gray-200', 'text-gray-900'); this.classList.remove('text-gray-600');
            document.querySelectorAll('.locale-panel').forEach(function(p) {
                p.classList.toggle('hidden', p.getAttribute('data-locale') !== locale);
            });
        });
    });
});
</script>
@endpush
@endsection
