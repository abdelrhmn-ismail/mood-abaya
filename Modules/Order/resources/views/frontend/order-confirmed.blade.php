@extends('frontend.layouts.app')

@section('title', __('Order Confirmed') . ' – ' . site_title())
@section('description', __('Order Confirmed'))

@section('content')
    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-2xl px-4">
            @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-100 px-4 py-3 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
                <span class="material-icons text-7xl text-green-500">check_circle</span>
                <h1 class="mt-4 text-3xl font-bold text-slate-900">{{ __('Order Confirmed') }}</h1>
                <p class="mt-2 text-slate-600">{{ __('Thank you for your order. We will contact you shortly.') }}</p>
                <p class="mt-4 font-mono text-lg font-semibold text-slate-900">{{ $order->order_number }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ __('Total') }}: {{ number_format($order->total, 2) }} {{ __('SAR') }} · {{ __('Payment') }}: {{ payment_method_label($order->payment_method) }}</p>

                @if($order->payment_status === 'pending_approval')
                    <p class="mt-6 text-sm text-slate-600">{{ __('We have received your payment proof. Our team will confirm and process your order.') }}</p>
                @elseif($order->payment_method === 'cash')
                    <p class="mt-6 text-sm text-slate-600">{{ __('Pay when you receive your order.') }}</p>
                @else
                    <p class="mt-6 text-sm text-slate-600">{{ __('Thank you for your order.') }}</p>
                @endif

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('account') }}" class="rounded-xl bg-brand-teal px-6 py-3 font-semibold text-white hover:bg-brand-teal-dark">{{ __('View in Account') }}</a>
                    <a href="{{ route('categories') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-medium text-slate-700 hover:bg-slate-50">{{ __('Continue Shopping') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
