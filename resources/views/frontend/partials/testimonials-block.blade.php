@php $testimonials = \App\Models\Testimonial::visible()->limit(6)->get(); @endphp
@if($testimonials->isNotEmpty())
<section class="border-b border-slate-200 bg-slate-50 py-14 md:py-18">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-2xl font-bold text-brand-black md:text-3xl">{{ __('What our customers say') }}</h2>
        <div class="mx-auto mt-10 grid max-w-5xl gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($testimonials as $t)
                <blockquote class="flex flex-col rounded-2xl border border-slate-200 bg-brand-white p-6 shadow-sm">
                    <span class="material-icons text-4xl text-brand-teal/40">format_quote</span>
                    <p class="mt-2 flex-1 text-brand-black/80">&ldquo;{{ $t->quote }}&rdquo;</p>
                    <footer class="mt-4 flex items-center gap-3">
                        @if($t->photo)
                            <img src="{{ get_image_url($t->photo) }}" alt="" class="h-12 w-12 rounded-full object-cover">
                        @else
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal">
                                <span class="material-icons">person</span>
                            </span>
                        @endif
                        <cite class="font-semibold not-italic text-brand-black">{{ $t->name }}</cite>
                    </footer>
                </blockquote>
            @endforeach
        </div>
    </div>
</section>
@endif
