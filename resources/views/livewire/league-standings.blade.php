<div class="max-w-[1000px] mx-auto px-4 py-8" wire:poll.60s="loadStandings">
    <!-- Header -->
    <h1 class="text-3xl font-extrabold text-center tracking-wide">STANDINGS</h1>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h1 class="block text-xs text-[#6b7280] mb-1">Standings</h1>
            <select class="select select-bordered w-full" wire:model.live="selectedLeague">
                @foreach($leagues as $league)
                    <option value="{{ $league->id }}">{{ $league->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-[#6b7280] mb-1">Season</label>
            <select class="select select-bordered w-full" wire:model.live="selectedSeason">
                @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                    <option value="{{ $y }}">{{ $y }}-{{ $y + 1 }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-16"></th>
                    <th>Club</th>
                    <th class="text-center w-10">P</th>
                    <th class="text-center w-16">W-D-L</th>
                    <th class="text-center w-12">G</th>
                    <th class="text-center w-10">+/-</th>
                    <th class="text-center w-10">Pts</th>
                </tr>
            </thead>
            <tbody>
                @forelse($standings as $s)
                    @php
                        $pos = $s->computed_position ?? $s->position;
                        $prevPos = $s->previous_position;
                        $total = $standings->count();
                        $rowClass = '';
                        if ($pos <= 3) {
                            $rowClass = 'bg-blue-100';
                        } elseif ($pos >= 4 && $pos <= 6) {
                            $rowClass = 'bg-orange-100';
                        } elseif ($pos > ($total - 3)) {
                            $rowClass = 'bg-red-100';
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
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>
                            @if($showUpIcon)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            @elseif($showDownIcon)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            @else
                                <span class="inline-block w-5"></span>
                            @endif
                            <span>{{ $pos }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="mask mask-squircle h-12 w-12">
                                    <img src="{{ asset('storage/'.$s->team->logo_path) }}" class="w-8 h-8 object-contain" alt="{{ $s->team->name }} logo">

                                </div>
                              </div>
                              <div>

                                <div class="text-sm  font-bolo">{{ $s->team->name }}</div>
                              </div>
                            </div>


                        </td>
                        <td class="text-center">{{ $s->played }}</td>
                        <td class="text-center">{{ $s->won }}-{{ $s->drawn }}-{{ $s->lost }}</td>
                        <td class="text-center">{{ $s->goals_for }}:{{ $s->goals_against }}</td>
                        <td class="text-center {{ $s->goal_difference >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $s->goal_difference >= 0 ? '+' : '' }}{{ $s->goal_difference }}</td>
                        <td class="text-center font-semibold">{{ $s->points }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No standings available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

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

        <ul class="steps">
            <li class="step step-primary">Register</li>
            <li class="step step-primary">Choose plan</li>
            <li class="step">Purchase</li>
            <li class="step">Receive Product</li>
          </ul>
    </div>
</div>
