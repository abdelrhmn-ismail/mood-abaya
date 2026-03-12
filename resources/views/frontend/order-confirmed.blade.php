@extends('frontend.layouts.app')

@section('title', __('Order Confirmed') . ' – ' . config('app.name'))
@section('description', __('Order Confirmed'))

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4 max-w-2xl">
            @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 text-center shadow-sm">
                <span class="material-icons text-6xl text-green-600 dark:text-green-400 mb-4">check_circle</span>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Order Confirmed') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Thank you for your order. We will contact you shortly.') }}</p>
                <p class="font-mono text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $order->order_number }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">{{ __('Total') }}: {{ number_format($order->total, 2) }} {{ __('SAR') }} · {{ __('Payment') }}: {{ $order->payment_method === 'bank' ? __('Bank Transfer') : __('Cash on Delivery') }}</p>

                @if($order->payment_method === 'bank')
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">{{ __('We have received your payment proof. Our team will confirm and process your order.') }}</p>
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">{{ __('Pay when you receive your order.') }}</p>
                @endif

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('account') }}" class="rounded-lg bg-gray-900 dark:bg-gray-700 px-6 py-2.5 font-medium text-white hover:bg-gray-800 dark:hover:bg-gray-600">{{ __('View in Account') }}</a>
                    <a href="{{ route('categories') }}" class="rounded-lg border border-gray-300 dark:border-gray-600 px-6 py-2.5 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Continue Shopping') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
