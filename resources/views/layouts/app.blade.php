<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=-1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
        <style>
            header.formatText
            {
                color: #f26d64;
                font-size: x-large;
                font-family: cursive;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navbar')

            <!-- Page Heading -->
             @if(isset($header))
            <header class="bg-white shadow-sm mb-4 formatText">
                <div class="container py-4">
                    {!! $header ?? '' !!}
                </div>
            </header>
            @endif
            <!-- Page Content -->
            <main class="py-4">
                @yield('content') <!-- Make sure this exists -->
            </main>
        </div>
    </body>
</html>
