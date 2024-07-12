<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('makazi-hub-favicon-black.png') }}" alt="Photo of logo" class="h-16 w-16 rounded-full shadow-md">
            </div>
        </x-slot>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="mb-4 text-lg text-center text-teal-600 font-semibold">
                {{ __('The house has been added successfully!') }}
            </div>

            <div class="mb-6 text-center text-gray-600">
                {{ __('You can view your profile, go back to the dashboard, or log out below.') }}
            </div>

            <div class="mt-4 flex flex-col items-center space-y-4">
                <a href="{{ route('profile.show') }}" class="w-full px-4 py-2 bg-teal-500 text-white text-sm font-medium rounded-md shadow hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 text-center">
                    {{ __('View Profile') }}
                </a>
                <a href="{{ route('dashboard') }}" class="w-full px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-md shadow hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center">
                    {{ __('Go to Dashboard') }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-md shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
