<div class="py-4 lg:py-6">
    <!-- Main grid: Left column (hero + live + news) and Right column (aside) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- LEFT COLUMN: Hero + Live + News -->
        <div class="lg:col-span-2 space-y-6">
            <!-- HERO -->
            <section>
                <div class="card card-bordered bg-gradient-to-r from-success to-warning/50 text-white shadow-sm">
                    <div class="card-body">
                        <div
                            class="inline-flex items-center gap-2 text-white bg-success/50 rounded-full w-32 px-3 h-7 text-[13px] mb-3">
                            <span class="h-2 w-2 rounded-full bg-error"></span>
                            Transfer Watch
                        </div>
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-2">VOTE: Who's the BEST signing of
                            the summer transfer window?</h1>
                        <p class="text-base-content/70 mb-5">From Gyokeres to Mbeumo, take your pick from standout
                            transfers this summer.</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="#" class="btn btn-primary btn-sm">Vote now</a>
                            <a href="#" class="btn btn-outline btn-sm">See all transfers</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Live Matches -->
            @if ($liveFixtures->isNotEmpty())
                <section class="card card-bordered">
                    <div class="card-body p-0">
                        <div class="px-5 py-4 border-b border-error/20 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-error animate-pulse"></span>
                            <h2 class="text-lg font-semibold text-error">Live Matches</h2>
                        </div>
                        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($liveFixtures as $fixture)
                                <a href="{{ route('fixtures.show', $fixture->id) }}" class="card bg-base-100 hover:shadow-sm transition-all duration-300">
                                    <div class="card-body p-4">
                                        <div class="flex items-center justify-between text-[13px] text-base-content/70 mb-3">
                                            <span class="badge badge-sm badge-accent">{{ $fixture->league->name }}</span>
                                            <span class="badge badge-sm text-xs bg-error text-white font-bold">LIVE</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="avatar placeholder">
                                                    <div class="mask mask-squircle h-12 w-12 bg-base-200">
                                                        @if($fixture->homeTeam->logo_path)
                                                            <img src="{{ asset('storage/'.$fixture->homeTeam->logo_path) }}" alt="{{ $fixture->homeTeam->name }} logo" class="w-8 h-8 object-contain">
                                                        @else
                                                            <span class="text-xs">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <span class="font-medium">{{ $fixture->homeTeam->name }}</span>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-error">{{ $fixture->home_score }} - {{ $fixture->away_score }}</div>
                                                <div class="text-[12px] text-base-content/70 mt-1">
                                                    @if($fixture->status === 'live')
                                                        LIVE
                                                    @else
                                                        {{ $fixture->kickoff_time->format('H:i') }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="font-medium">{{ $fixture->awayTeam->name }}</span>
                                                <div class="avatar placeholder">
                                                    <div class="mask mask-squircle h-12 w-12 bg-base-200">
                                                        @if($fixture->awayTeam->logo_path)
                                                            <img src="{{ asset('storage/'.$fixture->awayTeam->logo_path) }}" alt="{{ $fixture->awayTeam->name }} logo" class="w-8 h-8 object-contain">
                                                        @else
                                                            <span class="text-xs">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <!-- Upcoming Matches -->
            <section class="card card-bordered">
                <div class="card-body p-0">
                    <div class="px-5 py-4 border-b border-primary/20">
                        <h2 class="text-lg font-semibold text-primary">Upcoming Matches</h2>
                    </div>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($upcomingFixtures as $fixture)
                            <a href="{{ route('fixtures.show', $fixture->id) }}" class="card bg-base-100  hover:shadow-sm transition-all duration-300">
                                <div class="card-body p-4">
                                    <div class="flex items-center justify-between mb-3 text-[13px] text-base-content/70">
                                        <span class="badge badge-sm badge-secondary">{{ $fixture->league->name }}</span>
                                        <span>{{ $fixture->kickoff_time->format('M j, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                    <div class="mask mask-squircle h-12 w-12 bg-base-200">
                        @if($fixture->homeTeam->logo_path)
                            <img src="{{ asset('storage/'.$fixture->homeTeam->logo_path) }}" alt="{{ $fixture->homeTeam->name }} logo" class="w-8 h-8 object-contain">
                        @else
                            <span class="text-xs">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                        @endif
                    </div>
                </div>
                                            <span class="font-medium">{{ $fixture->homeTeam->name }}</span>
                                        </div>
                                        <div class="text-base-content/70 font-bold">VS</div>
                                        <div class="flex items-center gap-3">
                                            <span class="font-medium">{{ $fixture->awayTeam->name }}</span>
                                            <div class="avatar placeholder">
                    <div class="mask mask-squircle h-12 w-12 bg-base-200">
                        @if($fixture->awayTeam->logo_path)
                            <img src="{{ asset('storage/'.$fixture->awayTeam->logo_path) }}" alt="{{ $fixture->awayTeam->name }} logo" class="w-8 h-8 object-contain">
                        @else
                            <span class="text-xs">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                        @endif
                    </div>
                </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-[13px] text-base-content/70 text-center">
                                        <span class="badge badge-outline badge-sm">{{ $fixture->kickoff_time->format('g:i A') }}</span> at {{ $fixture->venue }}
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-10 text-base-content/70 col-span-2">No upcoming matches scheduled.</div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN: Aside (Top Standings + Quick Links + Premier League) -->
        <aside class="space-y-6">
            <!-- Top Standings -->
            <section class="card card-bordered bg-base-100 ">
                <div class="card-body p-0">
                    <div class="px-5 py-4 border-b border-base-content/10">
                        <h2 class="text-lg font-semibold">Top Standings</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr class="text-xs text-base-content/70">
                                    <th class="px-4 py-3 text-left">Pos</th>
                                    <th class="px-4 py-3 text-left">Team</th>
                                    <th class="px-4 py-3 text-center">P</th>
                                    <th class="px-4 py-3 text-center">GD</th>
                                    <th class="px-4 py-3 text-center">Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topStandings as $index => $standing)
                                    <tr class="hover">
                                        <td class="px-4 py-3 text-sm font-medium">
                                            <span
                                                class="{{ $index < 4 ? 'text-success font-bold' : 'text-base-content' }}">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <div class="mask mask-squircle h-8 w-8 ">
                                                    @if($standing->team->logo_path)
                                                        <img src="{{ asset('storage/'.$standing->team->logo_path) }}" alt="{{ $standing->team->name }} logo" class="w-6 h-6 mr-2 object-contain">
                                                    @else
                                                        <span class="text-xs">{{ substr($standing->team->name, 0, 3) }}</span>
                                                    @endif
                                                </div>
                                                <span class="text-sm font-medium">{{ $standing->team->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-base-content/70">
                                            {{ $standing->played }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-base-content/70">
                                            {{ $standing->goal_difference }}</td>
                                        <td
                                            class="px-4 py-3 text-center text-sm font-semibold {{ $index < 4 ? 'text-success' : '' }}">
                                            {{ $standing->points }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-base-content/70">No
                                            standings available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 bg-base-200 border-t border-base-content/10 text-center text-sm">
                        <a href="{{ route('standings') }}" class="text-primary hover:text-primary-focus font-medium">View Full Standings
                            →</a>
                    </div>
                </div>
            </section>

            <!-- Quick Links -->
            {{-- <section class="card card-bordered bg-base-100 shadow-sm">
                <div class="card-body p-0">
                    <div class="px-5 py-4 border-b border-base-content/10">
                        <h2 class="text-lg font-semibold">Quick Links</h2>
                    </div>
                    <div class="p-4 grid grid-cols-2 gap-3">
                        <div class="card bg-base-200 hover:bg-base-300 transition-colors cursor-pointer" onclick="location.href='#'">
                            <div class="card-body items-center justify-center p-4">
                                <div class="bg-primary/10 p-3 rounded-full mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Teams</span>
                            </div>
                        </div>
                        <div class="card bg-base-200 hover:bg-base-300 transition-colors cursor-pointer" onclick="location.href='#'">
                            <div class="card-body items-center justify-center p-4">
                                <div class="bg-success/10 p-3 rounded-full mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Players</span>
                            </div>
                        </div>
                        <div class="card bg-base-200 hover:bg-base-300 transition-colors cursor-pointer" onclick="location.href='#'">
                            <div class="card-body items-center justify-center p-4">
                                <div class="bg-secondary/10 p-3 rounded-full mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Standings</span>
                            </div>
                        </div>
                        <div class="card bg-base-200 hover:bg-base-300 transition-colors cursor-pointer" onclick="location.href='#'">
                            <div class="card-body items-center justify-center p-4">
                                <div class="bg-warning/10 p-3 rounded-full mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Fixtures</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}

        </aside>
    </div>
</div>
