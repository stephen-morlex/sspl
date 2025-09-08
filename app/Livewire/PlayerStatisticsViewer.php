<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Statistics;
use Illuminate\Support\Collection;
use Livewire\Component;

class PlayerStatisticsViewer extends Component
{
    public Player $player;
    
    public function mount(int $playerId): void
    {
        $this->player = Player::with('team')->findOrFail($playerId);
    }

    /**
     * Get the player's statistics for the current season.
     */
    public function getPlayerStatisticsProperty(): Collection
    {
        return Statistics::where('player_id', $this->player->id)
            ->with('match')
            ->get();
    }

    /**
     * Get aggregated statistics for the current season.
     */
    public function getSeasonStatsProperty(): object
    {
        return Statistics::where('player_id', $this->player->id)
            ->selectRaw('
                SUM(goals) as total_goals,
                SUM(assists) as total_assists,
                SUM(shots_on_goal) as total_shots_on_goal,
                SUM(tackles_won) as total_tackles_won,
                SUM(aerial_duels_won) as total_aerial_duels_won,
                SUM(sprints) as total_sprints,
                SUM(intensive_runs) as total_intensive_runs,
                SUM(distance_km) as total_distance_km,
                MAX(top_speed_kmh) as max_top_speed_kmh,
                AVG(top_speed_kmh) as avg_top_speed_kmh,
                COUNT(*) as matches_played
            ')
            ->first();
    }

    /**
     * Get the most recent match statistics.
     */
    public function getRecentMatchStatsProperty(): ?Statistics
    {
        return Statistics::where('player_id', $this->player->id)
            ->with('match')
            ->latest('created_at')
            ->first();
    }

    /**
     * Calculate per match averages for key statistics.
     */
    public function getPerMatchAveragesProperty(): object
    {
        $seasonStats = $this->seasonStats;
        $matchesPlayed = $seasonStats->matches_played > 0 ? $seasonStats->matches_played : 1;
        
        return (object) [
            'goals' => round($seasonStats->total_goals / $matchesPlayed, 2),
            'assists' => round($seasonStats->total_assists / $matchesPlayed, 2),
            'shots_on_goal' => round($seasonStats->total_shots_on_goal / $matchesPlayed, 2),
            'tackles_won' => round($seasonStats->total_tackles_won / $matchesPlayed, 2),
            'aerial_duels_won' => round($seasonStats->total_aerial_duels_won / $matchesPlayed, 2),
            'sprints' => round($seasonStats->total_sprints / $matchesPlayed, 2),
            'distance_km' => round($seasonStats->total_distance_km / $matchesPlayed, 2),
        ];
    }

    public function render()
    {
        return view('livewire.player-statistics-viewer');
    }
}