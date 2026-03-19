@php $tinymceKey = \App\Models\Setting::get('tinymce_api_key', ''); @endphp
@if($tinymceKey)
<script src="https://cdn.tiny.cloud/1/{{ $tinymceKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin" defer></script>
@endif
<script defer src="{{ asset('js/admin/tinymce-init.js') }}"></script>
<script defer src="{{ asset('js/admin/locale-tabs.js') }}"></script>
