<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Statistics;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PlayerShow extends Component
{
    public Player $player;
    
    public function mount($id)
    {
        $this->player = Player::with('team')->findOrFail($id);
    }
    
    public function render()
    {
        // Get all statistics for this player
        $allStatistics = Statistics::where('player_id', $this->player->id)
            ->with('match')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Calculate career statistics
        $careerStats = [
            'goals' => $allStatistics->sum('goals'),
            'assists' => $allStatistics->sum('assists'),
            'shots_on_goal' => $allStatistics->sum('shots_on_goal'),
            'tackles_won' => $allStatistics->sum('tackles_won'),
            'aerial_duels_won' => $allStatistics->sum('aerial_duels_won'),
            'fouls_committed' => $allStatistics->sum('fouls_committed'),
            'yellow_cards' => $allStatistics->sum('yellow_cards'),
            'red_cards' => 0, // Assuming red cards aren't tracked separately
            'sprints' => $allStatistics->sum('sprints'),
            'distance_km' => $allStatistics->sum('distance_km'),
            'top_speed_kmh' => $allStatistics->max('top_speed_kmh'),
            'matches_played' => $allStatistics->count(),
        ];

        return view('livewire.player-show', [
            'player' => $this->player,
            'statistics' => $allStatistics,
            'careerStats' => $careerStats,
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
                            <div class="w-32 h-32 rounded-full bg-white/20"></div>
                            <div class="text-center md:text-left">
                                <div class="h-10 bg-white/20 rounded w-80 mb-4"></div>
                                <div class="flex flex-wrap justify-center md:justify-start gap-6">
                                    <div class="h-6 bg-white/20 rounded w-40"></div>
                                    <div class="h-6 bg-white/20 rounded w-32"></div>
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
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="h-20 bg-base-300 rounded"></div>
                                    <div class="h-20 bg-base-300 rounded"></div>
                                    <div class="h-20 bg-base-300 rounded"></div>
                                    <div class="h-20 bg-base-300 rounded"></div>
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
                        
                        <div class="card bg-gradient-to-br from-blue-900 to-indigo-900 text-white shadow-xl animate-pulse">
                            <div class="card-body p-6">
                                <div class="h-6 bg-white/20 rounded w-1/2 mb-4"></div>
                                <div class="flex items-center gap-4 mt-4">
                                    <div class="w-16 h-16 rounded-xl bg-white/20"></div>
                                    <div class="space-y-2">
                                        <div class="h-5 bg-white/20 rounded w-32"></div>
                                        <div class="h-4 bg-white/20 rounded w-24"></div>
                                    </div>
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