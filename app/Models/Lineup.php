<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lineup extends BaseModel
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'fixture_id',
        'team_id',
        'formation',
    ];

    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixture::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function lineupPlayers(): HasMany
    {
        return $this->hasMany(LineupPlayer::class);
    }

    /**
     * Get the starting players for this lineup.
     */
    public function startingPlayers(): HasMany
    {
        return $this->lineupPlayers()->where('role', 'starting');
    }

    /**
     * Get the bench players for this lineup.
     */
    public function benchPlayers(): HasMany
    {
        return $this->lineupPlayers()->where('role', 'bench');
    }

    /**
     * Get the starting players with their player data.
     */
    public function startingPlayerDetails(): HasMany
    {
        return $this->startingPlayers()->with('player');
    }

    /**
     * Get the bench players with their player data.
     */
    public function benchPlayerDetails(): HasMany
    {
        return $this->benchPlayers()->with('player');
    }
}
