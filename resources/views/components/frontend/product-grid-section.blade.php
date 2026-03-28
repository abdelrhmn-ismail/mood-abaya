@props(['title', 'products'])

<div {{ $attributes->class('mt-14 rounded-2xl border border-slate-200 bg-brand-white p-6 md:p-8') }}>
    <h2 class="text-xl font-bold text-brand-black">{{ $title }}</h2>
    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($products as $cardProduct)
            <x-frontend.product-card :product="$cardProduct" />
        @endforeach
    </div>
</div>
