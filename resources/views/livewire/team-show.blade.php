<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Team Header -->
        <div class="card bg-gradient-to-r from-primary to-accent text-white shadow mb-8">
            <div class="card-body">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="avatar">
                        <div class="w-24 rounded-xl">
                            <img src="{{ $team->logo_path ? asset('storage/'.$team->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}" alt="{{ $team->name }}" />
                        </div>
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl md:text-4xl font-bold">{{ $team->name }}</h1>
                        <div class="mt-2 flex flex-wrap justify-center md:justify-start gap-4 text-base-content/80">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $team->stadium ?? 'Stadium not set' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Founded: {{ $team->founded_year ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Fixtures -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Upcoming Fixtures -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body p-0">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="card-title text-lg">Upcoming Fixtures</h2>
                        </div>
                        @if($upcomingFixtures->isEmpty())
                            <div class="p-6 text-center text-base-content/70">
                                No upcoming fixtures scheduled.
                            </div>
                        @else
                            <div class="divide-y divide-base-content/10">
                                @foreach($upcomingFixtures as $fixture)
                                    <div class="p-4 hover:bg-base-200 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm text-base-content/70">
                                                {{ $fixture->kickoff_time->format('M j, Y') }}
                                            </div>
                                            <div class="text-sm text-base-content/70">
                                                {{ $fixture->league->name }}
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between mt-2">
                                            <div class="flex items-center gap-3">
                                                @if($fixture->home_team_id == $team->id)
                                                    <span class="font-medium">{{ $fixture->homeTeam->name }}</span>
                                                    <span class="text-base-content/70">(Home)</span>
                                                @else
                                                    <div class="avatar">
                                                        <div class="w-8 rounded">
                                                            <img src="{{ $fixture->homeTeam->logo_path ? asset('storage/'.$fixture->homeTeam->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}" alt="{{ $fixture->homeTeam->name }}" />
                                                        </div>
                                                    </div>
                                                    <span>{{ $fixture->homeTeam->name }}</span>
                                                @endif
                                            </div>
                                            <div class="text-base-content/70">VS</div>
                                            <div class="flex items-center gap-3">
                                                @if($fixture->away_team_id == $team->id)
                                                    <span class="font-medium">{{ $fixture->awayTeam->name }}</span>
                                                    <span class="text-base-content/70">(Away)</span>
                                                @else
                                                    <div class="avatar">
                                                        <div class="w-8 rounded">
                                                            <img src="{{ $fixture->awayTeam->logo_path ? asset('storage/'.$fixture->awayTeam->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}" alt="{{ $fixture->awayTeam->name }}" />
                                                        </div>
                                                    </div>
                                                    <span>{{ $fixture->awayTeam->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-center text-base-content/70">
                                            {{ $fixture->kickoff_time->format('g:i A') }} at {{ $fixture->venue }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Past Fixtures -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body p-0">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="card-title text-lg">Past Fixtures</h2>
                        </div>
                        @if($pastFixtures->isEmpty())
                            <div class="p-6 text-center text-base-content/70">
                                No past fixtures available.
                            </div>
                        @else
                            <div class="divide-y divide-base-content/10">
                                @foreach($pastFixtures as $fixture)
                                    <div class="p-4 hover:bg-base-200 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm text-base-content/70">
                                                {{ $fixture->kickoff_time->format('M j, Y') }}
                                            </div>
                                            <div class="text-sm text-base-content/70">
                                                {{ $fixture->league->name }}
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between mt-2">
                                            <div class="flex items-center gap-3">
                                                @if($fixture->home_team_id == $team->id)
                                                    <span class="font-medium">{{ $fixture->homeTeam->name }}</span>
                                                @else
                                                    <div class="avatar">
                                                        <div class="w-8 rounded">
                                                            <img src="{{ $fixture->homeTeam->logo_path ? asset('storage/'.$fixture->homeTeam->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}" alt="{{ $fixture->homeTeam->name }}" />
                                                        </div>
                                                    </div>
                                                    <span>{{ $fixture->homeTeam->name }}</span>
                                                @endif
                                            </div>
                                            <div class="text-center">
                                                <span class="font-semibold">{{ $fixture->home_score }} - {{ $fixture->away_score }}</span>
                                                @php
                                                    $isHomeTeam = $fixture->home_team_id == $team->id;
                                                    $teamScore = $isHomeTeam ? $fixture->home_score : $fixture->away_score;
                                                    $opponentScore = $isHomeTeam ? $fixture->away_score : $fixture->home_score;
                                                    $result = '';
                                                    if ($teamScore > $opponentScore) {
                                                        $result = 'W';
                                                    } elseif ($teamScore < $opponentScore) {
                                                        $result = 'L';
                                                    } else {
                                                        $result = 'D';
                                                    }
                                                @endphp
                                                <div class="text-xs mt-1">
                                                    <span class="badge @if($result === 'W') badge-success @elseif($result === 'L') badge-error @else badge-warning @endif">
                                                        {{ $result }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                @if($fixture->away_team_id == $team->id)
                                                    <span class="font-medium">{{ $fixture->awayTeam->name }}</span>
                                                @else
                                                    <div class="avatar">
                                                        <div class="w-8 rounded">
                                                            <img src="{{ $fixture->awayTeam->logo_path ? asset('storage/'.$fixture->awayTeam->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}" alt="{{ $fixture->awayTeam->name }}" />
                                                        </div>
                                                    </div>
                                                    <span>{{ $fixture->awayTeam->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Players and Standing -->
            <div class="space-y-6">
                <!-- League Standing -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body p-0">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="card-title text-lg">League Standing</h2>
                        </div>
                        @if($standing)
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
                                                                <img src="{{ $team->logo_path ? asset('storage/'.$team->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}" alt="{{ $team->name }}" />
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
                                                <td class="{{ $standing->goal_difference >= 0 ? 'text-success' : 'text-error' }}">
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
                <div class="card bg-base-100 shadow overflow-y-auto h-96">
                    <div class="card-body p-0">
                        <div class="px-6 py-4 border-b border-base-content/10">
                            <h2 class="card-title text-lg">Players</h2>
                        </div>
                        @if($players->isEmpty())
                            <div class="p-6 text-center text-base-content/70">
                                No players found for this team.
                            </div>
                        @else
                            <div class="divide-y divide-base-content/10">
                                @foreach($players as $player)
                                    <div class="p-4 hover:bg-base-200 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="avatar placeholder">
                                                    <div class="w-10 rounded-full bg-base-300">
                                                        <span class="text-xs">{{ $player->shirt_number }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-medium">{{ $player->first_name }} {{ $player->last_name }}</div>
                                                    <div class="text-sm text-base-content/70">{{ $player->position }}</div>
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
