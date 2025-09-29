<div class="py-6">
    <div class="px-4 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <h1 class="mb-8 text-3xl font-bold text-center text-base-content">PLAYERS</h1>

        <!-- Filters -->
        <div class="mb-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-base-content">Team</span>
                    </label>
                    <select wire:model.live="selectedTeam" class="select select-bordered w-full">
                        <option value="">All Teams</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-base-content">Position</span>
                    </label>
                    <select wire:model.live="selectedPosition" class="select select-bordered w-full">
                        <option value="">All Positions</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->position }}">{{ $position->position }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-base-content">Nationality</span>
                    </label>
                    <select wire:model.live="selectedNationality" class="select select-bordered w-full">
                        <option value="">All Nationalities</option>
                        @foreach ($nationalities as $nationality)
                            <option value="{{ $nationality->nationality }}">{{ $nationality->nationality }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-base-content">&nbsp;</span>
                    </label>
                    <button wire:click="resetFilters" class="btn btn-ghost mt-6">Reset Filters</button>
                </div>
            </div>
        </div>

        @if ($players->isEmpty())
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>No players found matching your criteria.</span>
                <button wire:click="resetFilters" class="btn btn-primary btn-sm">Reset Filters</button>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                @foreach ($players as $player)
                    <a href="{{ route('players.show', $player->id) }}"
                        class="card bg-base-100 shadow-lg image-full transition-all duration-300 hover:shadow-xl">

                        <figure>
                            <img src="https://www.gmu.edu/sites/g/files/yyqcgq291/files/styles/large/public/2025-01/eliudaduq12_thumbnail.jpg?itok=br4rTBtg"
                                alt="{{ $player->first_name }} {{ $player->last_name }}" class="object-cover h-64" />
                        </figure>

                        <div class="card-body">
                            <div class="flex items-start justify-between">
                                <h2 class="text-white card-title">{{ $player->first_name }} {{ $player->last_name }}
                                </h2>
                                @if ($player->shirt_number)
                                    <div class="badge badge-primary badge-sm text-white">#{{ $player->shirt_number }}
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto">
                                @if ($player->team)
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="avatar">
                                            <div class="w-6 h-6 mask mask-circle">
                                                @if ($player->team->logo_path)
                                                    <img src="{{ asset('storage/' . $player->team->logo_path) }}"
                                                        alt="{{ $player->team->name }}" />
                                                @else
                                                    <div class="flex items-center justify-center w-full h-full rounded bg-base-200">
                                                        <span class="text-[8px] text-base-content">{{ substr($player->team->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-xs text-white/80">{{ $player->team->name }}</span>
                                    </div>
                                @endif

                                <div class="flex flex-wrap gap-2 pt-4">
                                    <div class="flex items-center gap-1 badge badge-success badge-sm badge-soft">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-base-content" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span class="">{{ $player->position }}</span>
                                    </div>

                                    @if ($player->nationality)
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white/80"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-xs text-white/80">{{ $player->nationality }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
