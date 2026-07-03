<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-8">
        <div class="w-full max-w-lg bg-white shadow-xl rounded-3xl">
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center gap-2 mb-4">
                        <img src="{{ asset('assets/img/nobela-mark.png') }}" alt="Nobela Enterprises" class="h-10 w-auto" />
                        <span class="font-heading font-bold text-navy">Nobela Enterprises</span>
                    </a>
                    <h2 class="text-2xl font-bold font-heading text-navy mb-1">Confirm your password</h2>
                    <p class="text-muted text-sm">This is a secure area of the application. Please confirm your password before continuing.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <x-primary-button class="w-full">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
