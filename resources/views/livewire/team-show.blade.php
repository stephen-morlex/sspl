<div class="py-6">
    <div class="px-4 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <!-- Team Header -->
        <div class="mb-8 text-white card bg-gradient-to-r from-primary to-accent">
            <div class="card-body">
                <div class="flex flex-col items-center gap-6 md:flex-row">
                    <div class="avatar">
                        <div class="w-24 rounded-xl">
                            <img src="{{ $team->logo_path ? asset('storage/' . $team->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}"
                                alt="{{ $team->name }}" />
                        </div>
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold md:text-4xl">{{ $team->name }}</h1>
                        <div class="flex flex-wrap justify-center gap-4 mt-2 md:justify-start text-base-content/80">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $team->stadium ?? 'Stadium not set' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Founded: {{ $team->founded_year ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Left Column: Fixtures -->
            <div class="space-y-6 lg:col-span-2">
                <!-- Upcoming Fixtures -->
                <div class="card bg-base-100">
                    <div class="p-0 card-body">
                        <div class="px-6 py-4 border-base-content/10">
                            <h2 class="divider card-title">Upcoming Fixtures</h2>
                        </div>
                        @if ($upcomingFixtures->isEmpty())
                            <div class="p-6 text-center text-base-content/70">
                                No upcoming fixtures scheduled.
                            </div>
                        @else
                            <!-- Upcoming Fixtures -->
                            <ul class="list bg-base-100 rounded-box">
                                <li class="p-4 pb-2 text-xs tracking-wide opacity-60">Upcoming fixtures for
                                    {{ $team->name }}</li>
                                @foreach ($upcomingFixtures as $fixture)
                                    <li class="flex items-center gap-4 list-row">
                                        <div>
                                            <div>
                                                <span class="font-semibold">{{ $fixture->homeTeam->name }}</span>
                                                <span class="opacity-60">vs</span>
                                                <span class="font-semibold">{{ $fixture->awayTeam->name }}</span>
                                            </div>
                                            <div
                                                class="flex items-center gap-2 mt-1 text-xs font-semibold uppercase opacity-60">
                                                <!-- Date Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $fixture->kickoff_time->format('M j, Y') }}</span>
                                                <!-- Time Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ $fixture->kickoff_time->format('g:i A') }}</span>
                                                <!-- Venue Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 0c-3.866 0-7 1.343-7 3v2a1 1 0 001 1h12a1 1 0 001-1v-2c0-1.657-3.134-3-7-3z" />
                                                </svg>
                                                <span>{{ $fixture->venue }}</span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 ml-auto">
                                            <span class="badge badge-outline">{{ $fixture->league->name }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Past Fixtures -->
                <div class="card bg-base-100">
                    <div class="p-0 card-body">
                        <div class="px-6 py-4 border-base-content/10">
                            <h2 class="divider card-title">Past Fixtures</h2>
                        </div>
                        @if ($pastFixtures->isEmpty())
                            <div class="p-6 text-center text-base-content/70">
                                No past fixtures available.
                            </div>
                        @else
                            <!-- Past Fixtures -->
                            <ul class="list bg-base-100 rounded-box">
                                <li class="p-4 pb-2 text-xs tracking-wide opacity-60">Past fixtures for
                                    {{ $team->name }}</li>
                                @foreach ($pastFixtures as $fixture)
                                    <li class="flex items-center gap-4 list-row">
                                        {{-- <div>
                                            <img class="size-10 rounded-box"
                                                src="{{ $fixture->homeTeam->logo_path ? asset('storage/' . $fixture->homeTeam->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}"
                                                alt="{{ $fixture->homeTeam->name }}" />
                                        </div> --}}
                                        <div>
                                            <div>
                                                <span class="font-semibold">{{ $fixture->homeTeam->name }}</span>
                                                <span class="opacity-60">vs</span>
                                                <span class="font-semibold">{{ $fixture->awayTeam->name }}</span>
                                            </div>
                                            <div
                                                class="flex items-center gap-2 mt-2 text-xs font-semibold uppercase opacity-60">
                                                <!-- Date Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $fixture->kickoff_time->format('M j, Y') }}</span>
                                                <!-- Time Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ $fixture->kickoff_time->format('g:i A') }}</span>
                                                <!-- Venue Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 0c-3.866 0-7 1.343-7 3v2a1 1 0 001 1h12a1 1 0 001-1v-2c0-1.657-3.134-3-7-3z" />
                                                </svg>
                                                <span>{{ $fixture->venue }}</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-1 ml-auto">
                                            <span class="font-semibold">{{ $fixture->home_score }} -
                                                {{ $fixture->away_score }}</span>
                                            @php
                                                $isHomeTeam = $fixture->home_team_id == $team->id;
                                                $teamScore = $isHomeTeam ? $fixture->home_score : $fixture->away_score;
                                                $opponentScore = $isHomeTeam
                                                    ? $fixture->away_score
                                                    : $fixture->home_score;
                                                $result = '';
                                                if ($teamScore > $opponentScore) {
                                                    $result = 'W';
                                                } elseif ($teamScore < $opponentScore) {
                                                    $result = 'L';
                                                } else {
                                                    $result = 'D';
                                                }
                                            @endphp
                                            <span
                                                class="badge badge-soft
                                                @if ($result === 'W') badge-success
                                                @elseif($result === 'L') badge-error
                                                @else badge-warning @endif">
                                                {{ $result }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Players and Standing -->
            <div class="space-y-6">
                <!-- League Standing -->
                <div class=" card bg-base-100">
                    <div class="p-0 card-body">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="card-title">League Standing</h2>
                        </div>
                        @if ($standing)
                            <div class="p-6">
                                <div class="overflow-x-auto">
                                    <table class="table">
                                        <thead class="bg-base-200">
                                            <tr>
                                                <th>Position</th>
                                                <th>Team</th>
                                                <th>P</th>
                                                <th>W</th>
                                                <th>D</th>
                                                <th>L</th>
                                                <th>GF</th>
                                                <th>GA</th>
                                                <th>GD</th>
                                                <th>Pts</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-base-100">
                                                <td class="font-bold">{{ $standing->position }}</td>
                                                <td>
                                                    <div class="flex items-center gap-2">
                                                        <div class="avatar">
                                                            <div class="w-6 rounded">
                                                                <img src="{{ $team->logo_path ? asset('storage/' . $team->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}"
                                                                    alt="{{ $team->name }}" />
                                                            </div>
                                                        </div>
                                                        <span>{{ $team->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $standing->played }}</td>
                                                <td>{{ $standing->won }}</td>
                                                <td>{{ $standing->drawn }}</td>
                                                <td>{{ $standing->lost }}</td>
                                                <td>{{ $standing->goals_for }}</td>
                                                <td>{{ $standing->goals_against }}</td>
                                                <td
                                                    class="{{ $standing->goal_difference >= 0 ? 'text-success' : 'text-error' }}">
                                                    {{ $standing->goal_difference >= 0 ? '+' : '' }}{{ $standing->goal_difference }}
                                                </td>
                                                <td class="font-bold">{{ $standing->points }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="p-6 text-center text-base-content/70">
                                No standing information available.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Players -->
                <div class="overflow-y-auto card bg-base-100 h-96">
                    <div class="p-0 card-body">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="card-title">Players</h2>
                        </div>
                        @if ($players->isEmpty())
                            <div class="p-6 text-center text-base-content/70">
                                No players found for this team.
                            </div>
                        @else
                            <div class="divide-y divide-base-content/10">
                                @foreach ($players as $player)
                                    <div class="p-4 transition-colors hover:bg-base-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="avatar placeholder">
                                                    <div class="w-10 rounded-full bg-base-300">
                                                        <span class="text-xs">{{ $player->shirt_number }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-medium">{{ $player->first_name }}
                                                        {{ $player->last_name }}</div>
                                                    <div class="text-sm text-base-content/70">{{ $player->position }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
