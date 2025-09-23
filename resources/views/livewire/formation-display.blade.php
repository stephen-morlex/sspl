<div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Match Lineup</h2>
        <div class="flex items-center space-x-4">
            <div>
                <label for="minute" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">Minute:</label>
                <input 
                    wire:model.live="minute"
                    type="number" 
                    id="minute" 
                    min="0" 
                    max="120"
                    class="w-20 px-2 py-1 text-center border rounded dark:bg-gray-700 dark:border-gray-600"
                >
            </div>
            <div class="text-lg font-bold">
                {{ $lineup->team->name }}
            </div>
        </div>
    </div>

    <!-- Formation Visualization -->
    <div class="mb-8">
        <h3 class="mb-4 text-xl font-bold">Formation: {{ $lineup->formation ?? '4-4-2' }}</h3>
        
        <!-- Soccer pitch visualization -->
        <div class="relative mx-auto overflow-hidden bg-green-600 rounded-lg" style="height: 500px; max-width: 800px;">
            <!-- Pitch markings -->
            <div class="absolute inset-0">
                <!-- Outer lines -->
                <div class="absolute inset-0 border-4 border-white rounded-lg"></div>
                
                <!-- Center circle -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 border-4 border-white rounded-full"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full"></div>
                
                <!-- Center line -->
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-1 h-full bg-white"></div>
                
                <!-- Penalty areas -->
                <div class="absolute top-0 left-0 w-1/4 h-1/3 border-4 border-white border-t-0 border-l-0"></div>
                <div class="absolute bottom-0 left-0 w-1/4 h-1/3 border-4 border-white border-b-0 border-l-0"></div>
                <div class="absolute top-0 right-0 w-1/4 h-1/3 border-4 border-white border-t-0 border-r-0"></div>
                <div class="absolute bottom-0 right-0 w-1/4 h-1/3 border-4 border-white border-b-0 border-r-0"></div>
            </div>
            
            <!-- Players on pitch -->
            <div class="absolute inset-0">
                @foreach($this->startingPlayers as $lineupPlayer)
                    <div 
                        class="absolute flex flex-col items-center justify-center w-12 h-12 text-white bg-blue-500 border-2 border-white rounded-full transform -translate-x-1/2 -translate-y-1/2"
                        style="left: {{ rand(20, 80) }}%; top: {{ rand(20, 80) }}%;"
                    >
                        <span class="text-lg font-bold">{{ $lineupPlayer->player->shirt_number }}</span>
                        <span class="text-xs">{{ $lineupPlayer->player->position }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Lineup Details -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Starting XI -->
        <div>
            <h3 class="mb-4 text-xl font-bold">Starting XI ({{ count($this->startingPlayers) }}/11)</h3>
            @if(count($this->startingPlayers) > 0)
                <div class="space-y-2">
                    @foreach($this->startingPlayers as $lineupPlayer)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-gray-700">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 mr-3 text-white bg-blue-500 rounded-full">
                                    {{ $lineupPlayer->player->shirt_number }}
                                </div>
                                <div>
                                    <div class="font-medium">{{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $lineupPlayer->player->position }}</div>
                                </div>
                            </div>
                            @if($lineupPlayer->substituted_out_minute && $lineupPlayer->substituted_out_minute <= $minute)
                                <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded">
                                    Off {{ $lineupPlayer->substituted_out_minute }}'
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No starting players selected</p>
            @endif
        </div>

        <!-- Bench & Substitutions -->
        <div>
            <h3 class="mb-4 text-xl font-bold">Bench</h3>
            @if(count($this->benchPlayers) > 0)
                <div class="space-y-2">
                    @foreach($this->benchPlayers as $lineupPlayer)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-gray-700">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 mr-3 text-white bg-gray-500 rounded-full">
                                    {{ $lineupPlayer->player->shirt_number }}
                                </div>
                                <div>
                                    <div class="font-medium">{{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $lineupPlayer->player->position }}</div>
                                </div>
                            </div>
                            @if($lineupPlayer->entered_at_minute && $lineupPlayer->entered_at_minute <= $minute)
                                <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded">
                                    On {{ $lineupPlayer->entered_at_minute }}'
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No bench players selected</p>
            @endif

            <!-- Substitution History -->
            @if(count($this->substitutedPlayers) > 0)
                <div class="mt-6">
                    <h4 class="mb-2 text-lg font-bold">Substitution History</h4>
                    <div class="space-y-2">
                        @foreach($this->substitutedPlayers as $lineupPlayer)
                            <div class="flex items-center justify-between p-2 text-sm bg-gray-100 rounded dark:bg-gray-600">
                                <span>{{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }} (#{{ $lineupPlayer->player->shirt_number }})</span>
                                <span class="text-red-500">Off at {{ $lineupPlayer->substituted_out_minute }}'</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Injured/Suspended Players -->
    @php
        $injuredPlayers = $lineup->team->players()->where(function($query) {
            $query->where('is_injured', true)->orWhere('is_suspended', true);
        })->get();
    @endphp

    @if($injuredPlayers->count() > 0)
        <div class="mt-8">
            <h3 class="mb-4 text-xl font-bold">Unavailable Players</h3>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                @foreach($injuredPlayers as $player)
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg dark:bg-red-900/20">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-8 h-8 mr-2 text-white bg-red-500 rounded-full">
                                {{ $player->shirt_number }}
                            </div>
                            <div>
                                <div class="font-medium">{{ $player->first_name }} {{ $player->last_name }}</div>
                            </div>
                        </div>
                        <div class="text-sm">
                            @if($player->is_injured)
                                <span class="px-2 py-1 text-red-800 bg-red-100 rounded dark:bg-red-900/50 dark:text-red-200">Injured</span>
                            @endif
                            @if($player->is_suspended)
                                <span class="px-2 py-1 text-red-800 bg-red-100 rounded dark:bg-red-900/50 dark:text-red-200">Suspended</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>