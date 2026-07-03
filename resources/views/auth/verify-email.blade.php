<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-8">
        <div class="w-full max-w-lg bg-white shadow-xl rounded-3xl">
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center gap-2 mb-4">
                        <img src="{{ asset('assets/img/nobela-mark.png') }}" alt="Nobela Enterprises" class="h-10 w-auto" />
                        <span class="font-heading font-bold text-navy">Nobela Enterprises</span>
                    </a>
                    <h2 class="text-2xl font-bold font-heading text-navy mb-1">Verify your email</h2>
                    <p class="text-muted text-sm">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking the link we just emailed you? If you didn't receive it, we'll gladly send another.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 mb-4">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="w-full">
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center mt-4">
                    @csrf
                    <button type="submit" class="text-sm text-muted underline hover:text-navy">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
