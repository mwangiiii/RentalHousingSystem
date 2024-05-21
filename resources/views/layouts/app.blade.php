<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rental App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>

    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}

                <div class="mt-5 text-center">
                    <p class="text-black-500 dark:text-black-200">©
                        <script>document.write(new Date().getFullYear())</script> Elvis.
                    </p>
                </div>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
            <script src="{{ asset('node_modules/intl-tel-input/build/js/intlTelInput.js') }}"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var input = document.querySelector("#phone_number");
                    window.intlTelInput(input, {
                        initialCountry: "auto",
                        geoIpLookup: function(callback) {
                            fetch('https://ipinfo.io/json', { cache: 'reload' })
                                .then(response => response.json())
                                .then(data => {
                                    callback(data.country);
                                })
                                .catch(() => {
                                    callback('us');
                                });
                        },
                        utilsScript: "{{ asset('node_modules/intl-tel-input/build/js/utils.js') }}"
                    });
                });
            </script>

        <!-- Script for auto lock screen-->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script>
            let inactivityTime = function () {
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
                            window.location.href = "{{ route('lock-screen') }}";
                        }
                    });
                }

                function resetTimer() {
                    clearTimeout(time);
                    time = setTimeout(lockScreen, 300000);  // 5 minutes in milliseconds
                }
            };

            inactivityTime();
        </script>
        
        <script>
            function lockScreenManually(event) {
                 // Prevent the default link behavior
                event.preventDefault();
                // Submit the form to lock the screen
                document.getElementById('manual-lock-form').submit();
            }
        </script>
    </body>
</html>
