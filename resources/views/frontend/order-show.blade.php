@extends('frontend.layouts.app')

@section('title', __('Order') . ' ' . $order->order_number . ' – ' . config('app.name'))
@section('description', __('Order details'))

@section('content')
<section class="bg-slate-50 py-16 md:py-20">
    <div class="container mx-auto max-w-4xl px-4">
        <h1 class="text-4xl font-bold text-slate-900">{{ __('Order') }} {{ $order->order_number }}</h1>

        <div class="mt-10 space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-slate-600"><strong>{{ __('Date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p class="text-slate-600"><strong>{{ __('Status') }}:</strong> {{ __($order->status) }}</p>
            <p class="text-slate-600"><strong>{{ __('Payment') }}:</strong> {{ $order->payment_method }} – {{ $order->payment_status }}</p>

            <h2 class="mt-6 text-xl font-semibold text-slate-900">{{ __('Items') }}</h2>
            <ul class="divide-y divide-slate-200">
                @foreach($order->items as $item)
                    <li class="flex justify-between py-3">
                        <span class="text-slate-900">{{ $item->product?->name ?? '-' }} × {{ $item->quantity }}</span>
                        <span class="text-slate-600">{{ number_format($item->quantity * $item->price, 2) }} SAR</span>
                    </li>
                @endforeach
            </ul>
            <p class="border-t border-slate-200 pt-4 font-semibold text-slate-900">{{ __('Total') }}: {{ number_format($order->total, 2) }} SAR</p>

            @if($order->shippings->isNotEmpty())
                @php $shipping = $order->shippings->first(); @endphp
                <div class="mt-6 border-t border-slate-200 pt-4">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('Shipping') }}</h2>
                    <p class="text-slate-600">{{ __('Carrier') }}: {{ $shipping->carrier }}</p>
                    <p class="text-slate-600">{{ __('Tracking number') }}: {{ $shipping->tracking_number }}</p>
                </div>
            @endif
        </div>

        <p class="mt-6"><a href="{{ route('account') }}" class="font-medium text-slate-700 hover:underline">{{ __('Back to account') }}</a></p>
    </div>
</section>
@endsection
