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
    
    public function placeholder()
    {
        return <<<'HTML'
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="card bg-gradient-to-r from-purple-900 to-indigo-900 text-white shadow-xl mb-8 animate-pulse">
                    <div class="card-body">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="w-24 h-24 rounded-xl bg-white/20"></div>
                            <div class="text-center md:text-left">
                                <div class="h-8 bg-white/20 rounded w-64 mb-4"></div>
                                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                    <div class="h-4 bg-white/20 rounded w-32"></div>
                                    <div class="h-4 bg-white/20 rounded w-24"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="card bg-base-100 shadow-xl animate-pulse">
                            <div class="card-body p-6">
                                <div class="h-6 bg-base-300 rounded w-1/3 mb-4"></div>
                                <div class="space-y-3">
                                    <div class="h-4 bg-base-300 rounded w-full"></div>
                                    <div class="h-4 bg-base-300 rounded w-5/6"></div>
                                    <div class="h-4 bg-base-300 rounded w-4/6"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card bg-base-100 shadow-xl animate-pulse">
                            <div class="card-body p-6">
                                <div class="h-6 bg-base-300 rounded w-1/3 mb-4"></div>
                                <div class="space-y-3">
                                    <div class="h-4 bg-base-300 rounded w-full"></div>
                                    <div class="h-4 bg-base-300 rounded w-5/6"></div>
                                    <div class="h-4 bg-base-300 rounded w-4/6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="card bg-base-100 shadow-xl animate-pulse">
                            <div class="card-body p-6">
                                <div class="h-6 bg-base-300 rounded w-1/2 mb-4"></div>
                                <div class="space-y-3">
                                    <div class="h-4 bg-base-300 rounded w-full"></div>
                                    <div class="h-4 bg-base-300 rounded w-3/4"></div>
                                    <div class="h-4 bg-base-300 rounded w-5/6"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card bg-base-100 shadow-xl animate-pulse">
                            <div class="card-body p-6">
                                <div class="h-6 bg-base-300 rounded w-1/2 mb-4"></div>
                                <div class="space-y-3">
                                    <div class="h-4 bg-base-300 rounded w-full"></div>
                                    <div class="h-4 bg-base-300 rounded w-3/4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }
}