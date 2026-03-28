@extends('admin.layouts.app')

@section('title', __('Settings'))
@section('heading', __('Settings'))

@section('content')
@component('components.admin.card', ['title' => null])
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    {{-- Tabs --}}
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex gap-4" role="tablist">
            <button type="button" class="settings-tab border-b-2 border-brand-teal px-1 py-3 text-sm font-medium text-brand-teal" data-tab="general" role="tab">{{ __('General') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="seo" role="tab">{{ __('SEO') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="contact-social" role="tab">{{ __('Contact & Social') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="shipping" role="tab">{{ __('Shipping') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="custom-code" role="tab">{{ __('Custom code') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="editor" role="tab">{{ __('Editor') }}</button>
        </nav>
    </div>

    {{-- Tab: General --}}
    <div id="tab-general" class="settings-panel space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('General') }}</h2>
        @include('components.admin.form-field', [
            'name' => 'locale',
            'label' => __('Default locale'),
            'type' => 'select',
            'value' => $settings['locale'] ?? 'en',
            'options' => [['value' => 'en', 'label' => __('English')], ['value' => 'ar', 'label' => __('Arabic')]],
        ])
        @include('components.admin.form-field', [
            'name' => 'site_name',
            'label' => __('Site name'),
            'type' => 'text',
            'value' => $settings['site_name'] ?? '',
            'attributes' => ['placeholder' => site_title()],
        ])
        <div class="border-t border-gray-200 pt-6">
            <h3 class="mb-2 text-sm font-medium text-gray-700">{{ __('Titles and labels') }}</h3>
            <p class="mb-3 text-sm text-gray-500">{{ __('Edit navbar and footer text (Home, Categories, Contact, etc.) and other language strings in both English and Arabic.') }}</p>
            <a href="{{ route('admin.translations.index') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal/10 px-4 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-teal/20">
                <span class="material-icons text-lg">translate</span> {{ __('Open Translations') }}
            </a>
        </div>
    </div>

    {{-- Tab: SEO --}}
    <div id="tab-seo" class="settings-panel hidden space-y-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('SEO') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Default meta tags for the site. Used when a page does not set its own.') }}</p>
        @include('components.admin.form-field', [
            'name' => 'meta_title',
            'label' => __('Meta title'),
            'type' => 'text',
            'value' => $settings['meta_title'] ?? '',
            'attributes' => ['placeholder' => site_title()],
        ])
        @include('components.admin.form-field', [
            'name' => 'meta_description',
            'label' => __('Meta description'),
            'type' => 'textarea',
            'value' => $settings['meta_description'] ?? '',
            'attributes' => ['rows' => 3, 'placeholder' => __('Short description for search engines.')],
        ])
        @include('components.admin.form-field', [
            'name' => 'meta_keywords',
            'label' => __('Meta keywords'),
            'type' => 'text',
            'value' => $settings['meta_keywords'] ?? '',
            'attributes' => ['placeholder' => 'keyword1, keyword2'],
        ])
        @include('components.admin.form-field', [
            'name' => 'og_image',
            'label' => __('OG image URL'),
            'type' => 'text',
            'value' => $settings['og_image'] ?? '',
            'attributes' => ['placeholder' => 'https://example.com/image.jpg'],
        ])
    </div>

    {{-- Tab: Contact & Social --}}
    <div id="tab-contact-social" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Contact & Social') }}</h2>
        <p class="text-sm text-gray-500">{{ __('These values appear in the footer, contact page, and as floating social icons. Leave blank to hide.') }}</p>
        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
            <div>
                <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">{{ __('Social links') }}</h3>
                <div class="space-y-3">
                    @include('components.admin.form-field', ['name' => 'whatsapp_url', 'label' => __('WhatsApp URL'), 'type' => 'text', 'value' => $settings['whatsapp_url'] ?? '', 'attributes' => ['placeholder' => 'https://wa.me/966501234567']])
                    @include('components.admin.form-field', ['name' => 'instagram_url', 'label' => __('Instagram URL'), 'type' => 'text', 'value' => $settings['instagram_url'] ?? '', 'attributes' => ['placeholder' => 'https://instagram.com/yourstore']])
                    @include('components.admin.form-field', ['name' => 'facebook_url', 'label' => __('Facebook URL'), 'type' => 'text', 'value' => $settings['facebook_url'] ?? '', 'attributes' => ['placeholder' => 'https://facebook.com/yourpage']])
                    @include('components.admin.form-field', ['name' => 'twitter_url', 'label' => __('Twitter / X URL'), 'type' => 'text', 'value' => $settings['twitter_url'] ?? '', 'attributes' => ['placeholder' => 'https://twitter.com/yourstore']])
                </div>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">{{ __('Contact info') }}</h3>
                <div class="space-y-3">
                    @include('components.admin.form-field', ['name' => 'contact_email', 'label' => __('Email'), 'type' => 'text', 'value' => $settings['contact_email'] ?? '', 'attributes' => ['placeholder' => 'info@example.com']])
                    @include('components.admin.form-field', ['name' => 'contact_email_secondary', 'label' => __('Email (secondary)'), 'type' => 'text', 'value' => $settings['contact_email_secondary'] ?? '', 'attributes' => ['placeholder' => 'support@example.com']])
                    @include('components.admin.form-field', ['name' => 'contact_phone', 'label' => __('Phone'), 'type' => 'text', 'value' => $settings['contact_phone'] ?? '', 'attributes' => ['placeholder' => '+966 50 123 4567']])
                    @include('components.admin.form-field', ['name' => 'contact_phone_secondary', 'label' => __('Phone (secondary)'), 'type' => 'text', 'value' => $settings['contact_phone_secondary'] ?? '', 'attributes' => ['placeholder' => '+966 11 234 5678']])
                    @include('components.admin.form-field', ['name' => 'contact_location', 'label' => __('Address / Location'), 'type' => 'textarea', 'value' => $settings['contact_location'] ?? '', 'attributes' => ['rows' => 3, 'placeholder' => __('Full address or area')]])
                </div>
            </div>
        </div>
    </div>

    {{-- Tab: Shipping --}}
    <div id="tab-shipping" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Shipping') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Configure how shipping cost is calculated at checkout.') }}</p>
        @include('components.admin.form-field', [
            'name' => 'shipping_type',
            'label' => __('Shipping type'),
            'type' => 'select',
            'value' => $settings['shipping_type'] ?? 'flat',
            'options' => [
                ['value' => 'flat', 'label' => __('Flat rate')],
                ['value' => 'free_over', 'label' => __('Free over amount')],
                ['value' => 'zones', 'label' => __('Zones (e.g. Riyadh vs rest of KSA)')],
            ],
        ])
        @include('components.admin.form-field', ['name' => 'shipping_flat_rate', 'label' => __('Flat rate (SAR)'), 'type' => 'number', 'value' => $settings['shipping_flat_rate'] ?? '0', 'attributes' => ['step' => '0.01', 'min' => 0]])
        @include('components.admin.form-field', ['name' => 'shipping_free_over', 'label' => __('Free shipping over (SAR)'), 'type' => 'number', 'value' => $settings['shipping_free_over'] ?? '', 'attributes' => ['step' => '0.01', 'min' => 0, 'placeholder' => __('Leave empty to disable')]])
        <div>
            <label for="shipping_zones" class="block text-sm font-medium text-gray-700">{{ __('Shipping zones (JSON)') }}</label>
            <p class="mt-0.5 text-xs text-gray-500">{{ __('When type is Zones, paste JSON array: [{"id":"riyadh","label":"Riyadh","amount":15},{"id":"other","label":"Rest of KSA","amount":25}]') }}</p>
            <textarea name="shipping_zones" id="shipping_zones" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 font-mono text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">{{ old('shipping_zones', $settings['shipping_zones'] ?? '') }}</textarea>
        </div>
    </div>

    {{-- Tab: Custom code (header/footer) for tracking, pixels, media team --}}
    <div id="tab-custom-code" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Custom code') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Add tracking scripts, pixels, analytics, or any HTML/JS for the media or social team. Code is injected on every frontend page. Only add code from trusted sources.') }}</p>
        <div class="space-y-6">
            <div class="rounded-xl border border-gray-200 bg-amber-50/50 p-4">
                <label for="custom_code_header" class="block text-sm font-medium text-gray-900">{{ __('Header code') }}</label>
                <p class="mt-0.5 text-xs text-gray-600">{{ __('Pasted inside &lt;head&gt;. Use for: Google Tag Manager head snippet, meta tags, Facebook Pixel, TikTok Pixel, etc.') }}</p>
                <textarea name="custom_code_header" id="custom_code_header" rows="8" class="mt-2 block w-full rounded-lg border border-gray-300 font-mono text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal"
                    placeholder="<!-- e.g. Google Tag Manager -->
<script>(function(w,d,s,l,i){...})(window,document,'script','dataLayer','GTM-XXXX');</script>">{{ old('custom_code_header', $settings['custom_code_header'] ?? '') }}</textarea>
            </div>
            <div class="rounded-xl border border-gray-200 bg-amber-50/50 p-4">
                <label for="custom_code_footer" class="block text-sm font-medium text-gray-900">{{ __('Footer code') }}</label>
                <p class="mt-0.5 text-xs text-gray-600">{{ __('Pasted just before &lt;/body&gt;. Use for: GTM noscript, analytics, chat widgets, or any script that should load at page bottom.') }}</p>
                <textarea name="custom_code_footer" id="custom_code_footer" rows="8" class="mt-2 block w-full rounded-lg border border-gray-300 font-mono text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal"
                    placeholder="<!-- e.g. Chat widget or GTM noscript -->
<noscript><iframe src='...'></iframe></noscript>">{{ old('custom_code_footer', $settings['custom_code_footer'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Tab: Editor (TinyMCE) --}}
    <div id="tab-editor" class="settings-panel hidden space-y-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Editor') }}</h2>
        <p class="text-sm text-gray-500">{{ __('TinyMCE API key is required for the rich text editor on product and category descriptions. Get a free key at') }} <a href="https://www.tiny.cloud/auth/signup/" target="_blank" rel="noopener" class="text-brand-teal hover:underline">tiny.cloud</a>.</p>
        @include('components.admin.form-field', [
            'name' => 'tinymce_api_key',
            'label' => __('TinyMCE API key'),
            'type' => 'text',
            'value' => $settings['tinymce_api_key'] ?? '',
            'attributes' => ['placeholder' => 'your-api-key', 'autocomplete' => 'off'],
        ])
    </div>

    @include('components.admin.form-actions', [
        'submitLabel' => __('Save settings'),
        'cancelUrl' => null,
    ])
</form>
@endcomponent

@push('admin-scripts')
<script defer src="{{ asset('js/admin/settings-tabs.js') }}"></script>
@endpush
@endsection
