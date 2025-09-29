<div x-data="lineupBuilder()">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <!-- Available Players -->
        <div class="card bg-base-100 shadow p-4">
            <h3 class="text-lg font-bold mb-4 text-base-content">Available Players</h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                <template x-for="player in availablePlayers" :key="player.id">
                    <div 
                        class="p-2 border rounded cursor-pointer hover:bg-base-200"
                        :class="{
                            'bg-error/20': player.is_injured || player.is_suspended,
                            'opacity-50': player.is_injured || player.is_suspended
                        }"
                        @click="addToStarting(player)"
                        x-show="!isPlayerSelected(player.id)"
                    >
                        <div class="flex justify-between items-center">
                            <span x-text="player.first_name + ' ' + player.last_name" class="text-base-content"></span>
                            <span class="text-xs bg-base-200 px-2 py-1 rounded text-base-content" x-text="player.position"></span>
                        </div>
                        <div class="text-xs text-base-content/70">
                            #<span x-text="player.shirt_number"></span>
                            <template x-if="player.is_injured">
                                <span class="text-error">Injured</span>
                            </template>
                            <template x-if="player.is_suspended">
                                <span class="text-error">Suspended</span>
                            </template>
                        </div>
                </template>
            </div>
        </div>

        <!-- Starting XI -->
        <div class="card bg-base-100 shadow p-4">
            <h3 class="text-lg font-bold mb-4 text-base-content">Starting XI (<span x-text="startingPlayers.length"></span>/11)</h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                <template x-for="(player, index) in startingPlayers" :key="player.id">
                    <div class="p-2 border rounded flex justify-between items-center">
                        <div>
                            <div class="font-medium text-base-content" x-text="player.first_name + ' ' + player.last_name"></div>
                            <div class="text-xs text-base-content/70">
                                #<span x-text="player.shirt_number"></span> · <span x-text="player.position"></span>
                            </div>
                        </div>
                        <button 
                            type="button" 
                            class="text-error hover:text-error/80"
                            @click="removeFromStarting(player)"
                        >
                            Remove
                        </button>
                    </div>
                </template>
                <template x-if="startingPlayers.length === 0">
                    <div class="text-base-content/70 text-center py-4">
                        No starting players selected
                    </div>
                </template>
            </div>
        </div>

        <!-- Bench -->
        <div class="card bg-base-100 shadow p-4">
            <h3 class="text-lg font-bold mb-4 text-base-content">Bench</h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                <template x-for="(player, index) in benchPlayers" :key="player.id">
                    <div class="p-2 border rounded flex justify-between items-center">
                        <div>
                            <div class="font-medium text-base-content" x-text="player.first_name + ' ' + player.last_name"></div>
                            <div class="text-xs text-base-content/70">
                                #<span x-text="player.shirt_number"></span> · <span x-text="player.position"></span>
                            </div>
                        </div>
                        <button 
                            type="button" 
                            class="text-error hover:text-error/80"
                            @click="removeFromBench(player)"
                        >
                            Remove
                        </button>
                    </div>
                </template>
                <template x-if="benchPlayers.length === 0">
                    <div class="text-base-content/70 text-center py-4">
                        No bench players selected
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Substitution Section -->
    <div class="mt-6 card bg-base-100 shadow p-4" x-show="startingPlayers.length > 0 && benchPlayers.length > 0">
        <h3 class="text-lg font-bold mb-4 text-base-content">Substitutions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2 text-base-content">Starting Player</label>
                <select 
                    class="select select-bordered w-full"
                    x-model="substitution.startingPlayerId"
                >
                    <option value="">Select starting player</option>
                    <template x-for="player in startingPlayers" :key="player.id">
                        <option :value="player.id" x-text="player.first_name + ' ' + player.last_name"></option>
                    </template>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2 text-base-content">Bench Player</label>
                <select 
                    class="select select-bordered w-full"
                    x-model="substitution.benchPlayerId"
                >
                    <option value="">Select bench player</option>
                    <template x-for="player in benchPlayers" :key="player.id">
                        <option :value="player.id" x-text="player.first_name + ' ' + player.last_name"></option>
                    </template>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button 
                type="button" 
                class="btn btn-primary"
                @click="makeSubstitution"
                :disabled="!substitution.startingPlayerId || !substitution.benchPlayerId"
            >
                Make Substitution
            </button>
        </div>
    </div>
</div>

<script>
function lineupBuilder() {
    return {
        availablePlayers: @json($getRecord()?->team->players ?? []),
        startingPlayers: [],
        benchPlayers: [],
        substitution: {
            startingPlayerId: '',
            benchPlayerId: ''
        },

        init() {
            // Initialize with existing lineup data if editing
            const existingLineup = @json($getRecord()?->lineupPlayers ?? []);
            if (existingLineup.length > 0) {
                existingLineup.forEach(lp => {
                    if (lp.role === 'starting') {
                        this.startingPlayers.push(lp.player);
                    } else {
                        this.benchPlayers.push(lp.player);
                    }
                });
            }
        },

        isPlayerSelected(playerId) {
            return this.startingPlayers.some(p => p.id === playerId) || 
                   this.benchPlayers.some(p => p.id === playerId);
        },

        addToStarting(player) {
            if (this.startingPlayers.length >= 11) {
                alert('Maximum 11 starting players allowed');
                return;
            }
            
            if (player.is_injured || player.is_suspended) {
                if (!confirm('This player is injured or suspended. Are you sure you want to add them as a starter?')) {
                    return;
                }
            }
            
            this.startingPlayers.push(player);
        },

        removeFromStarting(player) {
            const index = this.startingPlayers.findIndex(p => p.id === player.id);
            if (index !== -1) {
                this.startingPlayers.splice(index, 1);
            }
        },

        addToBench(player) {
            this.benchPlayers.push(player);
        },

        removeFromBench(player) {
            const index = this.benchPlayers.findIndex(p => p.id === player.id);
            if (index !== -1) {
                this.benchPlayers.splice(index, 1);
            }
        },

        makeSubstitution() {
            const startingPlayer = this.startingPlayers.find(p => p.id === this.substitution.startingPlayerId);
            const benchPlayer = this.benchPlayers.find(p => p.id === this.substitution.benchPlayerId);
            
            if (startingPlayer && benchPlayer) {
                // Swap players
                this.removeFromStarting(startingPlayer);
                this.removeFromBench(benchPlayer);
                this.addToStarting(benchPlayer);
                this.addToBench(startingPlayer);
                
                // Reset selection
                this.substitution.startingPlayerId = '';
                this.substitution.benchPlayerId = '';
            }
        }
    }
}
</script>