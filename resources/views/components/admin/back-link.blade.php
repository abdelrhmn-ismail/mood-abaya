@php
    $url = $url ?? url()->previous();
    $text = $text ?? __('Back');
@endphp
<p class="mt-6">
    <a href="{{ $url }}" class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-900">
        <span class="material-icons text-lg">arrow_back</span>
        {{ $text }}
    </a>
</p>
