<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="xyz@gmail.com" />
            </div>

            <div class="mt-4">
                <x-label for="phone_number" value="{{ __('Phone Number') }}" />
                <x-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')" required autofocus autocomplete="phone_number" />
            </div>

            <div class="mt-4">
                <x-label for="id_number" value="{{ __('Identification Number/Passport') }}" />
                <x-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number')" required autofocus autocomplete="id_number" placeholder="12345678" />
            </div>

            <div class="mt-4 relative">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <div class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-300 shadow-lg rounded-lg p-2 z-10 opacity-0 pointer-events-none transition-opacity duration-300">
                    <p class="text-sm text-gray-700">Your password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.</p>
                </div>
            </div>

            <div class="mt-4 relative">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <div class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-300 shadow-lg rounded-lg p-2 z-10 opacity-0 pointer-events-none transition-opacity duration-300">
                    <p class="text-sm text-gray-700">Your password should match the one above.</p>
                </div>
            </div>

            <div class="mt-4">
                <x-label for="lister_role" value="{{ __('Register as') }}" />
                <div class="mt-2">
                    <x-label for="lister_role" value="{{ __('Lister') }}"/>
                    <x-input id="lister_role" type="radio" name="role" value="lister" class="mr-2" required />
                </div>

                <div class="mt-2">
                    <x-label for="hunter_role" value="{{ __('House Hunter') }}" />
                    <x-input id="hunter_role" type="radio" name="role" value="hunter" class="mr-2" required />
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-label for="terms">
                    <div class="flex items-center">
                        <x-checkbox name="terms" id="terms" required />

                        <div class="ms-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-label>
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
