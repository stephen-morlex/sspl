<div
    wire:poll.{{ $pollingInterval }}s="loadFixtures"
    class="max-w-7xl mx-auto px-4 py-6"

>
    <!-- Header & Filters -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-center tracking-wide">MATCHDAY {{ $selectedWeek }}</h1>
        <p class="text-center text-sm text-base-content/70 mt-1">SEASON {{ $selectedSeason }}-{{ ($selectedSeason + 1) }}</p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
            <!-- Season -->
            <div>
                <label class="block text-xs text-base-content/70 mb-1">Season</label>
                <select wire:model.live="selectedSeason" class="select select-bordered w-full bg-base-100">
                    @foreach($seasons as $year)
                        <option value="{{ $year }}">{{ $year }}-{{ $year + 1 }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Matchday -->
            <div>
                <label class="block text-xs text-base-content/70 mb-1">Matchday</label>
                <div class="flex items-center gap-2">
                    <button type="button" wire:click="previousWeek" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <select wire:model.live="selectedWeek" class="select select-bordered flex-1 bg-base-100">
                        @foreach($weeks as $w)
                            <option value="{{ $w }}">Matchday {{ $w }}</option>
                        @endforeach
                    </select>
                    <button type="button" wire:click="nextWeek" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Club filter -->
            <div>
                <label class="block text-xs text-base-content/70 mb-1">All Clubs</label>
                <select wire:model.live="selectedClub" class="select select-bordered w-full bg-base-100">
                    <option value="">All Clubs</option>
                    @foreach($clubs as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Live ticker strip -->
    <div class="mb-6">
        @if($liveFixtures->isNotEmpty())
            <div class="card card-bordered bg-accent text-accent-content">
                <div class="card-body p-4">
                    <div class="flex items-center gap-3 text-sm overflow-x-auto no-scrollbar">
                        <span class="inline-flex items-center gap-2  shrink-0">
                            <span class="h-2 w-2 bg-error rounded-full animate-pulse"></span>
                            Live
                        </span>
                        <ul class="flex items-center gap-6 min-w-max">
                            @foreach($liveFixtures as $f)
                                <li class="whitespace-nowrap">
                                    <span class="font-medium">{{ $f->homeTeam->short_name ?? $f->homeTeam->name }}</span>
                                    <span class="mx-1">{{ $f->home_score }} - {{ $f->away_score }}</span>
                                    <span class="font-medium">{{ $f->awayTeam->short_name ?? $f->awayTeam->name }}</span>
                                    <span class=" ml-2">{{ $f->league->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Grouped matches by day -->
    @forelse($grouped as $day => $times)
        <div class="card card-bordered  shadow mb-4">
            <div class="card-body p-0">
                <div class="px-4 py-2 text-xs font-semibold tracking-wide bg-secondary border-b border-base-content/10">{{ strtoupper($day) }}</div>
                @foreach($times as $time => $fixturesAtTime)
                    @foreach($fixturesAtTime as $fixture)
                        <div class="flex items-center justify-between px-4 h-14 border-b border-base-content/10 hover:bg-base-200 transition-colors">
                            <div class="w-16 text-xs text-base-content/70">{{ $fixture->kickoff_time->format('H:i') }}</div>
                            <div class="flex-1 grid grid-cols-12 items-center gap-2">
                                <div class="col-span-5 flex items-center gap-2">
                                    <div class="avatar">
                                        <div class="w-8 rounded">
                                            <img src="https://ssfa-services.com/images/teams/salam_fc.png" alt="{{ $fixture->homeTeam->name }}" />
                                        </div>
                                    </div>
                                    <span class="truncate">{{ $fixture->homeTeam->name }}</span>
                                </div>
                                <div class="col-span-2 text-center text-xs text-base-content/70">
                                    @if($fixture->status === 'live' || $fixture->status === 'finished')
                                        <span class="font-semibold">{{ $fixture->home_score }} - {{ $fixture->away_score }}</span>
                                    @else
                                        VS
                                    @endif
                                </div>
                                <div class="col-span-5 flex items-center justify-end gap-2">
                                    <span class="truncate text-right">{{ $fixture->awayTeam->name }}</span>
                                    <div class="avatar">
                                        <div class="w-8 rounded">
                                            <img src="https://ssfa-services.com/images/teams/salam_fc.png" alt="{{ $fixture->awayTeam->name }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-40 hidden md:flex justify-end text-xs text-base-content/70">
                                {{ $fixture->league->name }}
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @empty
        <div class="card card-bordered bg-base-100 shadow">
            <div class="card-body text-center text-base-content/70">
                No fixtures for this matchday.
            </div>
        </div>
    @endforelse

    <!-- Footer navigation -->
    <div class="mt-6 flex items-center justify-center gap-3">
        <button type="button" wire:click="previousWeek" class="btn btn-ghost">
            MATCHDAY {{ max(1, ($selectedWeek ?? 1) - 1) }}
        </button>
        <button type="button" wire:click="nextWeek" class="btn btn-ghost">
            MATCHDAY {{ min(38, ($selectedWeek ?? 1) + 1) }}
        </button>
    </div>
</div>
