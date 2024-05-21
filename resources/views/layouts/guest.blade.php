<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
            <div class="mt-2 text-center">
                <p class="text-black-700 dark:text-black-200">©
                    <script>document.write(new Date().getFullYear())</script> Elvis.
                </p>
            </div>
        </div>


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

        <script>
            // Flag to indicate if the screen is locked
            let isScreenLocked = false;

            // Function to handle the beforeunload event
            window.onbeforeunload = function(event) {
                // Check if the screen is locked
                if (isScreenLocked) {
                    // Prevent the default behavior, which stops the user from navigating away
                    event.preventDefault();
                    // Optionally, you can return a message to show to the user
                    return "You have locked the screen. Are you sure you want to leave?";
                }
            };

            // Function to lock the screen manually
            function lockScreenManually(event) {
                // Prevent the default link behavior
                event.preventDefault();
                // Submit the form to lock the screen
                document.getElementById('manual-lock-form').submit();
                // Set the flag to indicate that the screen is locked
                isScreenLocked = true;
                // Optionally, you can add visual indicators or disable certain UI elements to show that the screen is locked
            }
        </script>
    </body>
</html>
