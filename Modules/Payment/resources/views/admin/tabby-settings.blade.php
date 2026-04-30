@extends('admin.layouts.app')

@section('title', __('Tabby Settings'))
@section('heading', __('Tabby Settings'))

@section('content')
@component('components.admin.card', ['title' => null])
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100">
                <span class="material-icons text-emerald-600">credit_score</span>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Tabby Payment Gateway') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Configure your Tabby API credentials for Buy Now Pay Later integration.') }}</p>
            </div>
        </div>
        @if($method)
            <div class="mt-3 flex items-center gap-2">
                <span class="text-sm font-medium text-gray-600">{{ __('Status:') }}</span>
                @if($method->is_active)
                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                        {{ __('Active') }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                        {{ __('Inactive') }}
                    </span>
                @endif
                <form action="{{ route('admin.payment-methods.toggle', $method) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-medium text-brand-teal hover:underline">{{ $method->is_active ? __('Turn off') : __('Turn on') }}</button>
                </form>
            </div>
        @endif
    </div>

    <form action="{{ route('admin.tabby-settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-gray-200 bg-slate-50/50 p-5 space-y-5">
            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-600">{{ __('API Credentials') }}</h3>

            @include('components.admin.form-field', [
                'name'  => 'public_key',
                'label' => __('Public API Key'),
                'type'  => 'text',
                'value' => old('public_key', $settings['public_key'] ?? ''),
                'required' => true,
                'attributes' => ['placeholder' => 'pk_test_...', 'autocomplete' => 'off'],
            ])

            @include('components.admin.form-field', [
                'name'  => 'secret_key',
                'label' => __('Secret API Key'),
                'type'  => 'text',
                'value' => old('secret_key', $settings['secret_key'] ?? ''),
                'required' => true,
                'attributes' => ['placeholder' => 'sk_test_...', 'autocomplete' => 'off'],
            ])

            @include('components.admin.form-field', [
                'name'  => 'merchant_code',
                'label' => __('Merchant Code'),
                'type'  => 'text',
                'value' => old('merchant_code', $settings['merchant_code'] ?? ''),
                'required' => true,
                'attributes' => ['placeholder' => 'e.g. MD'],
            ])
        </div>

        <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-4">
            <div class="flex items-start gap-2">
                <span class="material-icons text-amber-500 text-lg mt-0.5">info</span>
                <div class="text-sm text-amber-800">
                    <p class="font-medium">{{ __('Important Notes') }}</p>
                    <ul class="mt-1 list-disc list-inside space-y-0.5 text-xs text-amber-700">
                        <li>{{ __('Use test keys (pk_test_ / sk_test_) for testing, live keys (pk_live_ / sk_live_) for production.') }}</li>
                        <li>{{ __('Tabby webhook URL:') }} <code class="rounded bg-amber-100 px-1 py-0.5 font-mono text-xs">{{ route('tabby.webhook') }}</code></li>
                        <li>{{ __('Make sure to register the webhook URL in your Tabby dashboard.') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        @include('components.admin.form-actions', [
            'submitLabel' => __('Save Tabby settings'),
            'cancelUrl'   => route('admin.payment-methods.index'),
        ])
    </form>
@endcomponent
@endsection
