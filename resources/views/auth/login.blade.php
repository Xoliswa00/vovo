<x-guest-layout>
    <div class="min-w-screen w-9  min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-6">
        <div class="w-full max-w mx-auto space-y-8 bg-white shadow-lg rounded-xl p-10">
            <!-- Logo / Title -->
            <div class="text-center">
                <a href="/" class="flex items-center justify-center mb-4">
                    <img src="{{ asset('assets/img/favicon.png') }}" alt="Logo" class="h-12 w-12">
                </a>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Welcome Back</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Sign in to access your account
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="w-9 mt-6 space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" 
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" 
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" 
                        type="password" 
                        name="password" 
                        required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me + Forgot -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center text-sm text-gray-600">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                        <span class="ml-2">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div>
                    <x-primary-button class="w-full justify-center py-3 text-lg">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Don’t have an account? 
                        <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:text-indigo-500">Sign up</a>
                    </p>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>
