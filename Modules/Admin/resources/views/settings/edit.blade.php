@extends('admin::layouts.app')

@section('title', __('Settings'))
@section('heading', __('Settings'))

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-2xl space-y-8 rounded-lg bg-white p-6 shadow">
    @csrf
    @method('PUT')

    <div class="space-y-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Default locale') }}</h2>
        <div>
            <label for="locale" class="block text-sm font-medium text-gray-700">{{ __('Default locale') }}</label>
            <select name="locale" id="locale" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="en" {{ ($settings['locale'] ?? 'en') === 'en' ? 'selected' : '' }}>English</option>
                <option value="ar" {{ ($settings['locale'] ?? '') === 'ar' ? 'selected' : '' }}>العربية</option>
            </select>
            @error('locale')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Default theme') }}</h2>
        <div>
            <label for="theme" class="block text-sm font-medium text-gray-700">{{ __('Default theme') }}</label>
            <select name="theme" id="theme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="light" {{ ($settings['theme'] ?? 'light') === 'light' ? 'selected' : '' }}>{{ __('Light') }}</option>
                <option value="dark" {{ ($settings['theme'] ?? '') === 'dark' ? 'selected' : '' }}>{{ __('Dark') }}</option>
                <option value="system" {{ ($settings['theme'] ?? '') === 'system' ? 'selected' : '' }}>{{ __('System') }}</option>
            </select>
            @error('theme')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="border-t border-gray-200 pt-8">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('Site labels') }}</h2>
        <p class="mt-1 text-sm text-gray-500">{{ __('Navbar & footer words (leave blank to use default translation)') }}</p>
        @php $labels = $settings['labels'] ?? []; @endphp
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="label_site_name" class="block text-sm font-medium text-gray-700">{{ __('Site name') }}</label>
                <input type="text" name="labels[site_name]" id="label_site_name" value="{{ old('labels.site_name', $labels['site_name'] ?? '') }}" placeholder="{{ config('app.name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_home" class="block text-sm font-medium text-gray-700">Home</label>
                <input type="text" name="labels[nav_home]" id="label_nav_home" value="{{ old('labels.nav_home', $labels['nav_home'] ?? '') }}" placeholder="Home" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_categories" class="block text-sm font-medium text-gray-700">Categories</label>
                <input type="text" name="labels[nav_categories]" id="label_nav_categories" value="{{ old('labels.nav_categories', $labels['nav_categories'] ?? '') }}" placeholder="Categories" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_products" class="block text-sm font-medium text-gray-700">Products</label>
                <input type="text" name="labels[nav_products]" id="label_nav_products" value="{{ old('labels.nav_products', $labels['nav_products'] ?? '') }}" placeholder="Products" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_contact" class="block text-sm font-medium text-gray-700">Contact</label>
                <input type="text" name="labels[nav_contact]" id="label_nav_contact" value="{{ old('labels.nav_contact', $labels['nav_contact'] ?? '') }}" placeholder="Contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_cart" class="block text-sm font-medium text-gray-700">Cart</label>
                <input type="text" name="labels[nav_cart]" id="label_nav_cart" value="{{ old('labels.nav_cart', $labels['nav_cart'] ?? '') }}" placeholder="Cart" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_login" class="block text-sm font-medium text-gray-700">Login</label>
                <input type="text" name="labels[nav_login]" id="label_nav_login" value="{{ old('labels.nav_login', $labels['nav_login'] ?? '') }}" placeholder="Login" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_register" class="block text-sm font-medium text-gray-700">Register</label>
                <input type="text" name="labels[nav_register]" id="label_nav_register" value="{{ old('labels.nav_register', $labels['nav_register'] ?? '') }}" placeholder="Register" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_account" class="block text-sm font-medium text-gray-700">Account</label>
                <input type="text" name="labels[nav_account]" id="label_nav_account" value="{{ old('labels.nav_account', $labels['nav_account'] ?? '') }}" placeholder="Account" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_logout" class="block text-sm font-medium text-gray-700">Logout</label>
                <input type="text" name="labels[nav_logout]" id="label_nav_logout" value="{{ old('labels.nav_logout', $labels['nav_logout'] ?? '') }}" placeholder="Logout" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="label_nav_admin" class="block text-sm font-medium text-gray-700">Admin</label>
                <input type="text" name="labels[nav_admin]" id="label_nav_admin" value="{{ old('labels.nav_admin', $labels['nav_admin'] ?? '') }}" placeholder="Admin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>
    </div>

    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
        {{ __('Save settings') }}
    </button>
</form>
@endsection
