<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Makazi Hub') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('makazi-hub-favicon-black.png') }}">
    <!-- Include any additional styles or scripts -->
</head>
<body>
<x-guest-layout>
        <x-adding_a_house_component :categories="$categories" />
    </x-guest-layout>
</body>
</html>
