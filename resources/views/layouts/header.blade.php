<header class="sticky top-0 z-40 bg-base-100/90 backdrop-blur border-b border-base-200">
            <div class="navbar max-w-[1200px] mx-auto px-4 h-14">
                <!-- Brand -->
                <div class="flex-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                        <span class="inline-flex h-8 w-16 items-center justify-center rounded-lg bg-primary text-primary-content font-bold">SSPL</span>
                        <span class="hidden sm:block font-semibold">South Sudan Premier League</span>
                    </a>
                </div>

                <!-- Primary Nav -->
                <div class="hidden xl:flex items-center gap-5 mx-6 text-sm">
                    <a href="{{ route('matches') }}" class="btn btn-ghost btn-sm">Matches</a>
                    <a href="{{ route('standings') }}" class="btn btn-ghost btn-sm">Table</a>
                    <a href="{{ route('teams.index') }}" class="btn btn-ghost btn-sm">Teams</a>
                    <a href="{{ route('players.index') }}" class="btn btn-ghost btn-sm">Players</a>
                    <a href="#" class="btn btn-ghost btn-sm">News</a>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <button type="button" class="hidden sm:inline-flex items-center gap-2 h-9 px-3 rounded-full border border-base-300 bg-base-100 hover:bg-base-200 btn btn-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                        <span class="hidden md:inline">Search</span>
                    </button>
                    
                    <!-- Theme Toggle Button -->
                    <button id="theme-toggle" class="btn btn-circle btn-ghost btn-sm" aria-label="Toggle theme">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
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

            <!-- News Ticker / Headlines -->
            <div class="border-t border-base-200 bg-base-200/50">
                <div class="max-w-[1200px] mx-auto px-4">
                    <div class="flex items-center gap-3 h-10 overflow-x-auto no-scrollbar text-sm">
                        <span class="inline-flex items-center gap-2 shrink-0 text-base-content/70">
                            <span class="h-2 w-2 rounded-full bg-error"></span>
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
