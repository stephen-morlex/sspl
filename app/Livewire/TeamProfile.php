<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\Player;

class TeamProfile extends Component
{
    public $team;
    public $players;
    public $teamId;
    
    public function mount($teamId = null)
    {
        $this->teamId = $teamId;
        $this->loadTeam();
    }
    
    public function loadTeam()
    {
        if ($this->teamId) {
            $this->team = Team::with('standings.league')->find($this->teamId);
            $this->players = Player::where('team_id', $this->teamId)
                ->orderBy('shirt_number')
                ->get();
        }
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
        return view('livewire.team-profile');
    }
}
