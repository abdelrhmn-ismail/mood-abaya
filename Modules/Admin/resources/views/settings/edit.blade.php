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
                    @foreach(['hero_account' => __('Account header image'), 'hero_cart' => __('Cart header image'), 'hero_contact' => __('Contact header image'), 'hero_page' => __('Static pages header image'), 'hero_search' => __('Search header image'), 'hero_categories' => __('Categories header image'), 'hero_products' => __('Products header image')] as $key => $label)
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
