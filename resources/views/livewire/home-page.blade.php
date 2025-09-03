<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Loading Indicator -->
    <div wire:loading class="flex justify-center items-center p-6">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>
    
    <!-- Hero Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-purple-700 rounded-xl shadow-lg p-8 text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Football League Dashboard</h1>
            <p class="text-xl opacity-90">Stay updated with live scores, standings, and upcoming matches</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Live Matches Section -->
            @if($liveFixtures->isNotEmpty())
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                            Live Matches
                        </h2>
                    </div>
                    <div class="p-4 space-y-4">
                        @foreach($liveFixtures as $fixture)
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-600">{{ $fixture->league->name }}</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        LIVE
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-12 h-12" />
                                        <span class="font-medium text-gray-900">{{ $fixture->homeTeam->name }}</span>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="text-2xl font-bold">
                                            {{ $fixture->home_score }} - {{ $fixture->away_score }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $fixture->kickoff_time->format('H:i') }}
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <span class="font-medium text-gray-900">{{ $fixture->awayTeam->name }}</span>
                                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-12 h-12" />
                                    </div>
                                </div>
                                
                                <div class="mt-2 text-center text-sm text-gray-500">
                                    {{ $fixture->venue }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Upcoming Matches Section -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Upcoming Matches</h2>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($upcomingFixtures as $fixture)
                        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-600">{{ $fixture->league->name }}</span>
                                <span class="text-sm text-gray-500">{{ $fixture->kickoff_time->format('M j, Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-12 h-12" />
                                    <span class="font-medium text-gray-900">{{ $fixture->homeTeam->name }}</span>
                                </div>
                                
                                <div class="text-center text-gray-500">
                                    VS
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <span class="font-medium text-gray-900">{{ $fixture->awayTeam->name }}</span>
                                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-12 h-12" />
                                </div>
                            </div>
                            
                            <div class="mt-2 text-center text-sm text-gray-500">
                                {{ $fixture->kickoff_time->format('g:i A') }} at {{ $fixture->venue }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">No upcoming matches scheduled.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Top Standings Section -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Top Standings</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pos</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">P</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pts</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($topStandings as $standing)
                                <tr class="hover:bg-gray-50 {{ $standing->position <= 4 ? 'bg-blue-50' : '' }}">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <span class="{{ $standing->position <= 4 ? 'text-green-600' : 'text-gray-900' }}">
                                            {{ $standing->position }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-6 h-6 mr-2" />
                                            <div class="text-sm font-medium text-gray-900">{{ $standing->team->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-center text-gray-500">
                                        {{ $standing->played }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-center {{ $standing->position <= 4 ? 'text-green-600' : 'text-gray-900' }}">
                                        {{ $standing->points }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                        No standings available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 text-center">
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        View Full Standings →
                    </a>
                </div>
            </div>
            
            <!-- Quick Links Section -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Quick Links</h2>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="bg-blue-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Teams</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="bg-green-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Players</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="bg-purple-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Standings</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="bg-yellow-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Fixtures</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
