<div class="py-6">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-8 font-bold text-center divider"> PLAYERS</h1>

        <!-- Filters -->
        <div class="mb-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Team</legend>
                    <select wire:model.live="selectedTeam" class="w-full select select-neutral">
                        <option value="">All Teams</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>

                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Position</legend>
                    <select wire:model.live="selectedPosition" class="w-full select select-neutral">
                        <option value="">All Positions</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->position }}">{{ $position->position }}</option>
                        @endforeach
                    </select>

                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Nationality</legend>
                    <select wire:model.live="selectedNationality" class="w-full select select-neutral">
                        <option value="">All Nationalities</option>
                        @foreach ($nationalities as $nationality)
                            <option value="{{ $nationality->nationality }}">{{ $nationality->nationality }}</option>
                        @endforeach
                    </select>

                </fieldset>

                <fieldset class="fieldset">
                    <button wire:click="resetFilters" class="w-full sm:mt-7 btn btn-neutral">Reset
                        Filters</button>
                </fieldset>
            </div>
        </div>

        @if ($players->isEmpty())
            <div class="shadow-xl card bg-base-100">
                <div class="text-center card-body">
                    <p class="text-base-content/70">No players found matching your criteria.</p>
                    <button wire:click="resetFilters" class="mt-4 btn btn-primary">Reset Filters</button>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($players as $player)
                    <a href="{{ route('players.show', $player->id) }}"
                        class="w-full transition-all duration-300 transform shadow-xl card card-compact bg-base-100 image-full hover:shadow-2xl hover:-translate-y-1">

                        <figure>
                            <img src="https://www.gmu.edu/sites/g/files/yyqcgq291/files/styles/large/public/2025-01/eliudaduq12_thumbnail.jpg?itok=br4rTBtg"
                                alt="{{ $player->first_name }} {{ $player->last_name }}" class="object-cover h-64" />
                        </figure>

                        <div class="card-body">
                            <div class="flex items-start justify-between">
                                <h2 class="text-white card-title">{{ $player->first_name }} {{ $player->last_name }}
                                </h2>
                                @if ($player->shirt_number)
                                    <div class="badge badge-soft badge-sm badge-info">#{{ $player->shirt_number }}
                                    </div>
                                @endif
                            </div>

                            <div class="absolute gap-2 my-2 bottom-2">
                                @if ($player->team)
                                    <div class="flex items-center mb-4">
                                        <div class="avatar">
                                            <div class="w-5 rounded">
                                                @if ($player->team->logo_path)
                                                    <img src="{{ asset('storage/' . $player->team->logo_path) }}"
                                                        alt="{{ $player->team->name }}" />
                                                @else
                                                    <div
                                                        class="flex items-center justify-center w-full h-full rounded bg-base-300">
                                                        <span
                                                            class="text-[8px]">{{ substr($player->team->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="ml-2 text-xs text-white/80">{{ $player->team->name }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-1 badge badge-sm badge-soft badge-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 size-[1em]"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span class="">{{ $player->position }}</span>
                                    </div>

                                    @if ($player->nationality)
                                        <div class="flex items-center gap-1 ">
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
    {{-- <div> {{ $players->links() }}</div> --}}
</div>
