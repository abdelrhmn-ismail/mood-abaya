@php
    $enabled = \App\Models\Setting::get('announcement_bar_enabled', '0') === '1';
    $text = trim((string) \App\Models\Setting::get('announcement_bar_text', ''));
    $link = trim((string) \App\Models\Setting::get('announcement_bar_link', ''));
@endphp
@if($enabled && $text !== '' && !session('announcement_bar_dismissed'))
<div id="announcement-bar" class="relative border-b border-brand-teal/20 bg-brand-gold/15 py-2.5 text-center text-sm font-medium text-brand-teal-dark">
    <div class="container mx-auto px-4 pr-10">
        @if($link)
            <a href="{{ $link }}" class="hover:underline">{{ $text }}</a>
        @else
            <span>{{ $text }}</span>
        @endif
    </div>
    <form action="{{ route('announcement.dismiss') }}" method="POST" class="absolute end-2 top-1/2 -translate-y-1/2">
        @csrf
        <button type="submit" class="rounded p-1 text-brand-teal-dark/70 transition hover:bg-brand-gold/20 hover:text-brand-teal-dark" aria-label="{{ __('Close') }}">
            <span class="material-icons text-lg">close</span>
        </button>
    </form>
</div>
@endif
