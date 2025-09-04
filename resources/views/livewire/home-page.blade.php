<div class="py-4 lg:py-6">
    <!-- Top rail: Hero + Right news column -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- HERO (left, spans 2) -->
        <section class="lg:col-span-2">
            <div class="relative overflow-hidden rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.06)] bg-white">
                <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(1200px_400px_at_-10%_-50%,#5a00a1_0%,#37003c_40%,transparent_60%)] opacity-30"></div>
                <div class="relative p-6 md:p-8">
                    <div class="inline-flex items-center gap-2 text-white bg-[#37003c] rounded-full px-3 h-7 text-[13px] mb-3">
                        <span class="h-2 w-2 rounded-full bg-[#E11D48]"></span>
                        Transfer Watch
                    </div>
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-[#1b1b18] mb-2">VOTE: Who's the BEST signing of the summer transfer window?</h1>
                    <p class="text-[#6b7280] mb-5">From Gyokeres to Mbeumo, take your pick from standout transfers this summer.</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="#" class="inline-flex items-center h-10 px-4 rounded-full bg-[#37003c] text-white text-sm hover:opacity-90">Vote now</a>
                        <a href="#" class="inline-flex items-center h-10 px-4 rounded-full border border-black/10 text-sm hover:bg-black/5">See all transfers</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- RIGHT NEWS RAIL -->
        <aside class="space-y-4">
            <div class="bg-white rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.06)] overflow-hidden">
                <div class="px-4 py-3 border-b border-black/5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold">Premier League</h3>
                        <a href="#" class="text-[13px] text-[#6b7280] hover:underline">View all matches</a>
                    </div>
                </div>
                <ul class="divide-y divide-black/5">
                    <li class="px-4 py-3 text-sm flex items-center justify-between">
                        <span class="text-[#6b7280]">Sat 13 Sep</span>
                        <span class="text-[#6b7280]">All times local</span>
                    </li>
                    @foreach($upcomingFixtures->take(5) as $f)
                        <li class="px-4 py-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium">{{ $f->homeTeam->name }}</span>
                                    <span class="text-[#6b7280]">vs</span>
                                    <span class="font-medium">{{ $f->awayTeam->name }}</span>
                                </div>
                                <div class="text-sm text-[#6b7280]">{{ $f->kickoff_time->format('H:i') }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>

    <!-- Middle rail: Headlines left (live + news) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @if($liveFixtures->isNotEmpty())
                <section class="bg-white rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.06)] overflow-hidden">
                    <div class="px-5 py-4 border-b border-black/5 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#E11D48] animate-pulse"></span>
                        <h2 class="text-lg font-semibold">Live Matches</h2>
                    </div>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($liveFixtures as $fixture)
                            <article class="rounded-lg border border-black/5 p-4 hover:bg-black/2 transition-colors">
                                <div class="flex items-center justify-between text-[13px] text-[#6b7280] mb-2">
                                    <span>{{ $fixture->league->name }}</span>
                                    <span class="inline-flex items-center px-2 h-5 rounded-full text-xs bg-[#fee2e2] text-[#991b1b]">LIVE</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gray-200"></div>
                                        <span class="font-medium">{{ $fixture->homeTeam->name }}</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-semibold">{{ $fixture->home_score }} - {{ $fixture->away_score }}</div>
                                        <div class="text-[12px] text-[#6b7280] mt-1">{{ $fixture->kickoff_time->format('H:i') }}</div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-medium">{{ $fixture->awayTeam->name }}</span>
                                        <div class="w-10 h-10 rounded-xl bg-gray-200"></div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="bg-white rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.06)] overflow-hidden">
                <div class="px-5 py-4 border-b border-black/5">
                    <h2 class="text-lg font-semibold">Upcoming Matches</h2>
                </div>
                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($upcomingFixtures as $fixture)
                        <article class="rounded-lg border border-black/5 p-4 hover:bg-black/2 transition-colors">
                            <div class="flex items-center justify-between mb-2 text-[13px] text-[#6b7280]">
                                <span>{{ $fixture->league->name }}</span>
                                <span>{{ $fixture->kickoff_time->format('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gray-200"></div>
                                    <span class="font-medium">{{ $fixture->homeTeam->name }}</span>
                                </div>
                                <div class="text-[#6b7280]">VS</div>
                                <div class="flex items-center gap-3">
                                    <span class="font-medium">{{ $fixture->awayTeam->name }}</span>
                                    <div class="w-10 h-10 rounded-xl bg-gray-200"></div>
                                </div>
                            </div>
                            <div class="mt-2 text-[13px] text-[#6b7280] text-center">{{ $fixture->kickoff_time->format('g:i A') }} at {{ $fixture->venue }}</div>
                        </article>
                    @empty
                        <div class="text-center py-10 text-[#6b7280]">No upcoming matches scheduled.</div>
                    @endforelse
                </div>
            </section>
        </div>

        <!-- Right Column: Standings + Quick links -->
        <div class="space-y-6">
            <section class="bg-white rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.06)] overflow-hidden">
                <div class="px-5 py-4 border-b border-black/5">
                    <h2 class="text-lg font-semibold">Top Standings</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-xs text-[#6b7280]">
                                <th class="px-4 py-3 text-left">Pos</th>
                                <th class="px-4 py-3 text-left">Team</th>
                                <th class="px-4 py-3 text-center">P</th>
                                <th class="px-4 py-3 text-center">Pts</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/5">
                            @forelse($topStandings as $standing)
                                <tr class="{{ $standing->position <= 4 ? 'bg-blue-50' : 'bg-white' }}">
                                    <td class="px-4 py-3 text-sm font-medium">
                                        <span class="{{ $standing->position <= 4 ? 'text-green-600' : 'text-[#1b1b18]' }}">{{ $standing->position }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 rounded-lg bg-gray-200 mr-2"></div>
                                            <span class="text-sm font-medium">{{ $standing->team->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-[#6b7280]">{{ $standing->played }}</td>
                                    <td class="px-4 py-3 text-center text-sm font-semibold {{ $standing->position <= 4 ? 'text-green-600' : '' }}">{{ $standing->points }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-sm text-[#6b7280]">No standings available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 bg-gray-50 border-t border-black/5 text-center text-sm">
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View Full Standings →</a>
                </div>
            </section>

            <section class="bg-white rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.06)] overflow-hidden">
                <div class="px-5 py-4 border-b border-black/5">
                    <h2 class="text-lg font-semibold">Quick Links</h2>
                </div>
                <div class="p-4 grid grid-cols-2 gap-3">
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="bg-blue-100 p-3 rounded-full mb-2"></div>
                        <span class="text-sm font-medium">Teams</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="bg-green-100 p-3 rounded-full mb-2"></div>
                        <span class="text-sm font-medium">Players</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="bg-purple-100 p-3 rounded-full mb-2"></div>
                        <span class="text-sm font-medium">Standings</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="bg-yellow-100 p-3 rounded-full mb-2"></div>
                        <span class="text-sm font-medium">Fixtures</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>
