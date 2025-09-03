<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'league_id',
        'kickoff_time',
        'venue',
        'home_score',
        'away_score',
        'status',
        'match_summary',
    ];

    protected $casts = [
        'kickoff_time' => 'datetime',
        'home_score' => 'integer',
        'away_score' => 'integer',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }
}
