<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Football League') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-inter">
    <div class="flex flex-col min-h-screen bg-base-200">
        <!-- Global Top Bar -->
        @include('layouts.header')

        <!-- Optional Page Heading Slot (kept for compatibility) -->
        @if (isset($header))
            <div class="border-b border-base-300">
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

</body>

</html>
