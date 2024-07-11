<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Makazi Hub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('node_modules/intl-tel-input/build/css/intlTelInput.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <style>
        /* Button styles */
        button {
            /* Variables */
            --button_radius: 0.75em;
            --button_color: #e8e8e8;
            --button_outline_color: #000000;
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: var(--button_radius);
            background: var(--button_outline_color);
        }

        .button_top {
            display: block;
            box-sizing: border-box;
            border: 2px solid var(--button_outline_color);
            border-radius: var(--button_radius);
            padding: 0.75em 1.5em;
            background: var(--button_color);
            color: var(--button_outline_color);
            transform: translateY(-0.2em);
            transition: transform 0.1s ease;
        }

        button:hover .button_top {
            /* Pull the button upwards when hovered */
            transform: translateY(-0.33em);
        }

        button:active .button_top {
            /* Push the button downwards when pressed */
            transform: translateY(0);
        }
    </style>
    <style>
        /* Button styles */
        button {
            --button_radius: 0.75em;
            --button_color: #e8e8e8;
            --button_outline_color: #000000;
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: var(--button_radius);
            background: var(--button_outline_color);
            padding: 0.5em 1.5em;
            margin-right: 0.5em;
            cursor: pointer;
        }

        .button_top {
            display: block;
            box-sizing: border-box;
            border: 2px solid var(--button_outline_color);
            border-radius: var(--button_radius);
            padding: 0.5em 1.5em;
            background: var(--button_color);
            color: var(--button_outline_color);
            transform: translateY(-0.2em);
            transition: transform 0.1s ease;
        }

        button:hover .button_top {
            transform: translateY(-0.33em);
        }

        button:active .button_top {
            transform: translateY(0);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @if (auth()->check() && !session('screen_locked'))
            @if (auth()->user()->hasRole('Admin'))
                @include('layouts.navs.landlord')
            @elseif (auth()->user()->hasRole('Tenant'))
                @include('layouts.navs.tenant')
            @elseif (auth()->user()->hasRole('Lister'))
                @include('layouts.navs.lister')
            @else
                @include('navigation-menu')
            @endif
        @endif

        <!-- Page Heading -->
        @hasSection('header')
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')

            <div class="mt-5 text-center">
                <p class="text-black-500 dark:text-black-200">©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> Elvis & Dennis
                </p>
            </div>
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Charts Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @yield('scripts')
    <script>
        // Auto lock screen script
        let inactivityTime = function() {
            let time;
            window.onload = resetTimer;
            window.onmousemove = resetTimer;
            window.onkeypress = resetTimer;
            window.onscroll = resetTimer;
            window.onclick = resetTimer;

            function lockScreen() {
                fetch("{{ route('auto-lock') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                }).then(response => {
                    if (response.ok) {
                        console.log('Screen locked successfully!');
                        window.location.href = "{{ route('lock-screen') }}";
                    }
                });
            }

            function resetTimer() {
                clearTimeout(time);
                time = setTimeout(lockScreen, 300000); // 5 minutes in milliseconds
            }
        };

        inactivityTime();

        function checkLockStatus() {
            fetch("{{ route('is-locked') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.locked) {
                        window.location.href = "{{ route('lock-screen') }}";
                    }
                });
        }

        // Check lock status on page load and on popstate
        document.addEventListener('DOMContentLoaded', function() {
            checkLockStatus();
        });

        // window.addEventListener('popstate', function(event) {
        //     checkLockStatus();
        // });
    </script>
</body>

</html>