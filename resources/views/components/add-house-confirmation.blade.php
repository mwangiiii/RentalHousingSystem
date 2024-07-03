<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <!-- Your logo here -->
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('The house has been added successfully!') }}
        </div>

        <!-- Optional: Add any additional information or instructions here -->

        <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('profile.show') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('View Profile') }}
            </a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
