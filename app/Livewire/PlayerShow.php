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