<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerStat extends Model
{
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'player_id',
        'goals',
        'penalty_goals',
        'own_goals',
        'yellow_cards',
        'red_cards',
        'assists',
        'substitutions_in',
        'substitutions_out',
        'corners',
        'offsides',
        'fouls_committed',
        'fouls_suffered',
        'shots_on_target',
        'shots_off_target',
        'shots_blocked',
        'passes_completed',
        'passes_attempted',
        'tackles_won',
        'tackles_lost',
        'interceptions',
        'clearances',
        'blocks',
        'saves',
        'penalties_saved',
        'penalties_missed',
        'duels_won',
        'duels_lost',
        'aerial_duels_won',
        'aerial_duels_lost',
        'matches_played',
        'minutes_played',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'goals' => 'integer',
        'penalty_goals' => 'integer',
        'own_goals' => 'integer',
        'yellow_cards' => 'integer',
        'red_cards' => 'integer',
        'assists' => 'integer',
        'substitutions_in' => 'integer',
        'substitutions_out' => 'integer',
        'corners' => 'integer',
        'offsides' => 'integer',
        'fouls_committed' => 'integer',
        'fouls_suffered' => 'integer',
        'shots_on_target' => 'integer',
        'shots_off_target' => 'integer',
        'shots_blocked' => 'integer',
        'passes_completed' => 'integer',
        'passes_attempted' => 'integer',
        'tackles_won' => 'integer',
        'tackles_lost' => 'integer',
        'interceptions' => 'integer',
        'clearances' => 'integer',
        'blocks' => 'integer',
        'saves' => 'integer',
        'penalties_saved' => 'integer',
        'penalties_missed' => 'integer',
        'duels_won' => 'integer',
        'duels_lost' => 'integer',
        'aerial_duels_won' => 'integer',
        'aerial_duels_lost' => 'integer',
        'matches_played' => 'integer',
        'minutes_played' => 'integer',
    ];

    /**
     * Get the player that owns the stats.
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}