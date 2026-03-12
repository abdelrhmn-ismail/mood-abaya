@extends('frontend.layouts.app')

@section('title', __('Account') . ' – ' . config('app.name'))
@section('description', __('Account'))

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">{{ __('Account') }}</h1>

            <div class="grid gap-8 md:grid-cols-2">
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">{{ __('Profile') }}</h2>
                    <dl class="space-y-2 text-gray-600 dark:text-gray-400">
                        <div><span class="font-medium text-gray-900 dark:text-white">{{ __('Your Name') }}:</span> {{ $user->name }}</div>
                        <div><span class="font-medium text-gray-900 dark:text-white">{{ __('Your Email') }}:</span> {{ $user->email }}</div>
                        @if($user->phone)
                            <div><span class="font-medium text-gray-900 dark:text-white">{{ __('Phone') }}:</span> {{ $user->phone }}</div>
                        @endif
                    </dl>
                    <a href="{{ route('profile.edit') }}" class="mt-4 inline-block rounded-lg bg-gray-900 dark:bg-gray-700 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 dark:hover:bg-gray-600">
                        {{ __('Edit Profile') }}
                    </a>
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">{{ __('Order History') }}</h2>
                    @if($orders->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">{{ __('No orders yet.') }}</p>
                        <a href="{{ route('categories') }}" class="mt-4 inline-block text-blue-600 dark:text-blue-400 hover:underline">{{ __('Continue Shopping') }}</a>
                    @else
                        <ul class="space-y-3">
                            @foreach($orders as $order)
                                <li class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-700 pb-3">
                                    <span class="font-mono text-sm text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('Y-m-d') }}</span>
                                    <span class="rounded px-2 py-0.5 text-xs font-medium
                                        @if($order->status === 'pending') bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-200
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                        {{ $order->status }}
                                    </span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ number_format($order->total, 2) }} {{ __('SAR') }}</span>
                                    @if(Route::has('orders.show'))
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('View') }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
