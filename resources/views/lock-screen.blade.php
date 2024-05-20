<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-profilepicture />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('unlock') }}">
            @csrf

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

           
            <div class="flex items-center justify-end mt-4">
                <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Not You? Sign In') }}
                </a> -->

                <x-button class="ms-4">
                    {{ __('Unlock') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
