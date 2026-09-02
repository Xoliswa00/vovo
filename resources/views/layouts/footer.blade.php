<footer class="bg-navy-deep text-slate-300 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-4">
                <a href="{{ url('/') }}" class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('assets/img/nobela-mark.png') }}" alt="Nobela Enterprises" class="h-8 w-auto">
                    <span class="text-white font-bold font-heading">Nobela Enterprises</span>
                </a>
                <p class="mb-4 text-sm leading-relaxed">Reliable logistics and precision boilermaking solutions tailored for your business. From small parcels to bulk freight, we deliver with quality and trust.</p>
                <div class="flex gap-3">
                    <a href="#" aria-label="Facebook" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent transition-colors"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="X (Twitter)" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent transition-colors"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" aria-label="LinkedIn" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-accent transition-colors"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            <div class="lg:col-span-2 col-span-1">
                <h5 class="text-white font-bold font-heading mb-4">Services</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('services.public') }}" class="hover:text-white transition-colors"><i class="bi bi-chevron-right text-accent-light me-1"></i> All Services</a></li>
                    <li><a href="{{ route('projects.public') }}" class="hover:text-white transition-colors"><i class="bi bi-chevron-right text-accent-light me-1"></i> Our Work</a></li>
                    <li><a href="{{ route('marketplace.index') }}" class="hover:text-white transition-colors"><i class="bi bi-chevron-right text-accent-light me-1"></i> Marketplace</a></li>
                    <li><a href="{{ route('quote.create') }}" class="hover:text-white transition-colors"><i class="bi bi-chevron-right text-accent-light me-1"></i> Get a Quote</a></li>
                    <li><a href="{{ route('orders.track.lookup') }}" class="hover:text-white transition-colors"><i class="bi bi-chevron-right text-accent-light me-1"></i> Track Order</a></li>
                </ul>
            </div>
            <div class="lg:col-span-2 col-span-1">
                <h5 class="text-white font-bold font-heading mb-4">Company</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors"><i class="bi bi-chevron-right text-accent-light me-1"></i> About Us</a></li>
                    <li><a href="{{ route('about') }}#contact" class="hover:text-white transition-colors"><i class="bi bi-chevron-right text-accent-light me-1"></i> Contact</a></li>
                </ul>
            </div>
            <div class="lg:col-span-4">
                <h5 class="text-white font-bold font-heading mb-4">Get in Touch</h5>
                <ul class="space-y-2 text-sm">
                    <li><i class="bi bi-geo-alt text-accent-light me-2"></i> 120 Rietfontein Road, Germiston</li>
                    <li><i class="bi bi-telephone text-accent-light me-2"></i> +27 82 123 4567</li>
                    <li><i class="bi bi-envelope text-accent-light me-2"></i> info@nobelaenterprises.co.za</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="text-center mt-10 pt-6 border-t border-white/10">
        <p class="text-sm text-slate-400">&copy; {{ date('Y') }} <strong class="text-slate-300">Nobela Enterprises</strong>. All Rights Reserved.</p>
    </div>
</footer>
