<div class="py-4 lg:py-6">
    <!-- Main grid: Left column (hero + live + news) and Right column (aside) -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- LEFT COLUMN: Hero + Live + News -->
        <div class="space-y-6 lg:col-span-2">
            <!-- HERO -->
            <section>
                <div class="text-white shadow-sm card card-bordered bg-gradient-to-r from-success to-warning/50">
                    <div class="card-body">
                        <div
                            class="inline-flex items-center gap-2 text-white bg-success/50 rounded-full w-32 px-3 h-7 text-[13px] mb-3">
                            <span class="w-2 h-2 rounded-full bg-error"></span>
                            Transfer Watch
                        </div>
                        <h1 class="mb-2 text-2xl font-semibold md:text-3xl lg:text-4xl">VOTE: Who's the BEST signing of
                            the summer transfer window?</h1>
                        <p class="mb-5 text-base-content/70">From Gyokeres to Mbeumo, take your pick from standout
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
                    <div class="p-0 card-body">
                        <div class="flex items-center gap-2 px-5 py-4 border-error/20 divider">
                            <h2 class="font-semibold text-error">Live Matches</h2>
                        </div>
                        <div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-2">
                            @foreach ($liveFixtures as $fixture)
                                <a href="{{ route('fixtures.show', $fixture->id) }}" class="transition-all duration-300 card bg-base-100 hover:shadow-lg">
                                    <div class="p-4 card-body">
                                        <div class="flex items-center justify-between mb-3 text-[13px] text-base-content/70">
                                            <span class="badge badge-sm badge-accent">{{ $fixture->league->name }}</span>
                                            <span class="text-xs font-bold text-white badge badge-sm bg-error">LIVE</span>
                                        </div>
                                        <div class="flex items-center justify-between gap-2">
                                            <!-- Home Team -->
                                            <div class="flex flex-col items-center w-1/3">
                                                <div class="mb-1 avatar placeholder">
                                                    <div class="flex items-center justify-center w-12 h-12 mask mask-squircle bg-base-200">
                                                        @if($fixture->homeTeam->logo_path)
                                                            <img src="{{ asset('storage/'.$fixture->homeTeam->logo_path) }}" alt="{{ $fixture->homeTeam->name }} logo" class="object-contain w-8 h-8">
                                                        @else
                                                            <span class="text-xs">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <span class="text-sm font-medium text-center">{{ $fixture->homeTeam->short_name }}</span>
                                            </div>
                                            <!-- Score -->
                                            <div class="flex flex-col items-center w-1/3">
                                                <div class="text-xl font-bold text-error">{{ $fixture->home_score }} - {{ $fixture->away_score }}</div>
                                                <div class="text-[12px] text-base-content/70 mt-1">
                                                    @if($fixture->status === 'live')
                                                        LIVE
                                                    @else
                                                        {{ $fixture->kickoff_time->format('H:i') }}
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Away Team -->
                                            <div class="flex flex-col items-center w-1/3">
                                                <div class="mb-1 avatar placeholder">
                                                    <div class="flex items-center justify-center w-12 h-12 mask mask-squircle bg-base-200">
                                                        @if($fixture->awayTeam->logo_path)
                                                            <img src="{{ asset('storage/'.$fixture->awayTeam->logo_path) }}" alt="{{ $fixture->awayTeam->name }} logo" class="object-contain w-8 h-8">
                                                        @else
                                                            <span class="text-xs">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <span class="text-sm font-medium text-center">{{ $fixture->awayTeam->short_name }}</span>
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
                <div class="p-0 card-body">
                    <div class="px-5 py-4 border-primary/20 divider">
                        <h2 class="font-semibold text-primary">Upcoming Matches</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-2">
                        @forelse($upcomingFixtures as $fixture)
                            <a href="{{ route('fixtures.show', $fixture->id) }}" class="transition-all duration-300 card bg-base-100 hover:shadow-lg">
                                <div class="p-4 card-body">
                                    <div class="flex items-center justify-between mb-3 text-[13px] text-base-content/70">
                                        <span class="badge badge-sm badge-secondary">{{ $fixture->league->name }}</span>
                                        <span>{{ $fixture->kickoff_time->format('M j, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-2">
                                        <!-- Home Team -->
                                        <div class="flex flex-col items-center w-1/3">
                                            <div class="mb-1 avatar placeholder">
                                                <div class="flex items-center justify-center w-12 h-12 mask mask-squircle bg-base-200">
                                                    @if($fixture->homeTeam->logo_path)
                                                        <img src="{{ asset('storage/'.$fixture->homeTeam->logo_path) }}" alt="{{ $fixture->homeTeam->name }} logo" class="object-contain w-8 h-8">
                                                    @else
                                                        <span class="text-xs">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="text-xs text-base-content/60">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                                            <span class="font-medium text-center">{{ $fixture->homeTeam->name }}</span>
                                        </div>
                                        <!-- VS -->
                                        <div class="flex flex-col items-center w-1/3">
                                            <div class="font-bold text-base-content/70">VS</div>
                                            <div class="mt-2 text-[13px] text-base-content/70 text-center">
                                                <span class="badge badge-outline badge-sm">{{ $fixture->kickoff_time->format('g:i A') }}</span>
                                                <div>{{ $fixture->venue }}</div>
                                            </div>
                                        </div>
                                        <!-- Away Team -->
                                        <div class="flex flex-col items-center w-1/3">
                                            <div class="mb-1 avatar placeholder">
                                                <div class="flex items-center justify-center w-12 h-12 mask mask-squircle bg-base-200">
                                                    @if($fixture->awayTeam->logo_path)
                                                        <img src="{{ asset('storage/'.$fixture->awayTeam->logo_path) }}" alt="{{ $fixture->awayTeam->name }} logo" class="object-contain w-8 h-8">
                                                    @else
                                                        <span class="text-xs">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="text-xs text-base-content/60">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                                            <span class="font-medium text-center">{{ $fixture->awayTeam->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-2 py-10 text-center text-base-content/70">No upcoming matches scheduled.</div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN: Aside (Top Standings + Quick Links + Premier League) -->
        <aside class="space-y-6">
            <!-- Top Standings -->
            <section class="card card-bordered bg-base-100">
                <div class="p-0 card-body">
                    <div class="px-5 py-4 ">
                        <h2 class="text-lg font-semibold">Top Standings</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-active table-bordered">
                            <thead>
                                <tr>
                                    <th>Pos</th>
                                    <th>Team</th>
                                    <th class="text-center">P</th>
                                    <th class="text-center">GD</th>
                                    <th class="text-center">Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topStandings as $index => $standing)
                                    <tr>
                                        <td>
                                            <span class="{{ $index < 4 ? 'text-success font-bold' : '' }}">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 mask mask-squircle">
                                                    @if($standing->team->logo_path)
                                                        <img src="{{ asset('storage/'.$standing->team->logo_path) }}" alt="{{ $standing->team->name }} logo" class="object-contain w-6 h-6">
                                                    @else
                                                        <span class="text-xs">{{ substr($standing->team->name, 0, 3) }}</span>
                                                    @endif
                                                </div>
                                                <span>{{ $standing->team->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $standing->played }}</td>
                                        <td class="text-center">{{ $standing->goal_difference }}</td>
                                        <td class="text-center font-semibold {{ $index < 4 ? 'text-success' : '' }}">{{ $standing->points }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No standings available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 text-sm text-center">
                        <a href="{{ route('standings') }}" class="font-medium text-primary hover:text-primary-focus">View Full Standings
                            →</a>
                    </div>
                </div>
            </section>

            <!-- Quick Links / Feature News -->
            <section class="card card-bordered bg-base-100">
                <div class="p-0 card-body">
                    <div class="px-5 py-4 border-base-content/10">
                        <h2 class="text-lg font-semibold">Feature News</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4 p-4 text-white">
                        @foreach($featureNews->take(5) as $news)
                            <a href="{{ route('news.show', $news->slug) }}" class="block w-full transition-all duration-200 card bg-accent image-full hover:shadow-lg">
                                <figure>
                                    @php
                                        $image = $news->featured_image && file_exists(public_path('storage/'.$news->featured_image))
                                            ? asset('storage/'.$news->featured_image)
                                            : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp';
                                    @endphp
                                    <img src="{{ $image }}" alt="{{ $news->title }}" class="object-cover w-full h-40">
                                </figure>
                                <div class="card-body">
                                    <h2 class="card-title text-base-200">{{ $news->title }}</h2>
                                    <p class="line-clamp-2 text-base-300">{{ $news->excerpt ?? Str::limit(strip_tags($news->content), 80) }}</p>
                                    <div class="justify-end card-actions">
                                        <span class="btn btn-primary btn-sm">Read More</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="px-4 py-3 text-sm text-center">
                        <a href="{{ route('teams.index') }}" class="font-medium text-primary hover:text-primary-focus">More News
                            →</a>
                    </div>
                </div>
            </section>

        </aside>
    </div>
</div>
