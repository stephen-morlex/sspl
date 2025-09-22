<div class="px-4 py-6 mx-auto max-w-7xl" wire:poll.5s="loadData">

    <!-- Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-[-20px]"
        @notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
        class="fixed z-50 top-4 right-4">
        <div :class="{
            'bg-green-100 border-green-400 text-green-700': type === 'success',
            'bg-red-100 border-red-400 text-red-700': type === 'error',
            'bg-blue-100 border-blue-400 text-blue-700': type === 'info'
        }"
            class="relative px-4 py-3 rounded" role="alert">
            <span class="block sm:inline" x-text="message"></span>
        </div>
    </div>

    <!-- Match Header -->
    <div class="p-6 mb-6 bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $fixture->league->name }}
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $fixture->kickoff_time->format('M d, Y H:i') }}
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-16 h-16 mr-4 bg-gray-200 rounded-full dark:bg-gray-700">
                    @if ($fixture->homeTeam->logo_path)
                        <img src="{{ asset('storage/' . $fixture->homeTeam->logo_path) }}"
                            alt="{{ $fixture->homeTeam->name }}" class="w-12 h-12">
                    @else
                        <span class="text-xl font-bold">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold">{{ $fixture->homeTeam->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $fixture->homeTeam->city }}</p>
                </div>
            </div>

            <div class="text-center">
                <div class="text-3xl font-bold">
                    {{ $fixture->home_score }} - {{ $fixture->away_score }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    @if ($fixture->status === 'live')
                        <span class="font-bold text-red-500">LIVE</span>
                    @else
                        {{ strtoupper($fixture->status->value ?? (string) $fixture->status) }}
                    @endif
                </div>
            </div>

            <div class="flex items-center">
                <div class="mr-4 text-right">
                    <h3 class="text-lg font-bold">{{ $fixture->awayTeam->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $fixture->awayTeam->city }}</p>
                </div>
                <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full dark:bg-gray-700">
                    @if ($fixture->awayTeam->logo_path)
                        <img src="{{ asset('storage/' . $fixture->awayTeam->logo_path) }}"
                            alt="{{ $fixture->awayTeam->name }}" class="w-12 h-12">
                    @else
                        <span class="text-xl font-bold">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
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
        <div class="p-6 mb-6 bg-white rounded-lg shadow tab-content dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-bold">Match Events</h3>
            @php
                // Merge and sort all events by minute
                $allEvents = collect($events['home'])->merge($events['away'])->sortBy('minute');
            @endphp

            @if ($allEvents->isEmpty())
                <div class="py-8 text-center text-gray-500">
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
                                        <div class="max-w-xs p-3 text-right shadow bg-base-100 rounded-box">
                                            <div class="flex items-center justify-end gap-2">
                                                <span class="font-bold text-primary">{{ $event->minute }}'</span>
                                                @if ($event->event_type === 'goal')
                                                    <span
                                                        class="flex items-center justify-center inline-block w-5 h-5 bg-green-500 rounded-full">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </span>
                                                @elseif($event->event_type === 'yellow_card')
                                                    <span class="inline-block w-5 h-5 bg-yellow-500 rounded"></span>
                                                @elseif($event->event_type === 'red_card')
                                                    <span class="inline-block w-5 h-5 bg-red-500 rounded"></span>
                                                @else
                                                    <span class="inline-block w-5 h-5 bg-gray-300 rounded"></span>
                                                @endif
                                            </div>
                                            <div class="font-medium">
                                                @if ($event->player)
                                                    {{ $event->player->first_name }} {{ $event->player->last_name }}
                                                @else
                                                    {{ $event->team->name }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 capitalize">
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
                                        <div class="max-w-xs p-3 text-left shadow bg-base-100 rounded-box">
                                            <div class="flex items-center gap-2">
                                                @if ($event->event_type === 'goal')
                                                    <span
                                                        class="flex items-center justify-center inline-block w-5 h-5 bg-green-500 rounded-full">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </span>
                                                @elseif($event->event_type === 'yellow_card')
                                                    <span class="inline-block w-5 h-5 bg-yellow-500 rounded"></span>
                                                @elseif($event->event_type === 'red_card')
                                                    <span class="inline-block w-5 h-5 bg-red-500 rounded"></span>
                                                @else
                                                    <span class="inline-block w-5 h-5 bg-gray-300 rounded"></span>
                                                @endif
                                                <span class="font-bold text-accent">{{ $event->minute }}'</span>
                                            </div>
                                            <div class="font-medium">
                                                @if ($event->player)
                                                    {{ $event->player->first_name }} {{ $event->player->last_name }}
                                                @else
                                                    {{ $event->team->name }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 capitalize">
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
        <!-- Team Stats -->
        <div class="grid grid-cols-1 gap-6 mb-6 tab-content md:grid-cols-2">
            <!-- Home Team Stats -->
            <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-bold">{{ $fixture->homeTeam->name }} Stats</h3>

                @if ($homeTeamStats)
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->goals_for ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Goals</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->shots ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Shots</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->possession ?? 0 }}%</div>
                            <div class="text-sm text-gray-500">Possession</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->corners ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Corners</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->fouls_committed ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Fouls</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->yellow_cards ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Yellow Cards</div>
                        </div>
                    </div>
                @else
                    <div class="py-4 text-center text-gray-500">
                        No stats available yet.
                    </div>
                @endif
            </div>

            <!-- Away Team Stats -->
            <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-bold">{{ $fixture->awayTeam->name }} Stats</h3>

                @if ($awayTeamStats)
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->goals_for ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Goals</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->shots ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Shots</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->possession ?? 0 }}%</div>
                            <div class="text-sm text-gray-500">Possession</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->corners ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Corners</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->fouls_committed ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Fouls</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->yellow_cards ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Yellow Cards</div>
                        </div>
                    </div>
                @else
                    <div class="py-4 text-center text-gray-500">
                        No stats available yet.
                    </div>
                @endif
            </div>
        </div>

        <label class="tab">
            <input type="radio" name="match_tabs" class="tab-input" />
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Lineups
        </label>
        <!-- Player Stats -->
        <div class="p-6 bg-white rounded-lg shadow tab-content dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-bold">Player Statistics</h3>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Home Team Players -->
                <div>
                    <h4 class="mb-3 font-bold">{{ $fixture->homeTeam->name }}</h4>

                    @if ($homePlayerStats->isEmpty())
                        <div class="py-4 text-center text-gray-500">
                            No player stats available yet.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table w-full table-zebra">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>G</th>
                                        <th>A</th>
                                        <th>S</th>
                                        <th>YC</th>
                                        <th>RC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($homePlayerStats as $stat)
                                        <tr>
                                            <td>
                                                <div class="flex items-center">
                                                    <div class="mr-2 avatar placeholder">
                                                        <div
                                                            class="w-8 rounded-full bg-neutral-focus text-neutral-content">
                                                            <span
                                                                class="text-xs">{{ substr($stat->player->first_name, 0, 1) }}{{ substr($stat->player->last_name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <span>{{ $stat->player->first_name }}
                                                        {{ $stat->player->last_name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $stat->goals ?? 0 }}</td>
                                            <td>{{ $stat->assists ?? 0 }}</td>
                                            <td>{{ $stat->shots ?? 0 }}</td>
                                            <td>{{ $stat->yellow_cards ?? 0 }}</td>
                                            <td>{{ $stat->red_cards ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Away Team Players -->
                <div>
                    <h4 class="mb-3 font-bold">{{ $fixture->awayTeam->name }}</h4>

                    @if ($awayPlayerStats->isEmpty())
                        <div class="py-4 text-center text-gray-500">
                            No player stats available yet.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table w-full table-zebra">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>G</th>
                                        <th>A</th>
                                        <th>S</th>
                                        <th>YC</th>
                                        <th>RC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($awayPlayerStats as $stat)
                                        <tr>
                                            <td>
                                                <div class="flex items-center">
                                                    <div class="mr-2 avatar placeholder">
                                                        <div
                                                            class="w-8 rounded-full bg-neutral-focus text-neutral-content">
                                                            <span
                                                                class="text-xs">{{ substr($stat->player->first_name, 0, 1) }}{{ substr($stat->player->last_name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <span>{{ $stat->player->first_name }}
                                                        {{ $stat->player->last_name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $stat->goals ?? 0 }}</td>
                                            <td>{{ $stat->assists ?? 0 }}</td>
                                            <td>{{ $stat->shots ?? 0 }}</td>
                                            <td>{{ $stat->yellow_cards ?? 0 }}</td>
                                            <td>{{ $stat->red_cards ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
