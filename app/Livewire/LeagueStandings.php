<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Standing;
use App\Models\League;

class LeagueStandings extends Component
{
    public $leagueId;
    public $leagues;
    
    public function mount()
    {
        $this->leagues = League::all();
        $this->leagueId = $this->leagues->first()?->id;
    }
    
    public function render()
    {
        $standings = collect();
        
        if ($this->leagueId) {
            $standings = Standing::with('team')
                ->where('league_id', $this->leagueId)
                ->orderBy('position')
                ->get();
        }
        
        return view('livewire.league-standings', compact('standings'));
    }
}
