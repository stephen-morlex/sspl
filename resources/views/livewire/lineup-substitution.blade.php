<div>
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
        <h2 class="mb-4 text-xl font-bold">Make Substitution</h2>
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label for="minute" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Minute</label>
                <input 
                    wire:model.live="minute"
                    type="number" 
                    id="minute" 
                    min="0" 
                    max="120"
                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500"
                >
                @error('minute') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="startingPlayerId" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Starting Player</label>
                <select 
                    wire:model.live="startingPlayerId"
                    id="startingPlayerId"
                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Select starting player</option>
                    @foreach($this->startingPlayers as $lineupPlayer)
                        <option value="{{ $lineupPlayer->player_id }}">
                            {{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }} (#{{ $lineupPlayer->player->shirt_number }})
                        </option>
                    @endforeach
                </select>
                @error('startingPlayerId') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="benchPlayerId" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Bench Player</label>
                <select 
                    wire:model.live="benchPlayerId"
                    id="benchPlayerId"
                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Select bench player</option>
                    @foreach($this->benchPlayers as $lineupPlayer)
                        <option value="{{ $lineupPlayer->player_id }}">
                            {{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }} (#{{ $lineupPlayer->player->shirt_number }})
                        </option>
                    @endforeach
                </select>
                @error('benchPlayerId') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <div class="mt-4">
            <button 
                wire:click="makeSubstitution"
                type="button"
                class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                :disabled="!startingPlayerId || !benchPlayerId"
            >
                Make Substitution
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2">
        <!-- Current Starting XI -->
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-bold">Current Starting XI</h3>
            @if(count($this->startingPlayers) > 0)
                <div class="space-y-2">
                    @foreach($this->startingPlayers as $lineupPlayer)
                        <div class="flex items-center justify-between p-2 border rounded">
                            <div>
                                <span class="font-medium">{{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">(#{{ $lineupPlayer->player->shirt_number }})</span>
                            </div>
                            @if($lineupPlayer->substituted_out_minute)
                                <span class="text-sm text-red-500">Substituted out at {{ $lineupPlayer->substituted_out_minute }}'</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No starting players</p>
            @endif
        </div>

        <!-- Current Bench -->
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-bold">Current Bench</h3>
            @if(count($this->benchPlayers) > 0)
                <div class="space-y-2">
                    @foreach($this->benchPlayers as $lineupPlayer)
                        <div class="flex items-center justify-between p-2 border rounded">
                            <div>
                                <span class="font-medium">{{ $lineupPlayer->player->first_name }} {{ $lineupPlayer->player->last_name }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">(#{{ $lineupPlayer->player->shirt_number }})</span>
                            </div>
                            @if($lineupPlayer->entered_at_minute)
                                <span class="text-sm text-green-500">Entered at {{ $lineupPlayer->entered_at_minute }}'</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No bench players</p>
            @endif
        </div>
    </div>
</div>