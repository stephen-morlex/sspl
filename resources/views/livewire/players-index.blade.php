<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-center mb-8">Football Players</h1>
        
        <!-- Filters -->
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="label">
                            <span class="label-text">Team</span>
                        </label>
                        <select wire:model.live="selectedTeam" class="select select-bordered w-full">
                            <option value="">All Teams</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="label">
                            <span class="label-text">Position</span>
                        </label>
                        <select wire:model.live="selectedPosition" class="select select-bordered w-full">
                            <option value="">All Positions</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->position }}">{{ $position->position }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="label">
                            <span class="label-text">Nationality</span>
                        </label>
                        <select wire:model.live="selectedNationality" class="select select-bordered w-full">
                            <option value="">All Nationalities</option>
                            @foreach($nationalities as $nationality)
                                <option value="{{ $nationality->nationality }}">{{ $nationality->nationality }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button wire:click="resetFilters" class="btn btn-outline w-full">Reset Filters</button>
                    </div>
                </div>
            </div>
        </div>
        
        @if($players->isEmpty())
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center">
                    <p class="text-base-content/70">No players found matching your criteria.</p>
                    <button wire:click="resetFilters" class="btn btn-primary mt-4">Reset Filters</button>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($players as $player)
                    <a href="{{ route('players.show', $player->id) }}" class="card card-compact bg-base-100 image-full w-full shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                      
                            <figure>
                                <img src="https://www.gmu.edu/sites/g/files/yyqcgq291/files/styles/large/public/2025-01/eliudaduq12_thumbnail.jpg?itok=br4rTBtg" alt="{{ $player->first_name }} {{ $player->last_name }}" class="object-cover h-64" />
                            </figure>
                      
                        <div class="card-body">
                            <div class="flex justify-between items-start">
                                <h2 class="card-title text-white">{{ $player->first_name }} {{ $player->last_name }}</h2>
                                @if($player->shirt_number)
                                    <div class="badge badge-lg badge-primary">#{{ $player->shirt_number }}</div>
                                @endif
                            </div>
                            
                            <div class="flex flex-wrap gap-2 mt-2">
                                @if($player->team)
                                    <div class="flex items-center gap-1">
                                        <div class="avatar">
                                            <div class="w-5 rounded">
                                                @if($player->team->logo_path)
                                                    <img src="{{ asset('storage/'.$player->team->logo_path) }}" alt="{{ $player->team->name }}" />
                                                @else
                                                    <div class="bg-base-300 w-full h-full rounded flex items-center justify-center">
                                                        <span class="text-[8px]">{{ substr($player->team->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-xs text-white/80">{{ $player->team->name }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <span class="text-xs text-white/80">{{ $player->position }}</span>
                                </div>
                                
                                @if($player->nationality)
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs text-white/80">{{ $player->nationality }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>