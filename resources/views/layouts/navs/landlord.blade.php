<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('landlord.properties.index') }}" :active="request()->routeIs('landlord.properties.index')">
                        {{ __('Properties') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('landlord.rooms.index') }}" :active="request()->routeIs('landlord.rooms.index')">
                        {{ __('Rooms') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('landlord.tenants.index') }}" :active="request()->routeIs('landlord.tenants.index')">
                        {{ __('Tenants') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('admin.payments') }}" :active="request()->routeIs('admin.payments')">
                        {{ __('Payments') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('landlord.roles.index') }}" :active="request()->routeIs('landlord.roles.index')">
                        {{ __('Roles') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('landlord.users.index') }}" :active="request()->routeIs('landlord.users.index')">
                        {{ __('Users') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('landlord.messages.index') }}" :active="request()->routeIs('landlord.messages.index')">
                        {{ __('Message Tenant') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                @include('layouts.nav-settings')
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('landlord.properties.index') }}" :active="request()->routeIs('landlord.properties.index')">
                {{ __('Properties') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('landlord.rooms.index') }}" :active="request()->routeIs('landlord.rooms.index')">
                {{ __('Rooms') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('landlord.tenants.index') }}" :active="request()->routeIs('landlord.tenants.index')">
                {{ __('Tenants') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('admin.payments') }}" :active="request()->routeIs('admin.payments')">
                {{ __('Payments') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('landlord.roles.index') }}" :active="request()->routeIs('landlord.roles.index')">
                {{ __('Roles') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('landlord.users.index') }}" :active="request()->routeIs('landlord.users.index')">
                {{ __('Users') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('landlord.messages.index') }}" :active="request()->routeIs('landlord.messages.index')">
                {{ __('Message Tenant') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @include('layouts.nav-settings-responsive')
    </div>
</nav>