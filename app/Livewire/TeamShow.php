<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\Fixture;
use App\Models\Player;
use App\Models\Standing;
use App\Enums\FixtureStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TeamShow extends Component
{
    public Team $team;
    
    public function mount($id)
    {
        $this->team = Team::findOrFail($id);
    }
    
    public function render()
    {
        // Get upcoming fixtures for this team
        $upcomingFixtures = Fixture::where(function ($query) {
                $query->where('home_team_id', $this->team->id)
                      ->orWhere('away_team_id', $this->team->id);
            })
            ->where('kickoff_time', '>', now())
            ->whereIn('status', ['scheduled', 'live'])
            ->orderBy('kickoff_time')
            ->limit(10)
            ->get();
            
        // Get past fixtures for this team (only finished matches)
        $pastFixtures = Fixture::where(function ($query) {
                $query->where('home_team_id', $this->team->id)
                      ->orWhere('away_team_id', $this->team->id);
            })
            ->where('status', 'finished')
            ->orderBy('kickoff_time', 'desc')
            ->limit(10)
            ->get();
            
        // Get players for this team
        $players = Player::where('team_id', $this->team->id)
            ->where('is_active', true)
            ->orderBy('shirt_number')
            ->get();
            
        // Get current league standing
        $currentStanding = Standing::where('team_id', $this->team->id)
            ->first();

        return view('livewire.team-show', [
            'team' => $this->team,
            'upcomingFixtures' => $upcomingFixtures,
            'pastFixtures' => $pastFixtures,
            'players' => $players,
            'standing' => $currentStanding,
        ]);
    }
}