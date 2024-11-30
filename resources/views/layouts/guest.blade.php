<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GS-Task management system</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/tailwindcss.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/guest.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 form-div">
            <div>
                <a href="https://www.graspstudios.com/">
                    <img src="{{ asset('logo.png') }}" alt="GS-Management Sys" style="width: 8rem;">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg form-div-contain">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
