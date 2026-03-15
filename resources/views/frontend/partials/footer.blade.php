<footer class="border-t border-brand-teal-dark bg-brand-teal text-white">
    <div class="container mx-auto px-4 py-16">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center" aria-label="{{ site_label('site_name') }}">
                    @if(site_logo_url())
                        <img src="{{ site_logo_url() }}" alt="" class="h-10 w-auto max-w-[180px] object-contain brightness-0 invert">
                    @else
                        <span class="material-icons text-3xl text-brand-white">storefront</span>
                    @endif
                </a>
                <p class="mt-4 text-sm text-brand-gold/90">{{ footer_tagline() }}</p>
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-brand-white">{{ __('Quick Links') }}</h4>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('home') }}" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ site_label('nav_home') }}</a></li>
                    <li><a href="{{ route('categories') }}" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ site_label('nav_categories') }}</a></li>
                    <li><a href="{{ route('home') }}#products" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ site_label('nav_products') }}</a></li>
                    <li><a href="{{ route('about') }}" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ __('About Us') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-brand-white">{{ __('Support') }}</h4>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('contact') }}" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ __('Contact Us') }}</a></li>
                    <li><a href="{{ route('page.show', 'terms') }}" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ __('Terms & Conditions') }}</a></li>
                    <li><a href="{{ route('page.show', 'privacy') }}" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ __('Privacy Policy') }}</a></li>
                    <li><a href="{{ route('page.show', 'shipping') }}" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ __('Shipping Policy') }}</a></li>
                    <li><a href="{{ route('page.show', 'return-refund') }}" class="text-sm text-white/90 hover:text-brand-gold transition-colors">{{ __('Return & Refund Policy') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-brand-white">{{ __('Contact') }}</h4>
                <ul class="mt-4 space-y-3 text-sm">
                    <li class="flex items-center gap-2"><span class="material-icons text-lg text-brand-gold/80">location_on</span> <span class="text-white/90">{{ __('Store') }}</span></li>
                    <li class="flex items-center gap-2"><span class="material-icons text-lg text-brand-gold/80">email</span> <span class="text-white/90">{{ __('Email us') }}</span></li>
                </ul>
            </div>
        </div>
        <div class="mt-12 border-t border-brand-teal-dark pt-8 text-center text-sm text-brand-gold/80">
            &copy; {{ date('Y') }} {{ site_label('site_name') }}. {{ __('All rights reserved.') }}
        </div>
    </div>
</footer>
