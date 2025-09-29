<div>
    <div class="px-4 py-6 mx-auto max-w-4xl" wire:poll.60s="loadStandings">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-center text-base-content">TABLE STANDINGS</h1>

        <div class="grid grid-cols-1 gap-4 mt-6 md:grid-cols-2">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-base-content">League</span>
                </label>
                <select class="select select-bordered w-full" wire:model.live="selectedLeague">
                    <option disabled selected>Pick a league</option>
                    @foreach($leagues as $league)
                        <option value="{{ $league->id }}">{{ $league->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-base-content">Season</span>
                </label>
                <select class="select select-bordered w-full" wire:model.live="selectedSeason">
                    @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}">{{ $y }}-{{ $y + 1 }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th class="w-12 text-base-content"></th>
                        <th class="text-base-content">Club</th>
                        <th class="w-10 text-center text-base-content">P</th>
                        <th class="w-12 text-center text-base-content">W-D-L</th>
                        <th class="w-12 text-center text-base-content">G</th>
                        <th class="w-10 text-center text-base-content">+/-</th>
                        <th class="w-10 text-center text-base-content">Pts</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($standings as $s)
                        @php
                            $pos = $s->computed_position ?? $s->position;
                            $prevPos = $s->previous_position;
                            $total = $standings->count();
                            $rowColor = '';
                            if ($pos <= 3) {
                                $rowColor = 'success';
                            } elseif ($pos >= 4 && $pos <= 6) {
                                $rowColor = 'warning';
                            } elseif ($pos > ($total - 3)) {
                                $rowColor = 'error';
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
                        <tr class="{{ $rowColor ? 'text-'.$rowColor : '' }}">
                            <td class="text-base-content">
                                @if($showUpIcon)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                @elseif($showDownIcon)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                @else
                                    <span class="inline-block w-5"></span>
                                @endif
                                <span class="text-base-content">{{ $pos }}</span>
                            </td>
                            <td class="text-base-content">
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-12 h-12 mask mask-squircle">
                                            <img src="https://ssfa-services.com/images/teams/salam_fc.png" class="object-contain w-8 h-8" alt="{{ $s->team->name }} logo">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-medium text-base-content">{{ $s->team->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center text-base-content">{{ $s->played }}</td>
                            <td class="text-center text-base-content">{{ $s->won }}-{{ $s->drawn }}-{{ $s->lost }}</td>
                            <td class="text-center text-base-content">{{ $s->goals_for }}:{{ $s->goals_against }}</td>
                            <td class="text-center {{ $s->goal_difference >= 0 ? 'text-success' : 'text-error' }} text-base-content">{{ $s->goal_difference >= 0 ? '+' : '' }}{{ $s->goal_difference }}</td>
                            <td class="font-semibold text-center text-md text-base-content">{{ $s->points }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-base-content">No standings available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 gap-3 mt-6 md:grid-cols-3">
            <div class="flex items-center gap-2">
                <span class="status status-success"></span>
                <span class="text-base-content">African Champions League</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="status status-warning"></span>
                <span class="text-base-content">CECAFE</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="status status-error"></span>
                <span class="text-base-content">Relegation</span>
            </div>
        </div>
    </div>
</div>
