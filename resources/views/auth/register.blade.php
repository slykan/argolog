<x-guest-layout>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Naziv gospodarstva -->
        <div>
            <x-input-label for="naziv_gospodarstva" value="Naziv gospodarstva" />
            <x-text-input id="naziv_gospodarstva" class="block mt-1 w-full" type="text" name="naziv_gospodarstva" :value="old('naziv_gospodarstva')" required autofocus />
            <x-input-error :messages="$errors->get('naziv_gospodarstva')" class="mt-2" />
        </div>

        <!-- MIPG -->
        <div class="mt-4">
            <x-input-label for="mipg" value="MIPG broj" />
            <x-text-input id="mipg" class="block mt-1 w-full" type="text" name="mipg" :value="old('mipg')" />
            <x-input-error :messages="$errors->get('mipg')" class="mt-2" />
        </div>

        <!-- OIB -->
        <div class="mt-4">
            <x-input-label for="oib" value="OIB" />
            <x-text-input id="oib" class="block mt-1 w-full" type="text" name="oib" :value="old('oib')" />
            <x-input-error :messages="$errors->get('oib')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Ime i prezime')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Cloudflare Turnstile -->
        <div class="mt-4">
            <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
            <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
