<header id="header" x-data="{ mobileOpen: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[72px]">
            <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0">
                <img src="{{ asset('assets/img/nobela-mark.png') }}" alt="Nobela Enterprises" class="h-10 w-auto">
                <span class="font-heading font-bold text-navy hidden sm:inline">Nobela Enterprises</span>
            </a>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="{{ url('/') }}" class="flex items-center gap-1.5 text-sm font-semibold transition-colors {{ request()->routeIs('welcome') ? 'text-accent' : 'text-navy hover:text-accent' }}"><i class="bi bi-house"></i> Home</a>
                <a href="{{ route('services.public') }}" class="flex items-center gap-1.5 text-sm font-semibold transition-colors {{ request()->routeIs('services.public', 'services.show.public') ? 'text-accent' : 'text-navy hover:text-accent' }}"><i class="bi bi-gear"></i> Services</a>
                <a href="{{ route('projects.public') }}" class="flex items-center gap-1.5 text-sm font-semibold transition-colors {{ request()->routeIs('projects.public', 'projects.show.public') ? 'text-accent' : 'text-navy hover:text-accent' }}"><i class="bi bi-hammer"></i> Our Work</a>
                @if(config('features.marketplace'))
                <a href="{{ route('marketplace.index') }}" class="flex items-center gap-1.5 text-sm font-semibold transition-colors {{ request()->routeIs('marketplace.*') ? 'text-accent' : 'text-navy hover:text-accent' }}"><i class="bi bi-shop"></i> Marketplace</a>
                @endif
                <a href="{{ route('quote.create') }}" class="flex items-center gap-1.5 text-sm font-semibold transition-colors {{ request()->routeIs('quote.*') ? 'text-accent' : 'text-navy hover:text-accent' }}"><i class="bi bi-truck"></i> Get a Quote</a>
                <a href="{{ route('about') }}" class="flex items-center gap-1.5 text-sm font-semibold transition-colors {{ request()->routeIs('about') ? 'text-accent' : 'text-navy hover:text-accent' }}"><i class="bi bi-info-circle"></i> About</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('orders.track.lookup') }}" class="hidden lg:inline-flex items-center gap-1 text-sm font-semibold text-navy hover:text-accent transition-colors">
                    <i class="bi bi-box-seam"></i> Track Order
                </a>
                @guest
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-semibold text-navy hover:text-accent transition-colors"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    <a href="{{ route('register') }}" class="btn-brand-primary btn-brand-sm">Register</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-brand-primary btn-brand-sm">Dashboard</a>
                @endguest

                <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-navy text-2xl" aria-label="Toggle navigation menu">
                    <i class="bi" :class="mobileOpen ? 'bi-x-lg' : 'bi-list'"></i>
                </button>
            </div>
        </div>
    </div>

    <nav x-show="mobileOpen" x-cloak x-transition class="lg:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-4 space-y-1">
            <a href="{{ url('/') }}" class="flex items-center gap-2 py-2 text-sm font-semibold text-navy"><i class="bi bi-house"></i> Home</a>
            <a href="{{ route('services.public') }}" class="flex items-center gap-2 py-2 text-sm font-semibold text-navy"><i class="bi bi-gear"></i> Services</a>
            <a href="{{ route('projects.public') }}" class="flex items-center gap-2 py-2 text-sm font-semibold text-navy"><i class="bi bi-hammer"></i> Our Work</a>
            @if(config('features.marketplace'))
            <a href="{{ route('marketplace.index') }}" class="flex items-center gap-2 py-2 text-sm font-semibold text-navy"><i class="bi bi-shop"></i> Marketplace</a>
            @endif
            <a href="{{ route('quote.create') }}" class="flex items-center gap-2 py-2 text-sm font-semibold text-navy"><i class="bi bi-truck"></i> Get a Quote</a>
            <a href="{{ route('about') }}" class="flex items-center gap-2 py-2 text-sm font-semibold text-navy"><i class="bi bi-info-circle"></i> About</a>
            <a href="{{ route('orders.track.lookup') }}" class="flex items-center gap-2 py-2 text-sm font-semibold text-navy"><i class="bi bi-box-seam"></i> Track Order</a>
            @guest
                <a href="{{ route('login') }}" class="flex items-center gap-2 py-2 text-sm font-semibold text-navy"><i class="bi bi-box-arrow-in-right"></i> Login</a>
            @endguest
        </div>
    </nav>
</header>
