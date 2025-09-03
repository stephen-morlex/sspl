<div x-data="{ showBasicInfo: true, showStats: false, showAchievements: false }" class="max-w-4xl mx-auto px-4 py-6">
    <!-- Loading Indicator -->
    <div wire:loading class="flex justify-center items-center p-6">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>
    
    @if($player)
        <!-- Player Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-32 h-32 mb-4 md:mb-0 md:mr-6" />
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900">
                            {{ $player->first_name }} {{ $player->last_name }}
                        </h1>
                        <p class="text-xl text-gray-600 mt-1">{{ $player->position }} • #{{ $player->shirt_number }}</p>
                        <p class="text-gray-500 mt-2">{{ $player->team->name }}</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $player->nationality }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Age: {{ $player->date_of_birth ? now()->diffInYears($player->date_of_birth) : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex flex-wrap gap-2">
                    <button 
                        @click="showBasicInfo = true; showStats = false; showAchievements = false"
                        :class="{ 'bg-blue-500 text-white': showBasicInfo, 'bg-gray-200 text-gray-700': !showBasicInfo }"
                        class="px-4 py-2 rounded-md font-medium transition-colors duration-200">
                        Basic Info
                    </button>
                    <button 
                        @click="showBasicInfo = false; showStats = true; showAchievements = false"
                        :class="{ 'bg-blue-500 text-white': showStats, 'bg-gray-200 text-gray-700': !showStats }"
                        class="px-4 py-2 rounded-md font-medium transition-colors duration-200">
                        Statistics
                    </button>
                    <button 
                        @click="showBasicInfo = false; showStats = false; showAchievements = true"
                        :class="{ 'bg-blue-500 text-white': showAchievements, 'bg-gray-200 text-gray-700': !showAchievements }"
                        class="px-4 py-2 rounded-md font-medium transition-colors duration-200">
                        Achievements
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Basic Info Section -->
        <div x-show="showBasicInfo" x-transition class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Basic Information</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Personal Details</h3>
                        <dl class="space-y-3">
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-500">Full Name</dt>
                                <dd class="text-sm text-gray-900">{{ $player->first_name }} {{ $player->last_name }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-500">Date of Birth</dt>
                                <dd class="text-sm text-gray-900">{{ $player->date_of_birth ? $player->date_of_birth->format('F j, Y') : 'N/A' }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-500">Age</dt>
                                <dd class="text-sm text-gray-900">{{ $player->date_of_birth ? now()->diffInYears($player->date_of_birth) : 'N/A' }} years</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-500">Nationality</dt>
                                <dd class="text-sm text-gray-900">{{ $player->nationality ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Physical Attributes</h3>
                        <dl class="space-y-3">
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-500">Height</dt>
                                <dd class="text-sm text-gray-900">{{ $player->height ? $player->height . ' cm' : 'N/A' }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-500">Weight</dt>
                                <dd class="text-sm text-gray-900">{{ $player->weight ? $player->weight . ' kg' : 'N/A' }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-500">Position</dt>
                                <dd class="text-sm text-gray-900">{{ $player->position ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-500">Shirt Number</dt>
                                <dd class="text-sm text-gray-900">#{{ $player->shirt_number ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Biography</h3>
                    <p class="text-gray-700">
                        {{ $player->bio ?? 'No biography available for this player.' }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Stats Section -->
        <div x-show="showStats" x-transition class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Season Statistics</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-700">0</div>
                        <div class="text-gray-600 text-sm mt-1">Matches</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-700">0</div>
                        <div class="text-gray-600 text-sm mt-1">Goals</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-700">0</div>
                        <div class="text-gray-600 text-sm mt-1">Assists</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-700">0</div>
                        <div class="text-gray-600 text-sm mt-1">Yellow Cards</div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Career Totals</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gray-100 rounded-lg p-4 text-center">
                            <div class="text-xl font-bold text-gray-800">0</div>
                            <div class="text-gray-600 text-sm mt-1">Total Matches</div>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-4 text-center">
                            <div class="text-xl font-bold text-gray-800">0</div>
                            <div class="text-gray-600 text-sm mt-1">Total Goals</div>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-4 text-center">
                            <div class="text-xl font-bold text-gray-800">0</div>
                            <div class="text-gray-600 text-sm mt-1">Total Assists</div>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-4 text-center">
                            <div class="text-xl font-bold text-gray-800">0</div>
                            <div class="text-gray-600 text-sm mt-1">Red Cards</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Achievements Section -->
        <div x-show="showAchievements" x-transition class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Achievements</h2>
            </div>
            
            <div class="p-6">
                <div class="text-center py-8">
                    <div class="text-gray-400">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No achievements yet</h3>
                        <p class="mt-1 text-sm text-gray-500">This player hasn't won any awards or titles yet.</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">Player not found.</p>
        </div>
    @endif
</div>
