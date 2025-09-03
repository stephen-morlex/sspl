<div x-data class="max-w-6xl mx-auto px-4 py-6">
    <!-- Loading Indicator -->
    <div wire:loading class="flex justify-center items-center p-6">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>
    
    <!-- League Selector -->
    <div class="mb-6">
        <label for="league-select" class="block text-sm font-medium text-gray-700 mb-2">Select League</label>
        <select 
            wire:model.live="selectedLeague"
            id="league-select"
            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
            @foreach($leagues as $league)
                <option value="{{ $league->id }}">{{ $league->name }}</option>
            @endforeach
        </select>
    </div>
    
    <!-- Standings Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ $leagues->firstWhere('id', $selectedLeague)?->name ?? 'League' }} Standings
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">P</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">W</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">D</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">L</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">GF</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">GA</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">GD</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pts</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($standings as $standing)
                        <tr class="hover:bg-gray-50 {{ $standing->position <= 4 ? 'bg-blue-50' : ($standing->position >= count($standings) - 2 ? 'bg-red-50' : '') }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <span class="{{ $standing->position == 1 ? 'text-yellow-500 font-bold' : ($standing->position <= 4 ? 'text-green-600' : ($standing->position >= count($standings) - 2 ? 'text-red-600' : 'text-gray-900')) }}">
                                    {{ $standing->position }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-8 h-8 mr-3" />
                                    <div class="text-sm font-medium text-gray-900">{{ $standing->team->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                {{ $standing->played }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                {{ $standing->won }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                {{ $standing->drawn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                {{ $standing->lost }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                {{ $standing->goals_for }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                {{ $standing->goals_against }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 {{ $standing->goal_difference > 0 ? 'text-green-600' : ($standing->goal_difference < 0 ? 'text-red-600' : '') }}">
                                {{ $standing->goal_difference }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-center {{ $standing->position == 1 ? 'text-yellow-600' : ($standing->position <= 4 ? 'text-green-600' : ($standing->position >= count($standings) - 2 ? 'text-red-600' : 'text-gray-900')) }}">
                                {{ $standing->points }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                                No standings available for the selected league.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Legend -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-wrap gap-4 text-sm">
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                    <span>Champions League</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                    <span>European Competitions</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                    <span>Relegation Zone</span>
                </div>
            </div>
        </div>
    </div>
</div>
