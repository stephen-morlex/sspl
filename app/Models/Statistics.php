<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'player_id',
        'match_id',
        'goals',
        'assists',
        'penalties',
        'penalties_scored',
        'shots_on_goal',
        'woodwork_hits',
        'tackles_won',
        'aerial_duels_won',
        'fouls_committed',
        'yellow_cards',
        'sprints',
        'intensive_runs',
        'distance_km',
        'top_speed_kmh',
        'crosses',
        'recent_match_details',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'distance_km' => 'decimal:2',
        'top_speed_kmh' => 'decimal:2',
        'recent_match_details' => 'array',
    ];

    /**
     * Get the player that owns the statistics.
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get the match that owns the statistics.
     */
    public function match()
    {
        return $this->belongsTo(Fixture::class, 'match_id');
    }
}