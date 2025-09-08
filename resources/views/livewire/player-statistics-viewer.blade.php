<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Player Statistics</h2>
        <p class="text-gray-600">Detailed performance metrics for {{ $player->first_name }} {{ $player->last_name }}</p>
    </div>

    <!-- Season Summary -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Season Summary</h3>
            <span class="badge badge-primary">Current Season</span>
        </div>

        @if($seasonStats && $seasonStats->matches_played > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $seasonStats->total_goals }}</div>
                    <div class="text-gray-600">Goals</div>
                    <div class="text-sm text-gray-500">Per match: {{ $perMatchAverages->goals }}</div>
                </div>
                
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $seasonStats->total_assists }}</div>
                    <div class="text-gray-600">Assists</div>
                    <div class="text-sm text-gray-500">Per match: {{ $perMatchAverages->assists }}</div>
                </div>
                
                <div class="bg-purple-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-purple-600">{{ number_format($seasonStats->total_distance_km, 1) }} km</div>
                    <div class="text-gray-600">Distance</div>
                    <div class="text-sm text-gray-500">Per match: {{ $perMatchAverages->distance_km }} km</div>
                </div>
                
                <div class="bg-orange-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-orange-600">{{ $seasonStats->max_top_speed_kmh }} km/h</div>
                    <div class="text-gray-600">Top Speed</div>
                    <div class="text-sm text-gray-500">Average: {{ number_format($seasonStats->avg_top_speed_kmh, 1) }} km/h</div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                <div class="bg-amber-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-amber-600">{{ $seasonStats->total_sprints }}</div>
                    <div class="text-gray-600">Sprints</div>
                    <div class="text-sm text-gray-500">Per match: {{ $perMatchAverages->sprints }}</div>
                </div>
                
                <div class="bg-cyan-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-cyan-600">{{ $seasonStats->total_shots_on_goal }}</div>
                    <div class="text-gray-600">Shots on Goal</div>
                    <div class="text-sm text-gray-500">Per match: {{ $perMatchAverages->shots_on_goal }}</div>
                </div>
                
                <div class="bg-emerald-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-emerald-600">{{ $seasonStats->total_tackles_won }}</div>
                    <div class="text-gray-600">Tackles Won</div>
                    <div class="text-sm text-gray-500">Per match: {{ $perMatchAverages->tackles_won }}</div>
                </div>
                
                <div class="bg-violet-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-violet-600">{{ $seasonStats->total_aerial_duels_won }}</div>
                    <div class="text-gray-600">Aerial Duels</div>
                    <div class="text-sm text-gray-500">Per match: {{ $perMatchAverages->aerial_duels_won }}</div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">No statistics available for this player yet.</p>
            </div>
        @endif
    </div>

    <!-- Recent Match Details -->
    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ open: true }">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Recent Match Performance</h3>
            <button @click="open = !open" class="btn btn-sm btn-ghost">
                <span x-show="open">Hide Details</span>
                <span x-show="!open">Show Details</span>
            </button>
        </div>

        @if($recentMatchStats)
            <div x-show="open" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-700 mb-3">Match Overview</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Match:</span>
                                <span class="font-medium">
                                    {{ $recentMatchStats->match->homeTeam->name }} vs {{ $recentMatchStats->match->awayTeam->name }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium">
                                    {{ $recentMatchStats->match->kickoff_time->format('M j, Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Goals:</span>
                                <span class="font-medium">{{ $recentMatchStats->goals }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Assists:</span>
                                <span class="font-medium">{{ $recentMatchStats->assists }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-700 mb-3">Performance Metrics</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Distance:</span>
                                <span class="font-medium">{{ $recentMatchStats->distance_km }} km</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Top Speed:</span>
                                <span class="font-medium">{{ $recentMatchStats->top_speed_kmh }} km/h</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sprints:</span>
                                <span class="font-medium">{{ $recentMatchStats->sprints }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shots on Goal:</span>
                                <span class="font-medium">{{ $recentMatchStats->shots_on_goal }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($recentMatchStats->recent_match_details)
                    <div class="mt-6">
                        <h4 class="font-medium text-gray-700 mb-3">Detailed Metrics</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach($recentMatchStats->recent_match_details as $key => $value)
                                <div class="bg-gray-50 rounded p-3 text-center">
                                    <div class="text-lg font-semibold text-gray-800">{{ $value }}</div>
                                    <div class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div x-show="open" x-transition class="text-center py-4">
                <p class="text-gray-500">No recent match statistics available.</p>
            </div>
        @endif
    </div>
</div>