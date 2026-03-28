@extends('frontend.layouts.app')

@section('title', $category->name . ' – ' . site_title())
@section('description', Str::limit(strip_tags($category->description ?? ''), 160) ?: $category->name)

@push('scripts')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BreadcrumbList",
        "itemListElement": [
            { "@@type": "ListItem", "position": 1, "name": {{ json_encode(__('Categories')) }}, "item": {{ json_encode(route('categories')) }} },
            { "@@type": "ListItem", "position": 2, "name": {{ json_encode($category->name) }} }
        ]
    }
    </script>
@endpush
@section('content')
    <section class="bg-slate-50 py-10 md:py-14">
        <div class="container mx-auto px-4">
            <nav class="mb-6 flex flex-wrap items-center gap-1 text-sm text-brand-black/70" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ route('categories') }}" class="transition hover:text-brand-teal">{{ __('Categories') }}</a>
                <span class="material-icons text-base text-brand-black/40">chevron_right</span>
                <span class="font-medium text-brand-black">{{ $category->name }}</span>
            </nav>
            <h1 class="text-4xl font-bold tracking-tight text-brand-black md:text-5xl">{{ $category->name }}</h1>
            @if($category->description)
                <div class="mt-4 max-w-2xl text-brand-black/80 prose prose-slate prose-headings:text-brand-black prose-a:text-brand-teal">{!! safe_html($category->description) !!}</div>
            @endif

            <div class="mt-10 flex flex-col gap-8 lg:flex-row lg:items-start">
                <x-frontend.product-filters :filters="$filters" />

                <div class="min-w-0 flex-1">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
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
            </div>
        </div>
    </section>
@endsection
