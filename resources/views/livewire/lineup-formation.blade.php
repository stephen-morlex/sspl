<div>
    <div class="p-6 mb-6 bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Lineup Formation</h2>
            <div>
                <label for="minute" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">Minute:</label>
                <input 
                    wire:model.live="minute"
                    type="number" 
                    id="minute" 
                    min="0" 
                    max="120"
                    class="w-20 rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500"
                >
            </div>
        </div>

        <!-- Formation Display -->
        <div class="p-4 mb-6 bg-gray-100 rounded-lg dark:bg-gray-700">
            <h3 class="mb-2 text-lg font-bold">Formation: {{ $lineup->formation ?? 'N/A' }}</h3>
            
            <!-- Pitch representation -->
            <div class="relative h-64 bg-green-500 rounded">
                <!-- This is a simplified pitch representation -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white">
                        <p class="text-lg font-bold">Pitch View</p>
                        <p class="text-sm">Formation: {{ $lineup->formation ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <!-- Players on pitch -->
                <div class="absolute inset-0 grid grid-cols-4 gap-2 p-4">
                    @foreach($this->startingPlayers as $lineupPlayer)
                        <div class="flex flex-col items-center justify-center p-2 text-xs text-white bg-blue-500 rounded">
                            <span class="font-bold">{{ $lineupPlayer->player->shirt_number }}</span>
                            <span>{{ $lineupPlayer->player->last_name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Starting XI -->
        <div class="mb-6">
            <h3 class="mb-2 text-lg font-bold">Starting XI</h3>
            @if(count($this->startingPlayers) > 0)
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    @foreach($this->startingPlayers as $lineupPlayer)
                        <div class="flex items-center justify-between p-2 border rounded">
                            <div class="flex items-center">
                                <span class="w-8 h-8 flex items-center justify-center mr-2 font-bold text-white bg-blue-500 rounded-full">{{ $lineupPlayer->player->shirt_number }}</span>
                                <div>
                                    <span class="font-medium">{{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }}</span>
                                    <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $lineupPlayer->player->position }}</span>
                                </div>
                            </div>
                            @if($lineupPlayer->substituted_out_minute && $lineupPlayer->substituted_out_minute <= $minute)
                                <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded">Substituted at {{ $lineupPlayer->substituted_out_minute }}'</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No starting players</p>
            @endif
        </div>

        <!-- Bench -->
        <div class="mb-6">
            <h3 class="mb-2 text-lg font-bold">Bench</h3>
            @if(count($this->benchPlayers) > 0)
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    @foreach($this->benchPlayers as $lineupPlayer)
                        <div class="flex items-center justify-between p-2 border rounded">
                            <div class="flex items-center">
                                <span class="w-8 h-8 flex items-center justify-center mr-2 font-bold text-white bg-gray-500 rounded-full">{{ $lineupPlayer->player->shirt_number }}</span>
                                <div>
                                    <span class="font-medium">{{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }}</span>
                                    <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $lineupPlayer->player->position }}</span>
                                </div>
                            </div>
                            @if($lineupPlayer->entered_at_minute && $lineupPlayer->entered_at_minute <= $minute)
                                <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded">Entered at {{ $lineupPlayer->entered_at_minute }}'</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No bench players</p>
            @endif
        </div>

        <!-- Substituted Players -->
        @if(count($this->substitutedPlayers) > 0)
            <div>
                <h3 class="mb-2 text-lg font-bold">Substitutions</h3>
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    @foreach($this->substitutedPlayers as $lineupPlayer)
                        <div class="flex items-center justify-between p-2 border rounded">
                            <div class="flex items-center">
                                <span class="w-8 h-8 flex items-center justify-center mr-2 font-bold text-white bg-red-500 rounded-full">{{ $lineupPlayer->player->shirt_number }}</span>
                                <div>
                                    <span class="font-medium">{{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }}</span>
                                    <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $lineupPlayer->player->position }}</span>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded">Substituted at {{ $lineupPlayer->substituted_out_minute }}'</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>