@php
    $title = $title ?? null;
    $class = $class ?? '';
@endphp
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm {{ $class }}">
    @if($title)
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
