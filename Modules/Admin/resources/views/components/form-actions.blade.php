@php
    $submitLabel = $submitLabel ?? __('Save');
    $cancelUrl = $cancelUrl ?? null;
    $cancelLabel = $cancelLabel ?? __('Cancel');
@endphp
<div class="flex flex-wrap items-center gap-3 pt-2">
    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        {{ $submitLabel }}
    </button>
    @if($cancelUrl)
        <a href="{{ $cancelUrl }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            {{ $cancelLabel }}
        </a>
    @endif
    {{ $slot ?? '' }}
</div>
