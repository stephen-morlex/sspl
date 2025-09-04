<div class="max-w-[1000px] mx-auto px-4 py-8" wire:poll.60s="loadStandings">
    <!-- Header -->
    <h1 class="text-3xl font-extrabold text-center tracking-wide">STANDINGS</h1>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs text-[#6b7280] mb-1">Standings</label>
            <select class="w-full h-10 border border-black/10 rounded-md px-3 bg-white" wire:model.live="selectedLeague">
                @foreach($leagues as $league)
                    <option value="{{ $league->id }}">{{ $league->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-[#6b7280] mb-1">Season</label>
            <select class="w-full h-10 border border-black/10 rounded-md px-3 bg-white" wire:model.live="selectedSeason">
                @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                    <option value="{{ $y }}">{{ $y }}-{{ $y + 1 }}</option>
                @endfor
            </select>
        </div>
    </div>

    <table class="min-w-full mt-6 bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16"></th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Club</th>
                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-10">P</th>
                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">W-D-L</th>
                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12">G</th>
                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-10">+/-</th>
                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-10">Pts</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($standings as $s)
                @php
                    $pos = $s->computed_position ?? $s->position;
                    $prevPos = $s->previous_position;
                    $total = $standings->count();
                    $colorClass = '';
                    if ($pos <= 3) {
                        $colorClass = 'border-l-4 border-green-500';
                    } elseif ($pos >= 4 && $pos <= 6) {
                        $colorClass = 'border-l-4 border-orange-500';
                    } elseif ($pos > ($total - 3)) {
                        $colorClass = 'border-l-4 border-red-500';
                    }

                    // Determine position change indicator
                    $showUpIcon = false;
                    $showDownIcon = false;
                    if ($prevPos && $prevPos != $pos) {
                        if ($pos < $prevPos) {
                            $showUpIcon = true;
                        } else {
                            $showDownIcon = true;
                        }
                    }

                    // Stripe pattern - even rows get a background
                    $stripeClass = $loop->even ? 'bg-gray-50' : 'bg-white';
                @endphp
                <tr class="{{ $colorClass }} {{ $stripeClass }}">
                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                        @if($showUpIcon)
                            <x-heroicon-o-arrow-up class="w-4 h-4 text-green-600 mr-1" />
                        @elseif($showDownIcon)
                            <x-heroicon-o-arrow-down class="w-4 h-4 text-red-600 mr-1" />
                        @else
                            <span class="inline-block w-4"></span>
                        @endif
                        <span>{{ $pos }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/'.$s->team->logo_path) }}" class="w-8 h-8 object-contain" alt="{{ $s->team->name }} logo">
                            <span class="ml-2 text-sm font-normal">{{ $s->team->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm">{{ $s->played }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm">{{ $s->won }}-{{ $s->drawn }}-{{ $s->lost }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm">{{ $s->goals_for }}:{{ $s->goals_against }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm {{ $s->goal_difference >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $s->goal_difference >= 0 ? '+' : '' }}{{ $s->goal_difference }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-semibold">{{ $s->points }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No standings available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3 text-xs text-[#6b7280]">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            UEFA Champions League
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-orange-500"></span>
            UEFA Europa League
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-red-500"></span>
            Relegation
        </div>
    </div>
</div>
