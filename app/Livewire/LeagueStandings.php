<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Standing;
use App\Models\League;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class LeagueStandings extends Component
{
    public $leagueId; // for route or external set
    public $leagues;

    public ?int $selectedLeague = null;
    public ?int $selectedSeason = null;
    public string $viewMode = 'full';

    public $standings;
    public $previousStandings = [];

    public function mount($leagueId = null)
    {
        $this->leagues = League::orderBy('name')->where('is_active', true)->get();
        $this->selectedLeague = $leagueId ?? $this->leagueId ?? $this->leagues->first()?->id;
        $this->selectedSeason = $this->selectedSeason ?? now()->year;
        $this->loadStandings();
    }

    public function loadStandings(): void
    {
        // Store current standings as previous before updating
        if ($this->standings && $this->standings->count() > 0) {
            $this->previousStandings = $this->standings->keyBy('team_id')->toArray();
        }

        if ($this->selectedLeague) {
            $this->standings = Standing::with(['team', 'league'])
                ->where('league_id', $this->selectedLeague)
                ->get()
                ->sortByDesc(fn ($s) => [$s->points, $s->goal_difference, $s->goals_for])
                ->values()
                ->each(function ($s, $index) { 
                    $s->computed_position = $index + 1;
                    // Set previous position if available
                    if (isset($this->previousStandings[$s->team_id])) {
                        $s->previous_position = $this->previousStandings[$s->team_id]['computed_position'] ?? 
                                              $this->previousStandings[$s->team_id]['position'] ?? 
                                              null;
                    } else {
                        $s->previous_position = null;
                    }
                });
        } else {
            $this->standings = collect();
        }
    }

    public function updatedSelectedLeague(): void
    {
        $this->loadStandings();
    }

    public function render()
    {
        return view('livewire.league-standings', [
            'standings' => $this->standings ?? collect(),
        ]);
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div class="max-w-[1000px] mx-auto px-4 py-6">
            <div class="h-8 bg-base-300 rounded w-1/3 mb-6 animate-pulse"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="h-10 bg-base-300 rounded animate-pulse"></div>
                <div class="h-10 bg-base-300 rounded animate-pulse"></div>
            </div>
            <div class="overflow-x-auto">
                <div class="min-h-[400px] bg-base-200 rounded-lg animate-pulse"></div>
            </div>
        </div>
        HTML;
    }
}
