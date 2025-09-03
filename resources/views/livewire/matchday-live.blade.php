<div x-data="{ showLive: true, showScheduled: false }" 
     wire:poll.{{ $pollingInterval }}s="loadFixtures"
     class="max-w-6xl mx-auto px-4 py-6">
    
    <!-- Navigation Tabs -->
    <div class="flex border-b border-gray-200 mb-6">
        <button 
            @click="showLive = true; showScheduled = false" 
            :class="{ 'border-blue-500 text-blue-600': showLive, 'border-transparent text-gray-500 hover:text-gray-700': !showLive }"
            class="py-2 px-4 font-medium text-sm border-b-2 focus:outline-none transition-colors duration-200">
            Live Matches
        </button>
        <button 
            @click="showLive = false; showScheduled = true" 
            :class="{ 'border-blue-500 text-blue-600': showScheduled, 'border-transparent text-gray-500 hover:text-gray-700': !showScheduled }"
            class="py-2 px-4 font-medium text-sm border-b-2 focus:outline-none transition-colors duration-200">
            Upcoming Matches
        </button>
    </div>
    
    <!-- Loading Indicator -->
    <div wire:loading class="flex justify-center items-center p-6">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>
    
    <!-- Live Matches Section -->
    <div x-show="showLive" x-transition class="space-y-4">
        @if($liveFixtures->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">No matches are currently live.</p>
            </div>
        @else
            @foreach($liveFixtures as $fixture)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600">{{ $fixture->league->name }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                LIVE
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
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
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
                            </div>
                        </div>
                        
                        <div class="mt-3 text-center text-sm text-gray-500">
                            {{ $fixture->venue }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    
    <!-- Scheduled Matches Section -->
    <div x-show="showScheduled" x-transition class="space-y-4">
        @if($fixtures->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">No upcoming matches scheduled.</p>
            </div>
        @else
            @foreach($fixtures as $fixture)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600">{{ $fixture->league->name }}</span>
                            <span class="text-sm text-gray-500">{{ $fixture->kickoff_time->format('M j, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
                                <span class="font-medium text-gray-900">{{ $fixture->homeTeam->name }}</span>
                            </div>
                            
                            <div class="text-center text-gray-500">
                                VS
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <span class="font-medium text-gray-900">{{ $fixture->awayTeam->name }}</span>
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
                            </div>
                        </div>
                        
                        <div class="mt-3 text-center text-sm text-gray-500">
                            {{ $fixture->kickoff_time->format('g:i A') }} at {{ $fixture->venue }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
