<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Standing;
use App\Models\League;

class StandingsTable extends Component
{
    public $standings;
    public $leagues;
    public $selectedLeague;
    
    public function mount($leagueId = null)
    {
        $this->leagues = League::all();
        $this->selectedLeague = $leagueId ?? $this->leagues->first()?->id;
        $this->loadStandings();
    }
    
    public function loadStandings()
    {
        if ($this->selectedLeague) {
            $this->standings = Standing::with(['team', 'league'])
                ->where('league_id', $this->selectedLeague)
                ->orderBy('points', 'desc')
                ->orderBy('goal_difference', 'desc')
                ->orderBy('goals_for', 'desc')
                ->get();
        } else {
            $this->standings = collect();
        }
    }
    
    public function updatedSelectedLeague()
    {
        $this->loadStandings();
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex justify-center items-center p-6">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
        </div>
        HTML;
    }
    
    public function render()
    {
        return view('livewire.standings-table');
    }
}
