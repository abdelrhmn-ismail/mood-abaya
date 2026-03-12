<footer id="contact" class="bg-gray-900 text-gray-300">
    <div class="container mx-auto px-4 py-12">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
            {{-- Brand --}}
            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-lg font-bold text-white">
                    <span class="material-icons text-2xl">storefront</span>
                    {{ config('app.name') }}
                </a>
                <p class="mt-3 text-sm text-gray-400">
                    Quality products for everyone. Shop with confidence.
                </p>
            </div>

            {{-- Quick links --}}
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Quick Links</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ url('/') }}" class="text-sm hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ url('/') }}#categories" class="text-sm hover:text-white transition-colors">Categories</a></li>
                    <li><a href="{{ url('/') }}#products" class="text-sm hover:text-white transition-colors">Products</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition-colors">About Us</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Support</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="text-sm hover:text-white transition-colors">Contact Us</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition-colors">Shipping</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition-colors">Returns</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Contact</h4>
                <ul class="mt-4 space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <span class="material-icons text-lg">location_on</span>
                        123 Store Street
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-icons text-lg">email</span>
                        hello@example.com
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-icons text-lg">phone</span>
                        +1 234 567 890
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</footer>
