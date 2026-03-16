@extends('admin::layouts.app')

@section('title', __('Frontend settings'))
@section('heading', __('Frontend settings'))

@section('content')
@component('admin::components.card', ['title' => null])
<form action="{{ route('admin.settings.frontend.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    {{-- Tabs --}}
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex flex-wrap gap-4" role="tablist">
            <button type="button" class="settings-tab border-b-2 border-brand-teal px-1 py-3 text-sm font-medium text-brand-teal" data-tab="branding" role="tab">{{ __('Branding') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="colors" role="tab">{{ __('Color palette') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="frontend" role="tab">{{ __('Frontend') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="announcement" role="tab">{{ __('Announcement bar') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="home-popup" role="tab">{{ __('Home popup') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="maintenance" role="tab">{{ __('Maintenance') }}</button>
            <button type="button" class="settings-tab border-b-2 border-transparent px-1 py-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" data-tab="trust-badges" role="tab">{{ __('Trust badges') }}</button>
        </nav>
    </div>

    @php
        $brandingDisplayUrl = function ($val) {
            if (empty($val)) return null;
            return str_starts_with($val, 'http') ? $val : \Illuminate\Support\Facades\Storage::url($val);
        };
        $heroDisplayUrl = $brandingDisplayUrl;
    @endphp

    {{-- Tab: Branding --}}
    <div id="tab-branding" class="settings-panel space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Branding') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Site logo, favicon and footer tagline. Shown in navbar and footer.') }}</p>
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
                <input type="text" name="site_logo" value="{{ old('site_logo', $logoVal) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
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
                <input type="text" name="favicon" value="{{ old('favicon', $favVal) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            </div>
        </div>
        <div>
            <label for="footer_tagline" class="block text-sm font-medium text-gray-700">{{ __('Footer tagline') }}</label>
            <p class="mt-0.5 text-xs text-gray-500">{{ __('Short text under the logo in the footer.') }}</p>
            <input type="text" name="footer_tagline" id="footer_tagline" value="{{ old('footer_tagline', $settings['footer_tagline'] ?? '') }}" placeholder="{{ __('Quality products for everyone. Shop with confidence.') }}" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-brand-teal focus:ring-brand-teal">
        </div>
    </div>

    {{-- Tab: Color palette --}}
    <div id="tab-colors" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Color palette') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Manage the site color design system. These override the default palette used across the store.') }}</p>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                'color_brand_black' => __('Black'),
                'color_brand_teal' => __('Teal (primary)'),
                'color_brand_teal_dark' => __('Teal dark'),
                'color_brand_white' => __('White'),
                'color_brand_gold' => __('Gold'),
                'color_brand_gold_dark' => __('Gold dark'),
            ] as $key => $label)
                @php $val = old($key, $settings[$key] ?? ''); @endphp
                <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                    <input type="color" id="{{ $key }}_picker" value="{{ $val ?: '#000000' }}" class="h-12 w-14 cursor-pointer rounded-lg border border-gray-300 bg-white p-1">
                    <div class="min-w-0 flex-1">
                        <label for="{{ $key }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                        <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ $val }}" placeholder="#000000" maxlength="7" class="mt-0.5 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal" pattern="^#?[a-fA-F0-9]{6}$">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tab: Frontend (hero/header images) --}}
    <div id="tab-frontend" class="settings-panel hidden space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Frontend') }}</h2>
            <p class="mt-1 text-sm text-gray-500">{{ __("Configure header images for key frontend pages and the home hero slider. Upload an image or paste a URL.") }}</p>
        </div>
        <div class="space-y-6">
            <div>
                <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">{{ __('Page headers') }}</h3>
                <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-3">
                    @foreach(['hero_account' => __('Account header image'), 'hero_cart' => __('Cart header image'), 'hero_checkout' => __('Checkout header image'), 'hero_contact' => __('Contact header image'), 'hero_page' => __('Static pages header image'), 'hero_search' => __('Search header image'), 'hero_categories' => __('Categories header image'), 'hero_products' => __('Products header image')] as $key => $label)
                        @php $val = $settings[$key] ?? ''; $imgUrl = $heroDisplayUrl($val); @endphp
                        <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                            <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <p class="mt-0.5 text-xs text-gray-500">{{ __('Recommended dimensions') }}: 1920×600</p>
                            <p class="mt-0.5 text-xs text-gray-400">{{ __('Accepted') }}: JPG, PNG, GIF, WebP. {{ __('Max') }} 2 MB</p>
                            @if($imgUrl)
                                <p class="mt-2 text-xs font-medium text-slate-600">{{ __('Current image') }}</p>
                                <div class="mt-1 min-h-[7rem] overflow-hidden rounded-lg border border-gray-200 bg-white hero-preview" data-error-msg="{{ __('Image unavailable or failed to load') }}">
                                    <img src="{{ $imgUrl }}" alt="" class="h-28 w-full object-cover" loading="lazy" onerror="var el=this.closest('.hero-preview'); if(el){ var msg=el.getAttribute('data-error-msg')||'Image unavailable'; el.innerHTML='<span class=\'flex h-28 items-center justify-center text-xs text-amber-600\'>'+msg+'</span>'; }">
                                </div>
                            @endif
                            <div class="mt-2">
                                <input type="file" name="hero_file_{{ $key }}" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-brand-gold/20 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand-teal hover:file:bg-brand-gold/30">
                            </div>
                            <input type="text" name="{{ $key }}" value="{{ old($key, $val) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">{{ __('Home hero slider') }}</h3>
                <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-3">
                    @foreach(['hero_home_1' => __('Home hero image 1'), 'hero_home_2' => __('Home hero image 2'), 'hero_home_3' => __('Home hero image 3')] as $key => $label)
                        @php $val = $settings[$key] ?? ''; $imgUrl = $heroDisplayUrl($val); @endphp
                        <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                            <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <p class="mt-0.5 text-xs text-gray-500">{{ __('Recommended dimensions') }}: 1920×1080</p>
                            <p class="mt-0.5 text-xs text-gray-400">{{ __('Accepted') }}: JPG, PNG, GIF, WebP. {{ __('Max') }} 2 MB</p>
                            @if($imgUrl)
                                <p class="mt-2 text-xs font-medium text-slate-600">{{ __('Current image') }}</p>
                                <div class="mt-1 min-h-[7rem] overflow-hidden rounded-lg border border-gray-200 bg-white hero-preview" data-error-msg="{{ __('Image unavailable or failed to load') }}">
                                    <img src="{{ $imgUrl }}" alt="" class="h-28 w-full object-cover" loading="lazy" onerror="var el=this.closest('.hero-preview'); if(el){ var msg=el.getAttribute('data-error-msg')||'Image unavailable'; el.innerHTML='<span class=\'flex h-28 items-center justify-center text-xs text-amber-600\'>'+msg+'</span>'; }">
                                </div>
                            @endif
                            <div class="mt-2">
                                <input type="file" name="hero_file_{{ $key }}" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-brand-gold/20 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand-teal hover:file:bg-brand-gold/30">
                            </div>
                            <input type="text" name="{{ $key }}" value="{{ old($key, $val) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tab: Announcement bar --}}
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

    {{-- Tab: Home popup --}}
    <div id="tab-home-popup" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Home popup') }}</h2>
        <p class="text-sm text-gray-500">{{ __('A modal shown on the home page. Use it for promotions, newsletter signup, or welcome message.') }}</p>
        @include('admin::components.form-field', [
            'name' => 'home_popup_enabled',
            'label' => '',
            'type' => 'checkbox',
            'value' => ($settings['home_popup_enabled'] ?? '0') === '1',
            'attributes' => ['help' => __('Enable home page popup')],
        ])
        <div class="border-t border-gray-200 pt-6">
            <h3 class="mb-3 text-sm font-medium text-gray-700">{{ __('Advanced options') }}</h3>
            @include('admin::components.form-field', [
                'name' => 'home_popup_title',
                'label' => __('Popup title'),
                'type' => 'text',
                'value' => $settings['home_popup_title'] ?? '',
                'attributes' => ['placeholder' => __('e.g. Welcome! Get 10% off your first order')],
            ])
            <div class="mt-4">
                <label for="home_popup_content" class="block text-sm font-medium text-gray-700">{{ __('Popup content') }}</label>
                <p class="mt-0.5 text-xs text-gray-500">{{ __('HTML or plain text.') }}</p>
                <textarea name="home_popup_content" id="home_popup_content" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-brand-teal focus:ring-brand-teal">{{ old('home_popup_content', $settings['home_popup_content'] ?? '') }}</textarea>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('Popup image (optional)') }}</label>
                <p class="mt-0.5 text-xs text-gray-500">{{ __('Recommended dimensions') }}: 600×400. {{ __('Accepted') }}: JPG, PNG, GIF, WebP. {{ __('Max') }} 2 MB</p>
                @php $popupImgVal = $settings['home_popup_image'] ?? ''; $popupImgUrl = $heroDisplayUrl($popupImgVal); @endphp
                @if($popupImgUrl)
                    <p class="mt-2 text-xs font-medium text-slate-600">{{ __('Current image') }}</p>
                    <div class="mt-1 min-h-[6rem] overflow-hidden rounded-lg border border-gray-200 bg-white hero-preview" data-error-msg="{{ __('Image unavailable or failed to load') }}">
                        <img src="{{ $popupImgUrl }}" alt="" class="h-24 w-full max-w-xs object-cover" loading="lazy" onerror="var el=this.closest('.hero-preview'); if(el){ var msg=el.getAttribute('data-error-msg')||'Image unavailable'; el.innerHTML='<span class=\'flex h-24 items-center justify-center text-xs text-amber-600\'>'+msg+'</span>'; }">
                    </div>
                @endif
                <div class="mt-2">
                    <input type="file" name="home_popup_image_file" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-brand-gold/20 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand-teal hover:file:bg-brand-gold/30">
                </div>
                <input type="text" name="home_popup_image" value="{{ old('home_popup_image', $popupImgVal) }}" placeholder="{{ __('Or paste image URL') }}" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
            </div>
            @include('admin::components.form-field', [
                'name' => 'home_popup_button_text',
                'label' => __('Button text (optional)'),
                'type' => 'text',
                'value' => $settings['home_popup_button_text'] ?? '',
                'attributes' => ['placeholder' => __('e.g. Shop Now')],
            ])
            @include('admin::components.form-field', [
                'name' => 'home_popup_button_url',
                'label' => __('Button URL (optional)'),
                'type' => 'text',
                'value' => $settings['home_popup_button_url'] ?? '',
                'attributes' => ['placeholder' => 'https://'],
            ])
            @include('admin::components.form-field', [
                'name' => 'home_popup_delay_seconds',
                'label' => __('Show after delay (seconds)'),
                'type' => 'number',
                'value' => $settings['home_popup_delay_seconds'] ?? '2',
                'attributes' => ['min' => 0, 'max' => 30],
            ])
            @include('admin::components.form-field', [
                'name' => 'home_popup_show_once_per_session',
                'label' => '',
                'type' => 'checkbox',
                'value' => ($settings['home_popup_show_once_per_session'] ?? '1') === '1',
                'attributes' => ['help' => __('Show only once per session (until user closes or navigates away)')],
            ])
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

    {{-- Tab: Trust badges --}}
    <div id="tab-trust-badges" class="settings-panel hidden space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Trust badges') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Optional line shown in footer and checkout, e.g. "Secure payment", "Free shipping over X SAR", "Easy returns".') }}</p>
        @include('admin::components.form-field', ['name' => 'trust_badge_1', 'label' => __('Badge 1'), 'type' => 'text', 'value' => $settings['trust_badge_1'] ?? '', 'attributes' => ['placeholder' => 'e.g. Secure payment']])
        @include('admin::components.form-field', ['name' => 'trust_badge_2', 'label' => __('Badge 2'), 'type' => 'text', 'value' => $settings['trust_badge_2'] ?? '', 'attributes' => ['placeholder' => 'e.g. Free shipping over 200 SAR']])
        @include('admin::components.form-field', ['name' => 'trust_badge_3', 'label' => __('Badge 3'), 'type' => 'text', 'value' => $settings['trust_badge_3'] ?? '', 'attributes' => ['placeholder' => 'e.g. Easy returns']])
    </div>

    @include('admin::components.form-actions', [
        'submitLabel' => __('Save settings'),
        'cancelUrl' => route('admin.settings.frontend'),
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
    // Sync color pickers with text inputs
    document.querySelectorAll('input[type="color"][id$="_picker"]').forEach(function(picker) {
        var key = picker.id.replace('_picker', '');
        var textInput = document.getElementById(key);
        if (textInput) {
            picker.addEventListener('input', function() { textInput.value = this.value; });
            textInput.addEventListener('input', function() {
                var v = this.value.replace(/^#/, '');
                if (/^[a-fA-F0-9]{6}$/.test(v)) picker.value = '#' + v;
            });
        }
    });
});
</script>
@endpush
@endsection
