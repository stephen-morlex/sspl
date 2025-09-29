<div class="py-4 lg:py-6">
    <!-- Main grid: Left column (hero + live + news) and Right column (aside) -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- LEFT COLUMN: Hero + Live + News -->
        <div class="space-y-6 lg:col-span-2">
            <!-- HERO -->
            <section>
                <div class="shadow-sm card bg-gradient-to-r from-success to-warning text-base-100">
                    <div class="card-body">
                        <div
                            class="inline-flex items-center gap-2 bg-success/50 text-base-100 rounded-full w-32 px-3 h-7 text-[13px] mb-3">
                            <span class="w-2 h-2 rounded-full bg-error"></span>
                            Transfer Watch
                        </div>
                        <h1 class="mb-2 text-2xl font-semibold md:text-3xl lg:text-4xl text-base-content">VOTE: Who's the
                            BEST signing of the summer transfer window?</h1>
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
                <section class="shadow card bg-base-100">
                    <div class="p-0 card-body">
                        <div class="flex items-center gap-2 py-4 border-error/20">
                            <h2 class="text-3xl font-semibold text-base-content">Live Matches</h2>
                        </div>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach ($liveFixtures as $fixture)
                                <a href="{{ route('fixtures.show', $fixture->id) }}"
                                    class="transition-all duration-300 card bg-base-100 hover:shadow-lg">
                                    <div class="p-4 card-body">
                                        <div
                                            class="flex items-center justify-between mb-3 text-[13px] text-base-content/70">
                                            <span class="">{{ $fixture->league->name }}</span>
                                            <span class="badge badge-error badge-sm">LIVE</span>
                                        </div>
                                        <div class="flex items-center justify-between gap-2">
                                            <!-- Home Team -->
                                            <div class="flex flex-col items-center w-1/3">
                                                <div class="mb-1 avatar placeholder">
                                                    <div
                                                        class="flex items-center justify-center w-12 h-12 bg-base-200 mask mask-squircle">
                                                        @if ($fixture->homeTeam->logo_path)
                                                            <img src="{{ asset('storage/' . $fixture->homeTeam->logo_path) }}"
                                                                alt="{{ $fixture->homeTeam->name }} logo"
                                                                class="object-contain w-8 h-8">
                                                        @else
                                                            <span
                                                                class="text-xs text-base-content">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm font-medium text-center text-base-content">{{ $fixture->homeTeam->short_name }}</span>
                                            </div>
                                            <!-- Score -->
                                            <div class="flex flex-col items-center w-1/3">
                                                <div class="text-xl font-bold text-error">{{ $fixture->home_score }} -
                                                    {{ $fixture->away_score }}</div>
                                                <div class="text-[12px] text-base-content/70 mt-1">
                                                    @if ($fixture->status === 'live')
                                                        LIVE
                                                    @else
                                                        {{ $fixture->kickoff_time->format('H:i') }}
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Away Team -->
                                            <div class="flex flex-col items-center w-1/3">
                                                <div class="mb-1 avatar placeholder">
                                                    <div
                                                        class="flex items-center justify-center w-12 h-12 bg-base-200 mask mask-squircle">
                                                        @if ($fixture->awayTeam->logo_path)
                                                            <img src="{{ asset('storage/' . $fixture->awayTeam->logo_path) }}"
                                                                alt="{{ $fixture->awayTeam->name }} logo"
                                                                class="object-contain w-8 h-8">
                                                        @else
                                                            <span
                                                                class="text-xs text-base-content">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm font-medium text-center text-base-content">{{ $fixture->awayTeam->short_name }}</span>
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
            <section class="">
                <div class="p-0 ">
                    <div class="py-4 border-primary/20">
                        <h2 class="text-3xl font-medium text-base-content">Upcoming Matches</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @forelse($upcomingFixtures as $fixture)
                            <a href="{{ route('fixtures.show', $fixture->id) }}"
                                class="transition-all duration-300 shadow card bg-base-100 hover:shadow-lg">
                                <div class="p-4 card-body">
                                    <div
                                        class="flex items-center justify-between mb-3 text-[13px] text-base-content/70">
                                        <span class="badge badge-primary badge-sm">{{ $fixture->league->name }}</span>
                                        <span
                                            class="text-base-content">{{ $fixture->kickoff_time->format('M j, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-2">
                                        <!-- Home Team -->
                                        <div class="flex flex-col items-center w-1/3">
                                            <div class="mb-1 avatar placeholder">
                                                <div
                                                    class="flex items-center justify-center w-12 h-12 bg-base-200 mask mask-squircle">
                                                    @if ($fixture->homeTeam->logo_path)
                                                        <img src="{{ asset('storage/' . $fixture->homeTeam->logo_path) }}"
                                                            alt="{{ $fixture->homeTeam->name }} logo"
                                                            class="object-contain w-8 h-8">
                                                    @else
                                                    @endif
                                                </div>
                                            </div>

                                            <span
                                                class="font-medium text-center text-base-content">{{ $fixture->homeTeam->name }}</span>
                                        </div>
                                        <!-- VS -->
                                        <div class="flex flex-col items-center w-1/3">
                                            <div class="font-bold text-base-content/70">VS</div>
                                            <div class="mt-2 text-[13px] text-base-content/70 text-center">
                                                <span
                                                    class="badge badge-outline badge-sm text-base-content">{{ $fixture->kickoff_time->format('g:i A') }}</span>
                                                <div class="text-base-content">{{ $fixture->venue }}</div>
                                            </div>
                                        </div>
                                        <!-- Away Team -->
                                        <div class="flex flex-col items-center w-1/3">
                                            <div class="mb-1 avatar placeholder">
                                                <div
                                                    class="flex items-center justify-center w-12 h-12 bg-base-200 mask mask-squircle">
                                                    @if ($fixture->awayTeam->logo_path)
                                                        <img src="{{ asset('storage/' . $fixture->awayTeam->logo_path) }}"
                                                            alt="{{ $fixture->awayTeam->name }} logo"
                                                            class="object-contain w-8 h-8">
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                            <span
                                                class="font-medium text-center text-base-content">{{ $fixture->awayTeam->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-2 py-10 text-center text-base-content/70">No upcoming matches
                                scheduled.</div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN: Aside (Top Standings + Quick Links + Premier League) -->
        <aside class="space-y-6">
            <!-- Top Standings -->
            <section class="shadow card bg-base-100">
                <div class="p-0 card-body">
                    <div class="px-5 py-4">
                        <h2 class="text-lg font-semibold text-base-content">Top Standings</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th class="text-base-content">Pos</th>
                                    <th class="text-base-content">Team</th>
                                    <th class="text-center text-base-content">P</th>
                                    <th class="text-center text-base-content">GD</th>
                                    <th class="text-center text-base-content">Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topStandings as $index => $standing)
                                    <tr>
                                        <td class="text-base-content">
                                            <span
                                                class="{{ $index < 4 ? 'text-success font-bold' : 'text-base-content' }}">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="text-base-content">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 mask mask-squircle">
                                                    @if ($standing->team->logo_path)
                                                        <img src="{{ asset('storage/' . $standing->team->logo_path) }}"
                                                            alt="{{ $standing->team->name }} logo"
                                                            class="object-contain w-6 h-6">
                                                    @else
                                                        <span
                                                            class="text-xs text-base-content">{{ substr($standing->team->name, 0, 3) }}</span>
                                                    @endif
                                                </div>
                                                <span class="text-base-content">{{ $standing->team->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center text-base-content">{{ $standing->played }}</td>
                                        <td class="text-center text-base-content">{{ $standing->goal_difference }}
                                        </td>
                                        <td
                                            class="text-center font-semibold text-base-content {{ $index < 4 ? 'text-success' : '' }}">
                                            {{ $standing->points }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-base-content">No standings
                                            available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 text-sm text-center">
                        <a href="{{ route('standings') }}" class="link link-primary">View Full Standings →</a>
                    </div>
                </div>
            </section>

            <!-- Feature News -->
            <section class="shadow card bg-base-100">
                <div class="p-0 card-body">
                    <div class="px-5 py-4">
                        <h2 class="text-lg font-semibold text-base-content">Feature News</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4 p-4">
                        @foreach ($featureNews->take(5) as $news)
                            <a href="{{ route('news.show', $news->slug) }}"
                                class="block w-full transition-all duration-200 card image-full hover:shadow-lg">
                                <figure>
                                    @php
                                        $image =
                                            $news->featured_image &&
                                            file_exists(public_path('storage/' . $news->featured_image))
                                                ? asset('storage/' . $news->featured_image)
                                                : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp';
                                    @endphp
                                    <img src="{{ $image }}" alt="{{ $news->title }}"
                                        class="object-cover w-full h-40">
                                </figure>
                                <div class="card-body">
                                    <h2 class="card-title text-base-100">{{ $news->title }}</h2>
                                    <p class="line-clamp-2 text-base-200">
                                        {{ $news->excerpt ?? Str::limit(strip_tags($news->content), 80) }}</p>
                                    <div class="justify-end card-actions">
                                        <span class="btn btn-primary btn-sm">Read More</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="px-4 py-3 text-sm text-center">
                        <a href="{{ route('news.index') }}" class="link link-primary">More News →</a>
                    </div>
                </div>
            </section>

        </aside>
    </div>
</div>
