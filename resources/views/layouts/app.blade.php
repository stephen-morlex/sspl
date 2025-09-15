<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cyberpunk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Football League') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-base-content" data-theme="cyberpunk">
    <div class="min-h-screen flex flex-col bg-secondary text-neutral-content">
        <!-- Global Top Bar -->
         @include('layouts.header')

        <!-- Optional Page Heading Slot (kept for compatibility) -->
        @if (isset($header))
            <div class="bg-secondary border-b border-base-300">
                <div class="max-w-[1200px] mx-auto py-6 px-4">
                    {{ $header }}
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="flex-grow py-6">
            <div class="max-w-[1200px] mx-auto px-4">
                {{ $slot }}
            </div>
        </main>
    </div>
    @include('layouts.footer')

    <!-- Theme Toggle Script using DaisyUI -->
    <script>
        document.getElementById('theme-toggle').addEventListener('click', function() {
            const html = document.querySelector('html');
            if (html.getAttribute('data-theme') === 'light') {
                html.setAttribute('data-theme', 'dark');
            } else {
                html.setAttribute('data-theme', 'light');
            }
        });
    </script>
</body>
</html>
