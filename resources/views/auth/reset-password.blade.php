<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-8">
        <div class="w-full max-w-lg bg-white shadow-xl rounded-3xl">
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center gap-2 mb-4">
                        <img src="{{ asset('assets/img/nobela-mark.png') }}" alt="Nobela Enterprises" class="h-10 w-auto" />
                        <span class="font-heading font-bold text-navy">Nobela Enterprises</span>
                    </a>
                    <h2 class="text-2xl font-bold font-heading text-navy mb-1">Reset your password</h2>
                    <p class="text-muted text-sm">Choose a new password to secure your account.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <x-primary-button class="w-full">
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
