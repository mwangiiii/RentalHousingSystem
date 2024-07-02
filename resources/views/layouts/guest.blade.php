<!-- In the guest.blade layout -->
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

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
        <div class="mt-2 text-center">
            <p class="text-black-700 dark:text-black-200">©
                <script>
                    document.write(new Date().getFullYear())
                </script> Elvis.
            </p>
        </div>
    </div>

    @livewireScripts
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script>
        // Get the password input and the password info message
        const passwordInput = document.getElementById('password');
        const passwordInfo = document.querySelector('.absolute');

        // Show the password info message when hovering over the password input
        passwordInput.addEventListener('mouseenter', () => {
            passwordInfo.style.opacity = '1';
            passwordInfo.style.pointerEvents = 'auto';
        });

        // Hide the password info message when moving mouse out of the password input
        passwordInput.addEventListener('mouseleave', () => {
            passwordInfo.style.opacity = '0';
            passwordInfo.style.pointerEvents = 'none';
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const confirmPasswordInfo = confirmPasswordInput.nextElementSibling;

            confirmPasswordInput.addEventListener('mouseenter', () => {
                confirmPasswordInfo.style.opacity = '1';
                confirmPasswordInfo.style.pointerEvents = 'auto';
            });

            confirmPasswordInput.addEventListener('mouseleave', () => {
                confirmPasswordInfo.style.opacity = '0';
                confirmPasswordInfo.style.pointerEvents = 'none';
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
