<header class="sticky top-0 z-40 bg-base-100/90 backdrop-blur border-b border-base-200 shadow-xl"
    x-data="{
        showNewsTicker: true,
        lastScrollTop: 0,
        init() {
            // Only initialize scroll behavior on homepage
            if (window.location.pathname !== '/') {
                return;
            }

            window.addEventListener('scroll', () => {
                const currentScrollTop = window.scrollY || document.documentElement.scrollTop;
                
                // Hide when scrolling down, show when scrolling up
                if (currentScrollTop > this.lastScrollTop && currentScrollTop > 100) {
                    // Scrolling down - hide the news ticker
                    this.showNewsTicker = false;
                } else if (currentScrollTop < this.lastScrollTop) {
                    // Scrolling up - show the news ticker
                    this.showNewsTicker = true;
                } else if (currentScrollTop <= 100) {
                    // At the top - always show
                    this.showNewsTicker = true;
                }
                
                this.lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
            }, { passive: true });
        }
    }"
>
    <div class="navbar max-w-[1200px] mx-auto px-4 h-14">
        <!-- Brand -->
        <div class="flex-1">
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <img class="h-12 w-12 avatar bg-white" src="/images/logo.png" alt="">
                <span class="hidden text-white sm:block font-semibold">South Sudan Premier League</span>
            </a>
        </div>

        <!-- Primary Nav -->
        <div class="hidden xl:flex items-center gap-5 mx-6 text-sm">
            <a href="{{ route('matches') }}" class="btn btn-ghost btn-sm">Matches</a>
            <a href="{{ route('standings') }}" class="btn btn-ghost btn-sm">Table</a>
            <a href="{{ route('teams.index') }}" class="btn btn-ghost btn-sm">Teams</a>
            <a href="{{ route('players.index') }}" class="btn btn-ghost btn-sm">Players</a>
            <a href="{{ route('news.index') }}" class="btn btn-ghost btn-sm">News</a>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-2">
            <button type="button"
                class="hidden sm:inline-flex items-center gap-2 h-9 px-3 rounded-full border border-base-300 bg-base-100 hover:bg-base-200 btn btn-sm">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <span class="hidden md:inline">Search</span>
            </button>

            <!-- Theme Toggle Button -->
            <button id="theme-toggle" class="btn btn-circle btn-ghost btn-sm" aria-label="Toggle theme">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>
            <button data-toggle-theme="dark,light" data-act-class="ACTIVECLASS"></button>

            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
            @else
                {{-- <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Sign in</a> --}}
            @endauth
        </div>
    </div>

    <!-- News Ticker / Headlines - Only show on homepage and when not scrolled down -->
    @if(request()->is('/'))
        <template x-if="showNewsTicker">
            <livewire:news-ticker />
        </template>
    @endif
</header>
