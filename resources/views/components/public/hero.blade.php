@props([
    'eyebrow' => 'Logistics, industrial marketplace and boilermaking',
    'title' => 'Freight, fabrication, and a marketplace you can verify',
    'description' => 'Request a freight quote or browse verified industrial products and services from vetted South African vendors, all in one place.',
])

<section class="relative overflow-hidden bg-gradient-to-br from-navy to-navy-deep">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center" data-aos="fade-up" data-aos-delay="100">
            <div class="lg:col-span-7">
                <span class="inline-flex items-center rounded-full px-4 py-2 bg-white/10 text-white/80 text-sm font-semibold mb-4">
                    {{ $eyebrow }}
                </span>

                <h1 class="text-4xl md:text-5xl font-extrabold font-heading text-white leading-tight mb-4">{{ $title }}</h1>
                <p class="text-lg text-white/75 mb-6 max-w-xl">{{ $description }}</p>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('quote.create') }}" class="btn-brand-primary">Request a Quote</a>
                    <a href="{{ route('marketplace.index') }}" class="btn-brand-outline-light">Browse Marketplace</a>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="rounded-3xl bg-white/5 border border-white/10 p-6 space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                            <i class="bi bi-truck text-xl text-white"></i>
                        </div>
                        <div>
                            <h5 class="text-white font-semibold font-heading mb-1">Freight, booked in minutes</h5>
                            <p class="text-white/70 text-sm">Request a quote and track your shipment from pickup to delivery.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                            <i class="bi bi-patch-check text-xl text-white"></i>
                        </div>
                        <div>
                            <h5 class="text-white font-semibold font-heading mb-1">Vendors, verified before they list</h5>
                            <p class="text-white/70 text-sm">Every marketplace vendor is checked before their catalog goes live.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                            <i class="bi bi-tools text-xl text-white"></i>
                        </div>
                        <div>
                            <h5 class="text-white font-semibold font-heading mb-1">Boilermaking, done in-house</h5>
                            <p class="text-white/70 text-sm">Fabrication and repair work handled directly by our own team.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
