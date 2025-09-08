<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Team;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PlayersIndex extends Component
{
    public $selectedTeam = '';
    public $selectedPosition = '';
    public $selectedNationality = '';
    
    public function render()
    {
        $players = Player::where('is_active', true)
            ->with('team')
            ->when($this->selectedTeam, function ($query) {
                return $query->where('team_id', $this->selectedTeam);
            })
            ->when($this->selectedPosition, function ($query) {
                return $query->where('position', $this->selectedPosition);
            })
            ->when($this->selectedNationality, function ($query) {
                return $query->where('nationality', $this->selectedNationality);
            })
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
            
        // Get filter options
        $teams = Team::orderBy('name')->get();
        $positions = Player::select('position')->where('position', '!=', '')->distinct()->orderBy('position')->get();
        $nationalities = Player::select('nationality')->where('nationality', '!=', '')->distinct()->orderBy('nationality')->get();

        return view('livewire.players-index', [
            'players' => $players,
            'teams' => $teams,
            'positions' => $positions,
            'nationalities' => $nationalities,
        ]);
    }
    
    public function resetFilters()
    {
        $this->selectedTeam = '';
        $this->selectedPosition = '';
        $this->selectedNationality = '';
    }
}