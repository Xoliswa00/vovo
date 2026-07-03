<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-8">
        <div class="w-full max-w-lg bg-white shadow-xl rounded-3xl">
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center gap-2 mb-4">
                        <img src="{{ asset('assets/img/nobela-mark.png') }}" alt="Nobela Enterprises" class="h-10 w-auto" />
                        <span class="font-heading font-bold text-navy">Nobela Enterprises</span>
                    </a>
                    <h2 class="text-2xl font-bold font-heading text-navy mb-1">Forgot your password?</h2>
                    <p class="text-muted text-sm">No problem. Let us know your email address and we will email you a password reset link.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <x-primary-button class="w-full">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </form>

                <p class="text-center text-sm text-muted mt-6">
                    Remembered your password? <a href="{{ route('login') }}" class="font-semibold text-accent hover:text-accent-dark">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
