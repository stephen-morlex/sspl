<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Football League') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
    <div class="min-h-screen">
        <!-- Global Top Bar -->
        <header class="sticky top-0 z-40 bg-white dark:bg-[#161615]/90 backdrop-blur border-b border-black/5 dark:border-white/10">
            <div class="max-w-[1200px] mx-auto px-4">
                <div class="h-14 flex items-center gap-3">
                    <!-- Brand -->
                    <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                        <span class="inline-flex h-8 w-16 items-center justify-center rounded-lg bg-[#3E065F] text-white font-bold">SSPL</span>
                        <span class="hidden sm:block font-semibold">South Sudan Premier League</span>
                    </a>

                    <!-- Primary Nav -->
                    <nav class="hidden xl:flex items-center gap-5 mx-6 text-sm">
                        <a href="{{ route('matches') }}" class="hover:underline">Matches</a>
                        <a href="{{ route('standings') }}" class="hover:underline">Table</a>
                        <a href="#" class="hover:underline">Statistics</a>
                        {{-- <a href="#" class="hover:underline">Fantasy</a> --}}
                        {{-- <a href="{{ route('news') }}" class="hover:underline">News</a> --}}
                        {{-- <a href="{{ route('transfers') }}" class="hover:underline">Transfers</a> --}}
                        {{-- <a href="#" class="hover:underline">Injuries</a> --}}
                        <a href="{{ route('players.index') }}" class="hover:underline">Players</a>
                        <a href="{{ route('teams.index') }}" class="hover:underline">Clubs</a>
                        {{-- <a href="#" class="hover:underline">Video</a> --}}
                        <a href="{{ route('matches') }}" class="hover:underline">Watch Live</a>
                    </nav>

                    <!-- Spacer -->
                    <div class="flex-1"></div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <button type="button" class="hidden sm:inline-flex items-center gap-2 h-9 px-3 rounded-full border border-black/10 dark:border-white/10 bg-white dark:bg-[#1c1c1a] hover:bg-black/5 dark:hover:bg-white/5">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                            <span class="hidden md:inline">Search</span>
                        </button>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex h-9 items-center px-4 rounded-full bg-[#37003c] text-white hover:opacity-90">Dashboard</a>
                        @else
                            {{-- <a href="{{ route('login') }}" class="inline-flex h-9 items-center px-4 rounded-full bg-[#37003c] text-white hover:opacity-90">Sign in</a> --}}
                        @endauth
                    </div>
                </div>
            </div>

            <!-- News Ticker / Headlines -->
            <div class="border-t border-black/5 dark:border-white/10 bg-white/50 dark:bg-[#161615]">
                <div class="max-w-[1200px] mx-auto px-4">
                    <div class="flex items-center gap-3 h-10 overflow-x-auto no-scrollbar text-sm">
                        <span class="inline-flex items-center gap-2 shrink-0 text-[#6b7280]">
                            <span class="h-2 w-2 rounded-full bg-[#E11D48]"></span>
                            Latest
                        </span>
                        <ul class="flex items-center gap-6 min-w-max">
                            <li><a class="hover:underline" href="#">Chelsea confirm Champions League squad</a></li>
                            <li><a class="hover:underline" href="#">Spurs announce UCL list</a></li>
                            <li><a class="hover:underline" href="#">Liverpool squad for Europe confirmed</a></li>
                            <li><a class="hover:underline" href="#">Arsenal name UCL squad</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Optional Page Heading Slot (kept for compatibility) -->
        @if (isset($header))
            <div class="bg-gray-200 dark:bg-[#161615] border-b border-black/5 dark:border-white/10">
                <div class="max-w-[1200px] mx-auto py-6 px-4">
                    {{ $header }}
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-[1200px] mx-auto px-4">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
