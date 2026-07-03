<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-8">
        <div class="w-full max-w-lg bg-white shadow-xl rounded-3xl">
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center gap-2 mb-4">
                        <img src="{{ asset('assets/img/nobela-mark.png') }}" alt="Nobela Enterprises" class="h-10 w-auto" />
                        <span class="font-heading font-bold text-navy">Nobela Enterprises</span>
                    </a>
                    <h2 class="text-2xl font-bold font-heading text-navy mb-1">Welcome back</h2>
                    <p class="text-muted text-sm">Sign in to access your account and manage requests, quotes, and orders.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-muted">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-accent focus:ring-accent" />
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-accent hover:text-accent-dark">Forgot password?</a>
                        @endif
                    </div>

                    <x-primary-button class="w-full">
                        {{ __('Log in') }}
                    </x-primary-button>
                </form>

                @if (Route::has('register'))
                    <p class="text-center text-sm text-muted mt-6">
                        Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-accent hover:text-accent-dark">Create one</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
