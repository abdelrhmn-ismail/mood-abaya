{{-- Cookie consent bar: show until user accepts; link to Privacy Policy --}}
@unless(Cookie::has('cookie_consent'))
<div id="cookie-consent-bar" class="fixed bottom-0 left-0 right-0 z-50 border-t border-slate-200 bg-slate-900 px-4 py-3 text-white shadow-lg">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-white/90">
            {{ __('We use cookies to improve your experience and for analytics. By continuing you accept our') }}
            <a href="{{ route('page.show', 'privacy') }}" class="font-medium text-brand-gold underline hover:text-brand-gold/90">{{ __('Privacy Policy') }}</a>.
        </p>
        <button type="button" id="cookie-consent-accept" class="shrink-0 rounded-lg bg-brand-teal px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2 focus:ring-offset-slate-900">
            {{ __('Accept') }}
        </button>
    </div>
</div>
@endif
