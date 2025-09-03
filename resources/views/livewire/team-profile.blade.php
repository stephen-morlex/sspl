<div x-data="{ showPlayers: true, showStats: false }" class="max-w-6xl mx-auto px-4 py-6">
    <!-- Loading Indicator -->
    <div wire:loading class="flex justify-center items-center p-6">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>
    
    @if($team)
        <!-- Team Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-24 h-24 mb-4 md:mb-0 md:mr-6" />
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $team->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $team->city }} • Est. {{ $team->founded_year }}</p>
                        <p class="text-gray-500 mt-2">{{ $team->stadium }}</p>
                    </div>
                </div>
                
                <div class="mt-6 flex flex-wrap gap-2">
                    <button 
                        @click="showPlayers = true; showStats = false"
                        :class="{ 'bg-blue-500 text-white': showPlayers, 'bg-gray-200 text-gray-700': !showPlayers }"
                        class="px-4 py-2 rounded-md font-medium transition-colors duration-200">
                        Squad
                    </button>
                    <button 
                        @click="showPlayers = false; showStats = true"
                        :class="{ 'bg-blue-500 text-white': showStats, 'bg-gray-200 text-gray-700': !showStats }"
                        class="px-4 py-2 rounded-md font-medium transition-colors duration-200">
                        Statistics
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Players Section -->
        <div x-show="showPlayers" x-transition class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Squad</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Player</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nationality</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($players as $player)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $player->shirt_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-8 h-8 mr-3" />
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $player->first_name }} {{ $player->last_name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $player->position }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $player->nationality }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No players found for this team.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Stats Section -->
        <div x-show="showStats" x-transition class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Statistics</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-blue-700">0</div>
                        <div class="text-gray-600 mt-2">Matches Played</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-green-700">0</div>
                        <div class="text-gray-600 mt-2">Goals Scored</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-purple-700">0</div>
                        <div class="text-gray-600 mt-2">Clean Sheets</div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">League Standings</h3>
                    <div class="space-y-3">
                        @foreach($team->standings as $standing)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <div class="font-medium text-gray-900">{{ $standing->league->name }}</div>
                                <div class="flex items-center space-x-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-md">
                                        Position {{ $standing->position }}
                                    </span>
                                    <span class="font-medium">
                                        {{ $standing->points }} pts
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">Team not found.</p>
        </div>
    @endif
</div>
