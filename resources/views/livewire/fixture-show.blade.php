<div class="px-4 py-6 mx-auto max-w-4xl" wire:poll.5s="loadData">

    <!-- Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-[-20px]"
        @notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
        class="fixed z-50 top-4 right-4">
        <div x-show="show" :class="{
            'alert alert-success': type === 'success',
            'alert alert-error': type === 'error',
            'alert alert-info': type === 'info'
        }" class="relative px-4 py-3" role="alert">
            <span class="block sm:inline" x-text="message"></span>
        </div>
    </div>

    <!-- Match Header -->
    <div class="p-6 mb-6 card bg-base-100 shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="text-sm text-base-content/70">
                {{ $fixture->league->name }}
            </div>
            <div class="text-sm text-base-content/70">
                {{ $fixture->kickoff_time->format('M d, Y H:i') }}
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-16 h-16 mr-4 bg-base-200 rounded-full">
                    @if ($fixture->homeTeam->logo_path)
                        <img src="{{ asset('storage/' . $fixture->homeTeam->logo_path) }}"
                            alt="{{ $fixture->homeTeam->name }}" class="w-12 h-12">
                    @else
                        <span class="text-xl font-bold text-base-content">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-base-content">{{ $fixture->homeTeam->name }}</h3>
                    <p class="text-sm text-base-content/70">{{ $fixture->homeTeam->city }}</p>
                </div>
            </div>

            <div class="text-center">
                <div class="text-3xl font-bold text-base-content">
                    {{ $fixture->home_score }} - {{ $fixture->away_score }}
                </div>
                <div class="text-sm text-base-content/70">
                    @if ($fixture->status === 'live')
                        <span class="font-bold text-error">LIVE</span>
                    @else
                        {{ strtoupper($fixture->status->value ?? (string) $fixture->status) }}
                    @endif
                </div>
            </div>

            <div class="flex items-center">
                <div class="mr-4 text-right">
                    <h3 class="text-lg font-bold text-base-content">{{ $fixture->awayTeam->name }}</h3>
                    <p class="text-sm text-base-content/70">{{ $fixture->awayTeam->city }}</p>
                </div>
                <div class="flex items-center justify-center w-16 h-16 bg-base-200 rounded-full">
                    @if ($fixture->awayTeam->logo_path)
                        <img src="{{ asset('storage/' . $fixture->awayTeam->logo_path) }}"
                            alt="{{ $fixture->awayTeam->name }}" class="w-12 h-12">
                    @else
                        <span class="text-xl font-bold text-base-content">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6 tabs tabs-lifted tabs-lg">
        <label class="tab">
            <input type="radio" name="match_tabs" class="tab-input" checked />
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Timeline
        </label>
        <!-- Timeline/Events -->
        <div class="p-6 mb-6 card bg-base-100 shadow tab-content">
            <h3 class="mb-4 text-xl font-bold text-base-content">Match Events</h3>
            @php
                // Merge and sort all events by minute
                $allEvents = collect($events['home'])->merge($events['away'])->sortBy('minute');
            @endphp

            @if ($allEvents->isEmpty())
                <div class="py-8 text-center text-base-content/70">
                    No events recorded yet.
                </div>
            @else
                <div class="relative">
                    <!-- Vertical line -->
                    <div class="absolute top-0 bottom-0 w-1 -translate-x-1/2 left-1/2 bg-base-200"></div>
                    <div class="space-y-6">
                        @foreach ($allEvents as $event)
                            @php
                                $isHome = $event->team_id == $fixture->home_team_id;
                            @endphp
                            <div class="flex items-center w-full">
                                @if ($isHome)
                                    <!-- Home event left -->
                                    <div class="flex justify-end flex-1 pr-6">
                                        <div class="max-w-xs p-3 text-right bg-base-100 rounded-box shadow">
                                            <div class="flex items-center justify-end gap-2">
                                                <span class="font-bold text-primary">{{ $event->minute }}'</span>
                                                @if ($event->event_type === 'goal')
                                                    <span
                                                        class="flex items-center justify-center inline-block w-5 h-5 bg-success rounded-full">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </span>
                                                @elseif($event->event_type === 'yellow_card')
                                                    <span class="inline-block w-5 h-5 bg-warning rounded"></span>
                                                @elseif($event->event_type === 'red_card')
                                                    <span class="inline-block w-5 h-5 bg-error rounded"></span>
                                                @else
                                                    <span class="inline-block w-5 h-5 bg-neutral rounded"></span>
                                                @endif
                                            </div>
                                            <div class="font-medium text-base-content">
                                                @if ($event->player)
                                                    {{ $event->player->first_name }} {{ $event->player->last_name }}
                                                @else
                                                    {{ $event->team->name }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-base-content/70 capitalize">
                                                {{ str_replace('_', ' ', $event->event_type) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-center w-1/12">
                                        <!-- Timeline dot -->
                                        <div class="w-4 h-4 border-2 border-white rounded-full bg-primary"></div>
                                    </div>
                                    <div class="flex-1"></div>
                                @else
                                    <div class="flex-1"></div>
                                    <div class="flex justify-center w-1/12">
                                        <!-- Timeline dot -->
                                        <div class="w-4 h-4 border-2 border-white rounded-full bg-accent"></div>
                                    </div>
                                    <!-- Away event right -->
                                    <div class="flex justify-start flex-1 pl-6">
                                        <div class="max-w-xs p-3 text-left bg-base-100 rounded-box shadow">
                                            <div class="flex items-center gap-2">
                                                @if ($event->event_type === 'goal')
                                                    <span
                                                        class="flex items-center justify-center inline-block w-5 h-5 bg-success rounded-full">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </span>
                                                @elseif($event->event_type === 'yellow_card')
                                                    <span class="inline-block w-5 h-5 bg-warning rounded"></span>
                                                @elseif($event->event_type === 'red_card')
                                                    <span class="inline-block w-5 h-5 bg-error rounded"></span>
                                                @else
                                                    <span class="inline-block w-5 h-5 bg-neutral rounded"></span>
                                                @endif
                                                <span class="font-bold text-accent">{{ $event->minute }}'</span>
                                            </div>
                                            <div class="font-medium text-base-content">
                                                @if ($event->player)
                                                    {{ $event->player->first_name }} {{ $event->player->last_name }}
                                                @else
                                                    {{ $event->team->name }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-base-content/70 capitalize">
                                                {{ str_replace('_', ' ', $event->event_type) }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <label class="tab">
            <input type="radio" name="match_tabs" class="tab-input" />
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Stats
        </label>


        <label class="tab">
            <input type="radio" name="match_tabs" class="tab-input" />
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Lineups
        </label>
        <!-- Lineups -->
        <div class="p-6 card bg-base-100 shadow tab-content">
            <h3 class="mb-4 text-xl font-bold text-base-content">Team Lineups</h3>

            <div class="flex flex-col">
                <!-- Teams Info Header -->
                <div class="flex justify-between mb-6">
                    <!-- Away Team Info -->
                    <div class="flex flex-col items-center w-1/2">
                        <div class="flex items-center justify-center w-16 h-16 mb-2 bg-base-200 rounded-full">
                            @if ($fixture->awayTeam->logo_path)
                                <img src="{{ asset('storage/' . $fixture->awayTeam->logo_path) }}"
                                    alt="{{ $fixture->awayTeam->name }}" class="w-12 h-12">
                            @else
                                <span class="text-xl font-bold text-base-content">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                            @endif
                        </div>
                        <h2 class="text-lg font-bold text-center text-base-content">{{ $fixture->awayTeam->name }}</h2>
                        @if(isset($awayLineup) && $awayLineup)
                            <p class="text-sm text-base-content/70">Formation: {{ $awayLineup->formation ?? 'N/A' }}</p>
                        @endif
                    </div>

                    <!-- VS Separator -->
                    <div class="flex items-center justify-center">
                        <span class="text-2xl font-bold text-base-content">VS</span>
                    </div>

                    <!-- Home Team Info -->
                    <div class="flex flex-col items-center w-1/2">
                        <div class="flex items-center justify-center w-16 h-16 mb-2 bg-base-200 rounded-full">
                            @if ($fixture->homeTeam->logo_path)
                                <img src="{{ asset('storage/' . $fixture->homeTeam->logo_path) }}"
                                    alt="{{ $fixture->homeTeam->name }}" class="w-12 h-12">
                            @else
                                <span class="text-xl font-bold text-base-content">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                            @endif
                        </div>
                        <h2 class="text-lg font-bold text-center text-base-content">{{ $fixture->homeTeam->name }}</h2>
                        @if(isset($homeLineup) && $homeLineup)
                            <p class="text-sm text-base-content/70">Formation: {{ $homeLineup->formation ?? 'N/A' }}</p>
                        @endif
                    </div>
                </div>

                <!-- Lineup Field -->
                <div class="relative bg-success rounded-2xl p-6 mb-6" style="min-height: 500px;">
                    <!-- Football Field Lines -->
                    <div class="absolute inset-0 rounded-2xl border-4 border-white opacity-30">
                        <!-- Center circle -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 rounded-full border-2 border-white"></div>
                        <!-- Center spot -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full"></div>
                        <!-- Center line -->
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-1 h-full bg-white"></div>
                        <!-- Penalty areas -->
                        <div class="absolute top-0 left-0 w-1/4 h-1/3 border-2 border-white border-t-0 border-l-0"></div>
                        <div class="absolute bottom-0 left-0 w-1/4 h-1/3 border-2 border-white border-b-0 border-l-0"></div>
                        <div class="absolute top-0 right-0 w-1/4 h-1/3 border-2 border-white border-t-0 border-r-0"></div>
                        <div class="absolute bottom-0 right-0 w-1/4 h-1/3 border-2 border-white border-b-0 border-r-0"></div>
                    </div>

                    <!-- Players Layout -->
                    <div class="relative z-10 flex justify-between h-full">
                        <!-- Away Team (Left Side) -->
                        <div class="w-1/2 pr-4">
                            @if(isset($awayLineup) && $awayLineup)
                                @php
                                    // Group players by position
                                    $awayPlayers = $awayLineup->startingPlayerDetails->sortBy('player.shirt_number');
                                    $awayGoalkeepers = $awayPlayers->filter(fn($lp) => $lp->player->position === 'GK');
                                    $awayDefenders = $awayPlayers->filter(fn($lp) => $lp->player->position === 'DEF');
                                    $awayMidfielders = $awayPlayers->filter(fn($lp) => $lp->player->position === 'MID');
                                    $awayForwards = $awayPlayers->filter(fn($lp) => $lp->player->position === 'FWD');
                                @endphp

                                <!-- Away Formation Players - Horizontal by Position -->
                                <div class="flex flex-col justify-between h-full">
                                    <!-- Away Goalkeeper -->
                                    <div class="flex justify-start mt-4">
                                        @foreach($awayGoalkeepers as $lineupPlayer)
                                            <div class="text-center mx-2">
                                                <div class="bg-success rounded-full w-12 h-12 flex items-center justify-center font-bold border-2 border-white text-white">
                                                    {{ $lineupPlayer->player->shirt_number }}
                                                </div>
                                                <p class="text-xs mt-1 text-white">{{ substr($lineupPlayer->player->last_name, 0, 8) }}</p>
                                                <p class="text-xs text-white opacity-75">GK</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Away Defenders -->
                                    <div class="flex justify-center my-2">
                                        @foreach($awayDefenders as $lineupPlayer)
                                            <div class="text-center mx-2">
                                                <div class="bg-warning rounded-full w-12 h-12 flex items-center justify-center font-bold border-2 border-white text-white">
                                                    {{ $lineupPlayer->player->shirt_number }}
                                                </div>
                                                <p class="text-xs mt-1 text-white">{{ substr($lineupPlayer->player->last_name, 0, 8) }}</p>
                                                <p class="text-xs text-white opacity-75">DEF</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Away Midfielders -->
                                    <div class="flex justify-center my-2">
                                        @foreach($awayMidfielders as $lineupPlayer)
                                            <div class="text-center mx-2">
                                                <div class="bg-primary rounded-full w-12 h-12 flex items-center justify-center font-bold border-2 border-white text-white">
                                                    {{ $lineupPlayer->player->shirt_number }}
                                                </div>
                                                <p class="text-xs mt-1 text-white">{{ substr($lineupPlayer->player->last_name, 0, 8) }}</p>
                                                <p class="text-xs text-white opacity-75">MID</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Away Forwards -->
                                    <div class="flex justify-center mb-4">
                                        @foreach($awayForwards as $lineupPlayer)
                                            <div class="text-center mx-2">
                                                <div class="bg-error rounded-full w-12 h-12 flex items-center justify-center font-bold border-2 border-white text-white">
                                                    {{ $lineupPlayer->player->shirt_number }}
                                                </div>
                                                <p class="text-xs mt-1 text-white">{{ substr($lineupPlayer->player->last_name, 0, 8) }}</p>
                                                <p class="text-xs text-white opacity-75">FWD</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <p class="text-white">Lineup not available</p>
                                </div>
                            @endif
                        </div>

                        <!-- Home Team (Right Side) -->
                        <div class="w-1/2 pl-4">
                            @if(isset($homeLineup) && $homeLineup)
                                @php
                                    // Group players by position
                                    $homePlayers = $homeLineup->startingPlayerDetails->sortBy('player.shirt_number');
                                    $homeGoalkeepers = $homePlayers->filter(fn($lp) => $lp->player->position === 'GK');
                                    $homeDefenders = $homePlayers->filter(fn($lp) => $lp->player->position === 'DEF');
                                    $homeMidfielders = $homePlayers->filter(fn($lp) => $lp->player->position === 'MID');
                                    $homeForwards = $homePlayers->filter(fn($lp) => $lp->player->position === 'FWD');
                                @endphp

                                <!-- Home Formation Players - Horizontal by Position -->
                                <div class="flex flex-col justify-between h-full">
                                    <!-- Home Goalkeeper -->
                                    <div class="flex justify-end mt-4">
                                        @foreach($homeGoalkeepers as $lineupPlayer)
                                            <div class="text-center mx-2">
                                                <div class="bg-success rounded-full w-12 h-12 flex items-center justify-center font-bold border-2 border-white text-white">
                                                    {{ $lineupPlayer->player->shirt_number }}
                                                </div>
                                                <p class="text-xs mt-1 text-white">{{ substr($lineupPlayer->player->last_name, 0, 8) }}</p>
                                                <p class="text-xs text-white opacity-75">GK</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Home Defenders -->
                                    <div class="flex justify-center my-2">
                                        @foreach($homeDefenders as $lineupPlayer)
                                            <div class="text-center mx-2">
                                                <div class="bg-warning rounded-full w-12 h-12 flex items-center justify-center font-bold border-2 border-white text-white">
                                                    {{ $lineupPlayer->player->shirt_number }}
                                                </div>
                                                <p class="text-xs mt-1 text-white">{{ substr($lineupPlayer->player->last_name, 0, 8) }}</p>
                                                <p class="text-xs text-white opacity-75">DEF</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Home Midfielders -->
                                    <div class="flex justify-center my-2">
                                        @foreach($homeMidfielders as $lineupPlayer)
                                            <div class="text-center mx-2">
                                                <div class="bg-primary rounded-full w-12 h-12 flex items-center justify-center font-bold border-2 border-white text-white">
                                                    {{ $lineupPlayer->player->shirt_number }}
                                                </div>
                                                <p class="text-xs mt-1 text-white">{{ substr($lineupPlayer->player->last_name, 0, 8) }}</p>
                                                <p class="text-xs text-white opacity-75">MID</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Home Forwards -->
                                    <div class="flex justify-center mb-4">
                                        @foreach($homeForwards as $lineupPlayer)
                                            <div class="text-center mx-2">
                                                <div class="bg-error rounded-full w-12 h-12 flex items-center justify-center font-bold border-2 border-white text-white">
                                                    {{ $lineupPlayer->player->shirt_number }}
                                                </div>
                                                <p class="text-xs mt-1 text-white">{{ substr($lineupPlayer->player->last_name, 0, 8) }}</p>
                                                <p class="text-xs text-white opacity-75">FWD</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <p class="text-white">Lineup not available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Bench Players -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Away Team Bench -->
                    <div>
                        <h4 class="mb-3 text-lg font-bold text-base-content">Away Team Bench</h4>
                        @if(isset($awayLineup) && $awayLineup && $awayLineup->benchPlayerDetails->count() > 0)
                            <div class="grid grid-cols-5 gap-2">
                                @foreach($awayLineup->benchPlayerDetails->take(10) as $lineupPlayer)
                                    <div class="text-center">
                                        <div class="bg-base-300 rounded-full w-10 h-10 flex items-center justify-center font-bold text-xs border border-white">
                                            {{ $lineupPlayer->player->shirt_number }}
                                        </div>
                                        <p class="text-xs mt-1 text-base-content">{{ substr($lineupPlayer->player->last_name, 0, 6) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-base-content/70">No bench players available</p>
                        @endif
                    </div>

                    <!-- Home Team Bench -->
                    <div>
                        <h4 class="mb-3 text-lg font-bold text-base-content">Home Team Bench</h4>
                        @if(isset($homeLineup) && $homeLineup && $homeLineup->benchPlayerDetails->count() > 0)
                            <div class="grid grid-cols-5 gap-2">
                                @foreach($homeLineup->benchPlayerDetails->take(10) as $lineupPlayer)
                                    <div class="text-center">
                                        <div class="bg-base-300 rounded-full w-10 h-10 flex items-center justify-center font-bold text-xs border border-white">
                                            {{ $lineupPlayer->player->shirt_number }}
                                        </div>
                                        <p class="text-xs mt-1 text-base-content">{{ substr($lineupPlayer->player->last_name, 0, 6) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-base-content/70">No bench players available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
