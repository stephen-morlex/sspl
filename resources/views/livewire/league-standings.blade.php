<div>
    <div class="px-4 py-6 mx-auto max-w-7xl" wire:poll.60s="loadStandings">
        <!-- Header -->
        <h1 class="font-extrabold tracking-wide text-center divider">TABLE STANDINGS</h1>

        <div class="grid grid-cols-1 gap-4 mt-6 md:grid-cols-2">
            <div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">League</legend>
                    <select class="w-full select select-neutral" wire:model.live="selectedLeague">
                        <option disabled selected>Pick a league</option>
                        @foreach($leagues as $league)
                            <option value="{{ $league->id }}">{{ $league->name }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Season</legend>
                    <select class="w-full select select-neutral" wire:model.live="selectedSeason">
                        @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}">{{ $y }}-{{ $y + 1 }}</option>
                        @endfor
                    </select>
                </fieldset>
            </div>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th class="w-12"></th>
                        <th>Club</th>
                        <th class="w-10 text-center">P</th>
                        <th class="w-12 text-center">W-D-L</th>
                        <th class="w-12 text-center">G</th>
                        <th class="w-10 text-center">+/-</th>
                        <th class="w-10 text-center">Pts</th>
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
                                $rowClass = 'border-l-4 border-success';
                            } elseif ($pos >= 4 && $pos <= 6) {
                                $rowClass = 'border-l-4 border-warning';
                            } elseif ($pos > ($total - 3)) {
                                $rowClass = 'border-l-4 border-error';
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                @elseif($showDownIcon)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                    <div class="w-12 h-12 mask mask-squircle">
                                        <img src="https://ssfa-services.com/images/teams/salam_fc.png" class="object-contain w-8 h-8" alt="{{ $s->team->name }} logo">

                                    </div>
                                  </div>
                                  <div>

                                    <div class="text-lg">{{ $s->team->name }}</div>
                                  </div>
                                </div>
                            </td>
                            <td class="text-center ">{{ $s->played }}</td>
                            <td class="text-center ">{{ $s->won }}-{{ $s->drawn }}-{{ $s->lost }}</td>
                            <td class="text-center ">{{ $s->goals_for }}:{{ $s->goals_against }}</td>
                            <td class="text-center  {{ $s->goal_difference >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $s->goal_difference >= 0 ? '+' : '' }}{{ $s->goal_difference }}</td>
                            <td class="font-semibold text-center text-md">{{ $s->points }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No standings available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 gap-3 mt-6 md:grid-cols-3 ">
            <div class="flex items-center gap-2 ">
                <span class="w-2 h-2 rounded-full bg-success"></span>
               African Champions League
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-warning"></span>
               CECAFE
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-error"></span>
                Relegation
            </div>
        </div>
    </div>
</div>
