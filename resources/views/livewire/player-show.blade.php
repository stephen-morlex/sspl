<div class="py-6">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Player Header with Image Background -->
        <div class="w-full mb-8 card bg-gradient-to-r from-green to-success/50 image-full">
            @if ($player->photo_path)
                <figure>
                    <img src="{{ asset('storage/' . $player->photo_path) }}"
                        alt="{{ $player->first_name }} {{ $player->last_name }}" class="object-cover opacity-30" />
                </figure>
            @else
                <figure>
                    <div class="w-full h-full bg-gradient-to-br from-blue-900 to-purple-900 opacity-30"></div>
                </figure>
            @endif
            <div class="card-body">
                <div class="flex flex-col items-center gap-6 md:flex-row">
                    <div class="avatar">
                        <div class="w-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            @if ($player->photo_path)
                                <img src="{{ asset('storage/' . $player->photo_path) }}"
                                    alt="{{ $player->first_name }} {{ $player->last_name }}" />
                            @else
                                <div class="flex items-center justify-center w-full h-full rounded-full bg-base-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-base-content/30"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-center text-white md:text-left">
                        <div class="flex flex-wrap items-center justify-center gap-4 mb-2 md:justify-start">
                            <h1 class="text-4xl font-bold md:text-5xl">{{ $player->first_name }}
                                {{ $player->last_name }}</h1>
                            @if ($player->shirt_number)
                                <div class="badge badge-lg badge-primary">#{{ $player->shirt_number }}</div>
                            @endif
                        </div>

                        <div class="flex flex-wrap justify-center gap-6 mt-4 md:justify-start">
                            @if ($player->team)
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-8 rounded">
                                            @if ($player->team->logo_path)
                                                <img src="{{ asset('storage/' . $player->team->logo_path) }}"
                                                    alt="{{ $player->team->name }}" />
                                            @else
                                                <div
                                                    class="flex items-center justify-center w-full h-full rounded bg-base-300">
                                                    <span
                                                        class="text-sm">{{ substr($player->team->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-xl font-semibold">{{ $player->team->name }}</span>
                                </div>
                            @endif

                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-full bg-white/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <span class="text-xl font-semibold ">
                                    @switch($player->position)
                                        @case('GK')
                                            Goalkeeper
                                        @break

                                        @case('DEF')
                                            Defender
                                        @break

                                        @case('MID')
                                            Midfielder
                                        @break

                                        @case('FWD')
                                            Forward
                                        @break

                                        @default
                                            {{ $player->position }}
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Left Column: Career Statistics -->
            <div class="space-y-6 lg:col-span-2">
                <!-- Career Statistics Overview -->
                <div class="card bg-base-100 ">
                    <div class="p-0 card-body">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="text-lg card-title">Career Statistics</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                <div
                                    class="p-4 text-center text-white rounded-lg bg-gradient-to-br from-blue-500 to-blue-700">
                                    <div class="text-3xl font-bold">{{ $careerStats['goals'] }}</div>
                                    <div class="mt-1 text-sm">Goals</div>
                                </div>
                                <div
                                    class="p-4 text-center text-white rounded-lg bg-gradient-to-br from-green-500 to-green-700">
                                    <div class="text-3xl font-bold">{{ $careerStats['assists'] }}</div>
                                    <div class="mt-1 text-sm">Assists</div>
                                </div>
                                <div
                                    class="p-4 text-center text-white rounded-lg bg-gradient-to-br from-purple-500 to-purple-700">
                                    <div class="text-3xl font-bold">{{ $careerStats['matches_played'] }}</div>
                                    <div class="mt-1 text-sm">Matches</div>
                                </div>
                                <div
                                    class="p-4 text-center text-white rounded-lg bg-gradient-to-br from-yellow-500 to-yellow-700">
                                    <div class="text-3xl font-bold">{{ $careerStats['yellow_cards'] }}</div>
                                    <div class="mt-1 text-sm">Yellow Cards</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4 md:grid-cols-4">
                                <div
                                    class="p-4 text-center text-white rounded-lg bg-gradient-to-br from-red-500 to-red-700">
                                    <div class="text-3xl font-bold">{{ $careerStats['shots_on_goal'] }}</div>
                                    <div class="mt-1 text-sm">Shots on Goal</div>
                                </div>
                                <div
                                    class="p-4 text-center text-white rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-700">
                                    <div class="text-3xl font-bold">{{ $careerStats['tackles_won'] }}</div>
                                    <div class="mt-1 text-sm">Tackles Won</div>
                                </div>
                                <div
                                    class="p-4 text-center text-white rounded-lg bg-gradient-to-br from-cyan-500 to-cyan-700">
                                    <div class="text-3xl font-bold">{{ round($careerStats['distance_km'], 1) }}</div>
                                    <div class="mt-1 text-sm">Distance (km)</div>
                                </div>
                                <div
                                    class="p-4 text-center text-white rounded-lg bg-gradient-to-br from-pink-500 to-pink-700">
                                    <div class="text-3xl font-bold">{{ $careerStats['top_speed_kmh'] }}</div>
                                    <div class="mt-1 text-sm">Top Speed (km/h)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Match Statistics -->
                <div class="card bg-base-100 ">
                    <div class="p-0 card-body">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="text-lg card-title">Match Statistics</h2>
                        </div>
                        @if ($statistics->isEmpty())
                            <div class="p-6 text-center text-base-content/70">
                                No match statistics available.
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="table">
                                    <thead class="bg-base-200">
                                        <tr>
                                            <th>Date</th>
                                            <th>Match</th>
                                            <th>Goals</th>
                                            <th>Assists</th>
                                            <th>Shots</th>
                                            <th>Tackles</th>
                                            <th>Yellow Cards</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($statistics as $stat)
                                            <tr class="hover:bg-base-200">
                                                <td>{{ $stat->match->kickoff_time->format('M j, Y') }}</td>
                                                <td>
                                                    <div class="flex items-center gap-2">
                                                        <div class="avatar">
                                                            <div class="w-6 rounded">
                                                                @if ($stat->match->homeTeam->logo_path)
                                                                    <img src="{{ asset('storage/' . $stat->match->homeTeam->logo_path) }}"
                                                                        alt="{{ $stat->match->homeTeam->name }}" />
                                                                @else
                                                                    <div
                                                                        class="flex items-center justify-center w-full h-full rounded bg-base-300">
                                                                        <span
                                                                            class="text-xs">{{ substr($stat->match->homeTeam->name, 0, 1) }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <span
                                                            class="hidden sm:inline">{{ $stat->match->homeTeam->name }}</span>
                                                        <span>vs</span>
                                                        <div class="avatar">
                                                            <div class="w-6 rounded">
                                                                @if ($stat->match->awayTeam->logo_path)
                                                                    <img src="{{ asset('storage/' . $stat->match->awayTeam->logo_path) }}"
                                                                        alt="{{ $stat->match->awayTeam->name }}" />
                                                                @else
                                                                    <div
                                                                        class="flex items-center justify-center w-full h-full rounded bg-base-300">
                                                                        <span
                                                                            class="text-xs">{{ substr($stat->match->awayTeam->name, 0, 1) }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <span
                                                            class="hidden sm:inline">{{ $stat->match->awayTeam->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($stat->goals > 0)
                                                        <span
                                                            class="font-bold text-primary">{{ $stat->goals }}</span>
                                                    @else
                                                        {{ $stat->goals }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($stat->assists > 0)
                                                        <span
                                                            class="font-bold text-secondary">{{ $stat->assists }}</span>
                                                    @else
                                                        {{ $stat->assists }}
                                                    @endif
                                                </td>
                                                <td>{{ $stat->shots_on_goal }}</td>
                                                <td>{{ $stat->tackles_won }}</td>
                                                <td>
                                                    @if ($stat->yellow_cards > 0)
                                                        <span
                                                            class="font-bold text-warning">{{ $stat->yellow_cards }}</span>
                                                    @else
                                                        {{ $stat->yellow_cards }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Player Info -->
            <div class="space-y-6">
                <!-- Personal Information -->
                <div class="card bg-base-100 ">
                    <div class="p-0 card-body">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="text-lg card-title">Personal Information</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-base-content/70">Full Name</span>
                                <span class="font-medium">{{ $player->first_name }} {{ $player->last_name }}</span>
                            </div>

                            @if ($player->date_of_birth)
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Date of Birth</span>
                                    <span class="font-medium">{{ $player->date_of_birth->format('M j, Y') }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Age</span>
                                    <span class="font-medium">{{ $player->date_of_birth->age }} years</span>
                                </div>
                            @endif

                            @if ($player->nationality)
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Nationality</span>
                                    <span class="font-medium">{{ $player->nationality }}</span>
                                </div>
                            @endif

                            @if ($player->height)
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Height</span>
                                    <span class="font-medium">{{ $player->height }} cm</span>
                                </div>
                            @endif

                            @if ($player->weight)
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Weight</span>
                                    <span class="font-medium">{{ $player->weight }} kg</span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span class="text-base-content/70">Position</span>
                                <span class="font-medium">
                                    @switch($player->position)
                                        @case('GK')
                                            Goalkeeper
                                        @break

                                        @case('DEF')
                                            Defender
                                        @break

                                        @case('MID')
                                            Midfielder
                                        @break

                                        @case('FWD')
                                            Forward
                                        @break

                                        @default
                                            {{ $player->position }}
                                    @endswitch
                                </span>
                            </div>

                            @if ($player->shirt_number)
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Shirt Number</span>
                                    <span class="font-medium">#{{ $player->shirt_number }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Team Information -->
                @if ($player->team)
                    <div class="text-white card bg-gradient-to-br from-blue-900 to-indigo-900 ">
                        <div class="card-body">
                            <h2 class="card-title">Team</h2>
                            <div class="flex items-center gap-4 mt-4">
                                <div class="avatar">
                                    <div class="w-16 rounded-xl ring ring-white ring-offset-base-100 ring-offset-2">
                                        @if ($player->team->logo_path)
                                            <img src="{{ asset('storage/' . $player->team->logo_path) }}"
                                                alt="{{ $player->team->name }}" />
                                        @else
                                            <div
                                                class="flex items-center justify-center w-full h-full bg-base-300 rounded-xl">
                                                <span class="text-2xl">{{ substr($player->team->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold">{{ $player->team->name }}</h3>
                                    @if ($player->team->stadium)
                                        <div class="mt-1 text-base-content/80">{{ $player->team->stadium }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
