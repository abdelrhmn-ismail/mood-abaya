@extends('frontend.layouts.app')

@section('title', $category->name . ' – ' . config('app.name'))
@section('description', Str::limit(strip_tags($category->description ?? ''), 160) ?: $category->name)

@push('scripts')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": {{ json_encode(__('Categories')) }}, "item": {{ json_encode(route('categories')) }} },
            { "@type": "ListItem", "position": 2, "name": {{ json_encode($category->name) }} }
        ]
    }
    </script>
@endpush
@section('content')
    <section class="bg-slate-50 py-10 md:py-14">
        <div class="container mx-auto px-4">
            <nav class="mb-6 flex flex-wrap items-center gap-1 text-sm text-brand-black/70" aria-label="Breadcrumb">
                <a href="{{ route('categories') }}" class="transition hover:text-brand-teal">{{ __('Categories') }}</a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <span class="font-medium text-brand-black">{{ $category->name }}</span>
            </nav>
            <h1 class="text-4xl font-bold tracking-tight text-brand-black md:text-5xl">{{ $category->name }}</h1>
            @if($category->description)
                <div class="mt-4 max-w-2xl text-brand-black/80 prose prose-slate prose-headings:text-brand-black prose-a:text-brand-teal">{!! safe_html($category->description) !!}</div>
            @endif

            {{-- Filters & sort --}}
            <form method="GET" class="mt-10 flex flex-wrap items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <span class="text-sm font-medium text-slate-600">{{ __('Sort by') }}</span>
                <select name="sort" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20" onchange="this.form.submit()">
                    <option value="name_asc" {{ ($filters['sort'] ?? '') === 'name_asc' ? 'selected' : '' }}>{{ __('Name A–Z') }}</option>
                    <option value="name_desc" {{ ($filters['sort'] ?? '') === 'name_desc' ? 'selected' : '' }}>{{ __('Name Z–A') }}</option>
                    <option value="price_asc" {{ ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' }}>{{ __('Price: low to high') }}</option>
                    <option value="price_desc" {{ ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' }}>{{ __('Price: high to low') }}</option>
                    <option value="newest" {{ ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' }}>{{ __('Newest') }}</option>
                </select>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="in_stock" value="1" {{ ($filters['in_stock'] ?? false) ? 'checked' : '' }} onchange="this.form.submit()" class="rounded border-slate-300 text-brand-teal focus:ring-brand-teal">
                    {{ __('In stock only') }}
                </label>
                <span class="text-sm text-slate-500">{{ __('Price range') }}</span>
                <input type="number" name="price_min" step="0.01" min="0" placeholder="{{ __('Min') }}" value="{{ $filters['price_min'] ?? '' }}" class="w-24 rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                <span class="text-slate-400">–</span>
                <input type="number" name="price_max" step="0.01" min="0" placeholder="{{ __('Max') }}" value="{{ $filters['price_max'] ?? '' }}" class="w-24 rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                <button type="submit" class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark">{{ __('Apply') }}</button>
            </form>

            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($products as $product)
                    <x-frontend.product-card :product="$product" />
                @empty
                    <p class="col-span-full py-12 text-center text-brand-black/70">{{ __('No products in this category.') }}</p>
                @endforelse
            </div>
            @if($products->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
