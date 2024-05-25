<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Login') }}
        </h2>
    </x-slot>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Admin login form -->
    <form method="POST" action="{{ route('admin.authenticate') }}">
        @csrf

        <!-- Hidden Email Address -->
        <input type="hidden" name="email" value="admin@gmail.com" />

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <!-- Login button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Back to homepage button -->
    <div class="mt-6">
        <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">{{ __('Back to Homepage') }}</a>
    </div>
</x-guest-layout>
