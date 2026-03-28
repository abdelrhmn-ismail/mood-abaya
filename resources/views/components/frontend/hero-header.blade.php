@props([
    'title',
    'subtitle' => null,
    /**
     * Name of the Setting key that stores the image URL/path.
     * Example: 'hero_account', 'hero_categories', 'hero_products'.
     */
    'setting' => null,
])

@php
    $image = null;
    if ($setting) {
        $val = \App\Models\Setting::get($setting, '');
        if ($val) {
            $image = get_image_url($val) ?? $val;
        }
    }
@endphp

<section class="relative overflow-hidden bg-brand-teal" aria-labelledby="hero-header-title">
    <div class="absolute inset-0">
        @if($image)
            <img src="{{ $image }}" alt="" class="h-full w-full object-cover opacity-80">
        @else
            <div class="h-full w-full bg-gradient-to-r from-brand-teal via-brand-teal-dark to-brand-teal opacity-90"></div>
        @endif
    </div>
    <div class="absolute inset-0 bg-brand-teal/55"></div>
    <div class="relative">
        <div class="container mx-auto px-4 py-12 text-center text-white md:py-16">
            <h1 id="hero-header-title" class="text-3xl font-bold tracking-tight md:text-4xl lg:text-5xl">
                {{ $title }}
            </h1>
            @if($subtitle)
                <p class="mt-3 max-w-2xl mx-auto text-sm text-white/90 md:text-base">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>
</section>

