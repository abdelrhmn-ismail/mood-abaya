@php
    $submitLabel = $submitLabel ?? __('Save');
    $cancelUrl = $cancelUrl ?? null;
    $cancelLabel = $cancelLabel ?? __('Cancel');
    /** @var string|null $submitForm When set, submit button uses the HTML `form` attribute (submit from outside that form). */
    $submitForm = $submitForm ?? null;
@endphp
<div class="flex flex-wrap items-center gap-3 pt-2">
    <button type="submit" @if($submitForm) form="{{ $submitForm }}" @endif class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2">
        {{ $submitLabel }}
    </button>
    @if($cancelUrl)
        <a href="{{ $cancelUrl }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            {{ $cancelLabel }}
        </a>
    @endif
    {{ $slot ?? '' }}
</div>
