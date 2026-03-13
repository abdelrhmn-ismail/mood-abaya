@extends('frontend.layouts.app')

@section('title', __('Account') . ' – ' . config('app.name'))
@section('description', __('Account'))

@section('content')
    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-4xl px-4">
            <h1 class="text-4xl font-bold text-slate-900">{{ __('Account') }}</h1>

            <div class="mt-10 grid gap-8 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('Profile') }}</h2>
                    <dl class="mt-4 space-y-2 text-slate-600">
                        <div><span class="font-medium text-slate-900">{{ __('Your Name') }}:</span> {{ $user->name }}</div>
                        <div><span class="font-medium text-slate-900">{{ __('Your Email') }}:</span> {{ $user->email }}</div>
                        @if($user->phone)
                            <div><span class="font-medium text-slate-900">{{ __('Phone') }}:</span> {{ $user->phone }}</div>
                        @endif
                    </dl>
                    <a href="{{ route('profile.edit') }}" class="mt-6 inline-block rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                        {{ __('Edit Profile') }}
                    </a>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('Order History') }}</h2>
                    @if($orders->isEmpty())
                        <p class="mt-4 text-slate-600">{{ __('No orders yet.') }}</p>
                        <a href="{{ route('categories') }}" class="mt-4 inline-block font-medium text-slate-700 hover:underline">{{ __('Continue Shopping') }}</a>
                    @else
                        <ul class="mt-4 space-y-4">
                            @foreach($orders as $order)
                                <li class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-4 last:border-0">
                                    <span class="font-mono text-sm font-medium text-slate-900">{{ $order->order_number }}</span>
                                    <span class="text-sm text-slate-500">{{ $order->created_at->format('Y-m-d') }}</span>
                                    <span class="rounded-lg px-2.5 py-1 text-xs font-medium
                                        @if($order->status === 'pending') bg-amber-100 text-amber-800
                                        @elseif($order->status === 'delivered' || $order->status === 'shipped') bg-green-100 text-green-800
                                        @else bg-slate-100 text-slate-700 @endif">
                                        {{ $order->status }}
                                    </span>
                                    <span class="font-semibold text-slate-900">{{ number_format($order->total, 2) }} {{ __('SAR') }}</span>
                                    <a href="{{ route('orders.show', $order->order_number) }}" class="text-sm font-medium text-slate-700 hover:underline">{{ __('View') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
