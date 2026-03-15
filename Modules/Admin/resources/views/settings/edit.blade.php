@extends('admin::layouts.app')

@section('title', __('Settings'))
@section('heading', __('Settings'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    {{-- Tabs --}}
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex gap-4" role="tablist">
            <button type="button" class="settings-tab border-b-2 border-brand-teal px-1 py-3 text-sm font-medium text-brand-teal" data-tab="general" role="tab">{{ __('General') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="seo" role="tab">{{ __('SEO') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="labels" role="tab">{{ __('Site labels') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="frontend" role="tab">{{ __('Frontend') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="contact-social" role="tab">{{ __('Contact & Social') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="announcement" role="tab">{{ __('Announcement bar') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="shipping" role="tab">{{ __('Shipping') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="maintenance" role="tab">{{ __('Maintenance') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="trust-badges" role="tab">{{ __('Trust badges') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="custom-code" role="tab">{{ __('Custom code') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="editor" role="tab">{{ __('Editor') }}</button>
        </nav>
    </div>

    {{-- Tab: General --}}
    @php
        $brandingDisplayUrl = function ($val) {
            if (empty($val)) return null;
            return str_starts_with($val, 'http') ? $val : \Illuminate\Support\Facades\Storage::url($val);
        };
    @endphp
    <div id="tab-general" class="settings-panel space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('General') }}</h2>
        @include('admin::components.form-field', [
            'name' => 'locale',
            'label' => __('Default locale'),
            'type' => 'select',
            'value' => $settings['locale'] ?? 'en',
            'options' => [['value' => 'en', 'label' => __('English')], ['value' => 'ar', 'label' => __('Arabic')]],
        ])
        <div class="border-t border-gray-200 pt-6">
            <h3 class="mb-3 text-sm font-medium text-gray-700">{{ __('Branding') }}</h3>
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                    <label class="block text-sm font-medium text-gray-700">{{ __('Site logo') }}</label>
                    <p class="mt-0.5 text-xs text-gray-500">{{ __('Shown in navbar and footer (logo only, no text).') }} {{ __('Recommended dimensions') }}: 180×50</p>
                    @php $logoVal = $settings['site_logo'] ?? ''; $logoUrl = $brandingDisplayUrl($logoVal); @endphp
                    @if($logoUrl)
                        <div class="mt-2 flex items-center gap-2 overflow-hidden rounded-lg border border-gray-200 bg-white p-2">
                            <img src="{{ $logoUrl }}" alt="" class="max-h-12 max-w-[180px] object-contain" loading="lazy">
                        </div>
                    @endif
                    <div class="mt-2">
                        <input type="file" name="logo_file" accept="image/*,.svg" class="block w-full text-sm text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-brand-gold/20 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand-teal hover:file:bg-brand-gold/30">
                    </div>
                    <input type="text" name="site_logo" value="{{ old('site_logo', $logoVal) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                    <label class="block text-sm font-medium text-gray-700">{{ __('Favicon') }}</label>
                    <p class="mt-0.5 text-xs text-gray-500">{{ __('Browser tab icon.') }} {{ __('Recommended') }}: 32×32 .ico or .png</p>
                    @php $favVal = $settings['favicon'] ?? ''; $favUrl = $brandingDisplayUrl($favVal); @endphp
                    @if($favUrl)
                        <div class="mt-2 flex items-center gap-2">
                            <img src="{{ $favUrl }}" alt="" class="h-8 w-8 object-contain" loading="lazy">
                        </div>
                    @endif
                    <div class="mt-2">
                        <input type="file" name="favicon_file" accept=".ico,image/png,image/x-icon" class="block w-full text-sm text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-brand-gold/20 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand-teal hover:file:bg-brand-gold/30">
                    </div>
                    <input type="text" name="favicon" value="{{ old('favicon', $favVal) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
            <div class="mt-4">
                <label for="footer_tagline" class="block text-sm font-medium text-gray-700">{{ __('Footer tagline') }}</label>
                <p class="mt-0.5 text-xs text-gray-500">{{ __('Short text under the logo in the footer.') }}</p>
                <input type="text" name="footer_tagline" id="footer_tagline" value="{{ old('footer_tagline', $settings['footer_tagline'] ?? '') }}" placeholder="{{ __('Quality products for everyone. Shop with confidence.') }}" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>
    </div>

    {{-- Tab: SEO --}}
    <div id="tab-seo" class="settings-panel hidden space-y-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('SEO') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Default meta tags for the site. Used when a page does not set its own.') }}</p>
        @include('admin::components.form-field', [
            'name' => 'meta_title',
            'label' => __('Meta title'),
            'type' => 'text',
            'value' => $settings['meta_title'] ?? '',
            'attributes' => ['placeholder' => config('app.name')],
        ])
        @include('admin::components.form-field', [
            'name' => 'meta_description',
            'label' => __('Meta description'),
            'type' => 'textarea',
            'value' => $settings['meta_description'] ?? '',
            'attributes' => ['rows' => 3, 'placeholder' => __('Short description for search engines.')],
        ])
        @include('admin::components.form-field', [
            'name' => 'meta_keywords',
            'label' => __('Meta keywords'),
            'type' => 'text',
            'value' => $settings['meta_keywords'] ?? '',
            'attributes' => ['placeholder' => 'keyword1, keyword2'],
        ])
        @include('admin::components.form-field', [
            'name' => 'og_image',
            'label' => __('OG image URL'),
            'type' => 'text',
            'value' => $settings['og_image'] ?? '',
            'attributes' => ['placeholder' => 'https://example.com/image.jpg'],
        ])
    </div>

    {{-- Tab: Site labels --}}
    <div id="tab-labels" class="settings-panel hidden space-y-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Site labels') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Navbar & footer words (leave blank to use default translation)') }}</p>
        @php $labels = $settings['labels'] ?? []; @endphp
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="label_site_name" class="block text-sm font-medium text-gray-700">{{ __('Site name') }}</label>
                <input type="text" name="labels[site_name]" id="label_site_name" value="{{ old('labels.site_name', $labels['site_name'] ?? '') }}" placeholder="{{ config('app.name') }}" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            @foreach(['nav_home' => 'Home', 'nav_categories' => 'Categories', 'nav_products' => 'Products', 'nav_contact' => 'Contact', 'nav_cart' => 'Cart', 'nav_login' => 'Login', 'nav_register' => 'Register', 'nav_account' => 'Account', 'nav_logout' => 'Logout', 'nav_admin' => 'Admin'] as $key => $placeholder)
                <div>
                    <label for="label_{{ $key }}" class="block text-sm font-medium text-gray-700">{{ $placeholder }}</label>
                    <input type="text" name="labels[{{ $key }}]" id="label_{{ $key }}" value="{{ old('labels.'.$key, $labels[$key] ?? '') }}" placeholder="{{ $placeholder }}" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tab: Frontend (hero/header images) --}}
    @php
        $heroDisplayUrl = function ($val) {
            if (empty($val)) return null;
            return str_starts_with($val, 'http') ? $val : \Illuminate\Support\Facades\Storage::url($val);
        };
    @endphp
    <div id="tab-frontend" class="settings-panel hidden space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Frontend') }}</h2>
            <p class="mt-1 text-sm text-gray-500">{{ __("Configure header images for key frontend pages and the home hero slider. Upload an image or paste a URL.") }}</p>
        </div>
        <div class="space-y-6">
            {{-- Page headers --}}
            <div>
                <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">{{ __('Page headers') }}</h3>
                <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-3">
                    @foreach(['hero_account' => __('Account header image'), 'hero_cart' => __('Cart header image'), 'hero_checkout' => __('Checkout header image'), 'hero_contact' => __('Contact header image'), 'hero_page' => __('Static pages header image'), 'hero_search' => __('Search header image'), 'hero_categories' => __('Categories header image'), 'hero_products' => __('Products header image')] as $key => $label)
                        @php $val = $settings[$key] ?? ''; $imgUrl = $heroDisplayUrl($val); @endphp
                        <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                            <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <p class="mt-0.5 text-xs text-gray-500">{{ __('Recommended dimensions') }}: 1920×600</p>
                            @if($imgUrl)
                                <div class="mt-2 overflow-hidden rounded-lg border border-gray-200 bg-white">
                                    <img src="{{ $imgUrl }}" alt="" class="h-28 w-full object-cover" loading="lazy">
                                </div>
                            @endif
                            <div class="mt-2">
                                <input type="file" name="hero_file_{{ $key }}" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-brand-gold/20 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand-teal hover:file:bg-brand-gold/30">
                            </div>
                            <input type="text" name="{{ $key }}" value="{{ old($key, $val) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- Home hero slider (3 images) --}}
            <div>
                <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">{{ __('Home hero slider') }}</h3>
                <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-3">
                    @foreach(['hero_home_1' => __('Home hero image 1'), 'hero_home_2' => __('Home hero image 2'), 'hero_home_3' => __('Home hero image 3')] as $key => $label)
                        @php $val = $settings[$key] ?? ''; $imgUrl = $heroDisplayUrl($val); @endphp
                        <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                            <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <p class="mt-0.5 text-xs text-gray-500">{{ __('Recommended dimensions') }}: 1920×1080</p>
                            @if($imgUrl)
                                <div class="mt-2 overflow-hidden rounded-lg border border-gray-200 bg-white">
                                    <img src="{{ $imgUrl }}" alt="" class="h-28 w-full object-cover" loading="lazy">
                                </div>
                            @endif
                            <div class="mt-2">
                                <input type="file" name="hero_file_{{ $key }}" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-brand-gold/20 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand-teal hover:file:bg-brand-gold/30">
                            </div>
                            <input type="text" name="{{ $key }}" value="{{ old($key, $val) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tab: Contact & Social --}}
    <div id="tab-contact-social" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Contact & Social') }}</h2>
        <p class="text-sm text-gray-500">{{ __('These values appear in the footer, contact page, and as floating social icons. Leave blank to hide.') }}</p>
        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
            <div>
                <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">{{ __('Social links') }}</h3>
                <div class="space-y-3">
                    @include('admin::components.form-field', ['name' => 'whatsapp_url', 'label' => __('WhatsApp URL'), 'type' => 'text', 'value' => $settings['whatsapp_url'] ?? '', 'attributes' => ['placeholder' => 'https://wa.me/966501234567']])
                    @include('admin::components.form-field', ['name' => 'instagram_url', 'label' => __('Instagram URL'), 'type' => 'text', 'value' => $settings['instagram_url'] ?? '', 'attributes' => ['placeholder' => 'https://instagram.com/yourstore']])
                    @include('admin::components.form-field', ['name' => 'facebook_url', 'label' => __('Facebook URL'), 'type' => 'text', 'value' => $settings['facebook_url'] ?? '', 'attributes' => ['placeholder' => 'https://facebook.com/yourpage']])
                    @include('admin::components.form-field', ['name' => 'twitter_url', 'label' => __('Twitter / X URL'), 'type' => 'text', 'value' => $settings['twitter_url'] ?? '', 'attributes' => ['placeholder' => 'https://twitter.com/yourstore']])
                </div>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">{{ __('Contact info') }}</h3>
                <div class="space-y-3">
                    @include('admin::components.form-field', ['name' => 'contact_email', 'label' => __('Email'), 'type' => 'text', 'value' => $settings['contact_email'] ?? '', 'attributes' => ['placeholder' => 'info@example.com']])
                    @include('admin::components.form-field', ['name' => 'contact_email_secondary', 'label' => __('Email (secondary)'), 'type' => 'text', 'value' => $settings['contact_email_secondary'] ?? '', 'attributes' => ['placeholder' => 'support@example.com']])
                    @include('admin::components.form-field', ['name' => 'contact_phone', 'label' => __('Phone'), 'type' => 'text', 'value' => $settings['contact_phone'] ?? '', 'attributes' => ['placeholder' => '+966 50 123 4567']])
                    @include('admin::components.form-field', ['name' => 'contact_phone_secondary', 'label' => __('Phone (secondary)'), 'type' => 'text', 'value' => $settings['contact_phone_secondary'] ?? '', 'attributes' => ['placeholder' => '+966 11 234 5678']])
                    @include('admin::components.form-field', ['name' => 'contact_location', 'label' => __('Address / Location'), 'type' => 'textarea', 'value' => $settings['contact_location'] ?? '', 'attributes' => ['rows' => 3, 'placeholder' => __('Full address or area')]])
                </div>
            </div>
        </div>
    </div>

    {{-- Tab: Announcement bar (popup) --}}
    <div id="tab-announcement" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Announcement bar') }}</h2>
        <p class="text-sm text-gray-500">{{ __('A dismissible bar at the top of the site (e.g. "10% off first order"). Hidden once per session when the user closes it.') }}</p>
        @include('admin::components.form-field', [
            'name' => 'announcement_bar_enabled',
            'label' => '',
            'type' => 'checkbox',
            'value' => ($settings['announcement_bar_enabled'] ?? '0') === '1',
            'attributes' => ['help' => __('Show announcement bar')],
        ])
        @include('admin::components.form-field', [
            'name' => 'announcement_bar_text',
            'label' => __('Announcement text'),
            'type' => 'text',
            'value' => $settings['announcement_bar_text'] ?? '',
            'attributes' => ['placeholder' => __('e.g. 10% off your first order')],
        ])
        @include('admin::components.form-field', [
            'name' => 'announcement_bar_link',
            'label' => __('Link (optional)'),
            'type' => 'text',
            'value' => $settings['announcement_bar_link'] ?? '',
            'attributes' => ['placeholder' => 'https://'],
        ])
    </div>

    {{-- Tab: Shipping --}}
    <div id="tab-shipping" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Shipping') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Configure how shipping cost is calculated at checkout.') }}</p>
        @include('admin::components.form-field', [
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
        @include('admin::components.form-field', ['name' => 'shipping_flat_rate', 'label' => __('Flat rate (SAR)'), 'type' => 'number', 'value' => $settings['shipping_flat_rate'] ?? '0', 'attributes' => ['step' => '0.01', 'min' => 0]])
        @include('admin::components.form-field', ['name' => 'shipping_free_over', 'label' => __('Free shipping over (SAR)'), 'type' => 'number', 'value' => $settings['shipping_free_over'] ?? '', 'attributes' => ['step' => '0.01', 'min' => 0, 'placeholder' => __('Leave empty to disable')]])
        <div>
            <label for="shipping_zones" class="block text-sm font-medium text-gray-700">{{ __('Shipping zones (JSON)') }}</label>
            <p class="mt-0.5 text-xs text-gray-500">{{ __('When type is Zones, paste JSON array: [{"id":"riyadh","label":"Riyadh","amount":15},{"id":"other","label":"Rest of KSA","amount":25}]') }}</p>
            <textarea name="shipping_zones" id="shipping_zones" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 font-mono text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">{{ old('shipping_zones', $settings['shipping_zones'] ?? '') }}</textarea>
        </div>
    </div>

    {{-- Tab: Maintenance mode --}}
    <div id="tab-maintenance" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Maintenance mode') }}</h2>
        <p class="text-sm text-gray-500">{{ __('When enabled, visitors see a "Coming back soon" page. Admin and allowlisted IPs can still access the site.') }}</p>
        @include('admin::components.form-field', [
            'name' => 'maintenance_mode_enabled',
            'label' => '',
            'type' => 'checkbox',
            'value' => ($settings['maintenance_mode_enabled'] ?? '0') === '1',
            'attributes' => ['help' => __('Enable maintenance mode')],
        ])
        @include('admin::components.form-field', [
            'name' => 'maintenance_coming_back_at',
            'label' => __('Coming back at (optional)'),
            'type' => 'text',
            'value' => $settings['maintenance_coming_back_at'] ?? '',
            'attributes' => ['placeholder' => 'e.g. 2025-03-20 14:00'],
        ])
        <div>
            <label for="maintenance_ip_allowlist" class="block text-sm font-medium text-gray-700">{{ __('IP allowlist') }}</label>
            <p class="mt-0.5 text-xs text-gray-500">{{ __('Comma or newline-separated IPs that can access the site during maintenance. Leave empty to allow only admin.') }}</p>
            <textarea name="maintenance_ip_allowlist" id="maintenance_ip_allowlist" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 font-mono text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal" placeholder="192.168.1.1, 10.0.0.1">{{ old('maintenance_ip_allowlist', $settings['maintenance_ip_allowlist'] ?? '') }}</textarea>
        </div>
    </div>

    {{-- Tab: Trust badges (footer / checkout line) --}}
    <div id="tab-trust-badges" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Trust badges') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Optional line shown in footer and checkout, e.g. "Secure payment", "Free shipping over X SAR", "Easy returns".') }}</p>
        @include('admin::components.form-field', ['name' => 'trust_badge_1', 'label' => __('Badge 1'), 'type' => 'text', 'value' => $settings['trust_badge_1'] ?? '', 'attributes' => ['placeholder' => 'e.g. Secure payment']])
        @include('admin::components.form-field', ['name' => 'trust_badge_2', 'label' => __('Badge 2'), 'type' => 'text', 'value' => $settings['trust_badge_2'] ?? '', 'attributes' => ['placeholder' => 'e.g. Free shipping over 200 SAR']])
        @include('admin::components.form-field', ['name' => 'trust_badge_3', 'label' => __('Badge 3'), 'type' => 'text', 'value' => $settings['trust_badge_3'] ?? '', 'attributes' => ['placeholder' => 'e.g. Easy returns']])
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
        @include('admin::components.form-field', [
            'name' => 'tinymce_api_key',
            'label' => __('TinyMCE API key'),
            'type' => 'text',
            'value' => $settings['tinymce_api_key'] ?? '',
            'attributes' => ['placeholder' => 'your-api-key', 'autocomplete' => 'off'],
        ])
    </div>

    @include('admin::components.form-actions', [
        'submitLabel' => __('Save settings'),
        'cancelUrl' => null,
    ])
</form>
@endcomponent

@push('admin-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.settings-tab');
    var panels = document.querySelectorAll('.settings-panel');
    tabs.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var tab = this.getAttribute('data-tab');
            tabs.forEach(function(b) {
                b.classList.remove('border-brand-teal', 'text-brand-teal');
                b.classList.add('border-transparent', 'text-gray-500');
            });
            this.classList.add('border-brand-teal', 'text-brand-teal');
            this.classList.remove('border-transparent', 'text-gray-500');
            panels.forEach(function(p) {
                p.classList.add('hidden');
                if (p.id === 'tab-' + tab) p.classList.remove('hidden');
            });
        });
    });
});
</script>
@endpush
@endsection
