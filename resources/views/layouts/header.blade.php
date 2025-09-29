<header class="navbar bg-neutral text-neutral-content sticky top-0 z-40 backdrop-blur border-b border-base-200 shadow-sm">
    <div class="flex-1">
        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
            <img class="h-12 w-12 avatar bg-white" src="/images/logo.png" alt="">
            <span class="hidden text-base-content sm:block font-bold text-xl">South Sudan Premier League</span>
        </a>
    </div>

    <!-- Primary Nav -->
    <div class="hidden xl:flex items-center gap-5 mx-6 text-sm">
        <a href="{{ route('matches') }}" class="btn btn-ghost btn-md text-base-content">Matches</a>
        <a href="{{ route('standings') }}" class="btn btn-ghost btn-md text-base-content">Table</a>
        <a href="{{ route('teams.index') }}" class="btn btn-ghost btn-md text-base-content">Teams</a>
        <a href="{{ route('players.index') }}" class="btn btn-ghost btn-md text-base-content">Players</a>
        <a href="{{ route('news.index') }}" class="btn btn-ghost btn-md text-base-content">News</a>
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-2">
        <button type="button"
            class="hidden sm:inline-flex items-center gap-2 h-9 px-3 rounded-full border border-base-300 bg-base-100 hover:bg-base-200 btn btn-sm text-base-content">
            <svg class="h-4 w-4 text-base-content" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <span class="hidden md:inline text-base-content">Search</span>
        </button>

        <!-- Theme Toggle Button -->
        <button class="btn btn-circle btn-ghost btn-md" data-toggle-theme="light,dark" data-act-class="ACTIVECLASS" aria-label="Toggle theme">
            <svg xmlns="http://www.w3.org/2000/svg" class="swap-off h-5 w-5 text-base-content" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="swap-on h-5 w-5 text-base-content" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.354 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </div>
</header>

<!-- News Ticker / Headlines - Only show on homepage -->
@if(request()->is('/'))
    <livewire:news-ticker />
@endif>
