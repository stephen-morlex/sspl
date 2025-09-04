<div
    wire:poll.{{ $pollingInterval }}s="loadFixtures"
    class="max-w-[1200px] mx-auto px-4 py-6"
>
    <!-- Header & Filters -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-center tracking-wide">MATCHDAY {{ $selectedWeek }}</h1>
        <p class="text-center text-sm text-[#6b7280] mt-1">SEASON {{ $selectedSeason }}-{{ ($selectedSeason + 1) }}</p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
            <!-- Season -->
            <div>
                <label class="block text-xs text-[#6b7280] mb-1">Season</label>
                <select wire:model.live="selectedSeason" class="w-full border border-black/10 rounded-md h-10 px-3 bg-white">
                    @foreach($seasons as $year)
                        <option value="{{ $year }}">{{ $year }}-{{ $year + 1 }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Matchday -->
            <div>
                <label class="block text-xs text-[#6b7280] mb-1">Matchday</label>
                <div class="flex items-center gap-2">
                    <button type="button" wire:click="previousWeek" class="h-10 px-3 rounded-md border border-black/10 bg-white hover:bg-black/5">◀</button>
                    <select wire:model.live="selectedWeek" class="flex-1 border border-black/10 rounded-md h-10 px-3 bg-white">
                        @foreach($weeks as $w)
                            <option value="{{ $w }}">Matchday {{ $w }}</option>
                        @endforeach
                    </select>
                    <button type="button" wire:click="nextWeek" class="h-10 px-3 rounded-md border border-black/10 bg-white hover:bg-black/5">▶</button>
                </div>
            </div>
            <!-- Club filter -->
            <div>
                <label class="block text-xs text-[#6b7280] mb-1">All Clubs</label>
                <select wire:model.live="selectedClub" class="w-full border border-black/10 rounded-md h-10 px-3 bg-white">
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
            <div class="flex items-center gap-3 text-sm overflow-x-auto no-scrollbar">
                <span class="inline-flex items-center gap-2 text-[#6b7280] shrink-0">
                    <span class="h-2 w-2 bg-[#E11D48] rounded-full animate-pulse"></span>
                    Live
                </span>
                <ul class="flex items-center gap-6 min-w-max">
                    @foreach($liveFixtures as $f)
                        <li class="whitespace-nowrap">
                            <span class="font-medium">{{ $f->homeTeam->short_name ?? $f->homeTeam->name }}</span>
                            <span class="mx-1">{{ $f->home_score }} - {{ $f->away_score }}</span>
                            <span class="font-medium">{{ $f->awayTeam->short_name ?? $f->awayTeam->name }}</span>
                            <span class="text-[#6b7280] ml-2">{{ $f->league->name }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Grouped matches by day -->
    @forelse($grouped as $day => $times)
        <div class="rounded-lg overflow-hidden border border-black/5 mb-4 bg-white">
            <div class="px-4 py-2 text-xs font-semibold tracking-wide bg-gray-50 border-b border-black/5">{{ strtoupper($day) }}</div>
            @foreach($times as $time => $fixturesAtTime)
                @foreach($fixturesAtTime as $fixture)
                    <div class="flex items-center justify-between px-4 h-14 border-b border-black/5">
                        <div class="w-16 text-xs text-[#6b7280]">{{ $fixture->kickoff_time->format('H:i') }}</div>
                        <div class="flex-1 grid grid-cols-12 items-center gap-2">
                            <div class="col-span-5 flex items-center gap-2">
                                <image src="{{ asset('storage/'.$fixture->homeTeam->logo_path) }}" class="w-8 h-8 rounded"></image>
                                <span class="truncate">{{ $fixture->homeTeam->name }}</span>
                            </div>
                            <div class="col-span-2 text-center text-xs text-[#6b7280]">
                                @if($fixture->status === 'live' || $fixture->status === 'finished')
                                    <span class="font-semibold">{{ $fixture->home_score }} - {{ $fixture->away_score }}</span>
                                @else
                                    VS
                                @endif
                            </div>
                            <div class="col-span-5 flex items-center justify-end gap-2">
                                <span class="truncate text-right">{{ $fixture->awayTeam->name }}</span>
                                <image src="{{ asset('storage/'.$fixture->awayTeam->logo_path) }}" class="w-8 h-8 rounded"></image>
                            </div>
                        </div>
                        <div class="w-40 hidden md:flex justify-end text-xs text-[#6b7280]">
                            {{ $fixture->league->name }}
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-6 text-center text-[#6b7280]">
            No fixtures for this matchday.
        </div>
    @endforelse

    <!-- Footer navigation -->
    <div class="mt-6 flex items-center justify-center gap-3">
        <button type="button" wire:click="previousWeek" class="h-10 px-5 rounded-md border border-black/10 bg-white hover:bg-black/5">MATCHDAY {{ max(1, ($selectedWeek ?? 1) - 1) }}</button>
        <button type="button" wire:click="nextWeek" class="h-10 px-5 rounded-md border border-black/10 bg-white hover:bg-black/5">MATCHDAY {{ min(38, ($selectedWeek ?? 1) + 1) }}</button>
    </div>
</div>
