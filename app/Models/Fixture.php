<?php

namespace App\Models;

use App\Enums\FixtureStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Fixture extends Model
{
    use HasFactory, HasUlids;

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
        'status' => FixtureStatus::class,
    ];

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }
 
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    /**
     * Get the statistics for the match.
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(Statistics::class, 'match_id');
    }
    
    /**
     * Get the fixture's name.
     */
    public function getNameAttribute(): string
    {
        return ($this->homeTeam->name ?? 'Home Team') . ' vs ' . ($this->awayTeam->name ?? 'Away Team');
    }
}