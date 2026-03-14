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
            $image = str_starts_with($val, 'http') ? $val : \Illuminate\Support\Facades\Storage::url($val);
        }
    }
@endphp

<section class="relative overflow-hidden bg-slate-900" aria-labelledby="hero-header-title">
    <div class="absolute inset-0">
        @if($image)
            <img src="{{ $image }}" alt="" class="h-full w-full object-cover opacity-80">
        @else
            <div class="h-full w-full bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 opacity-90"></div>
        @endif
    </div>
    <div class="absolute inset-0 bg-slate-900/55"></div>
    <div class="relative">
        <div class="container mx-auto px-4 py-12 text-center text-white md:py-16">
            <h1 id="hero-header-title" class="text-3xl font-bold tracking-tight md:text-4xl lg:text-5xl">
                {{ $title }}
            </h1>
            @if($subtitle)
                <p class="mt-3 max-w-2xl mx-auto text-sm text-slate-200 md:text-base">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>
</section>

