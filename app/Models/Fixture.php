<?php

namespace App\Models;

use App\Enums\FixtureStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fixture extends Model
{
    use HasFactory;
    use HasUlids;

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

    protected $attributes = [
        'home_score' => 0,
        'away_score' => 0,
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
     * Get the match events for this fixture.
     */
    public function events(): HasMany
    {
        return $this->hasMany(MatchEvent::class);
    }

    /**
     * Get the match stats for this fixture.
     */
    public function stats(): HasMany
    {
        return $this->hasMany(MatchStat::class);
    }

    /**
     * Get the lineups for this fixture.
     */
    public function lineups(): HasMany
    {
        return $this->hasMany(Lineup::class);
    }

    /**
     * Get the fixture coaches for this fixture.
     */
    public function fixtureCoaches(): HasMany
    {
        return $this->hasMany(FixtureCoach::class);
    }

    /**
     * Get the fixture's name.
     */
    public function getNameAttribute(): string
    {
        return ($this->homeTeam->name ?? 'Home Team') . ' vs ' . ($this->awayTeam->name ?? 'Away Team');
    }

    /**
     * Increment the home team's score.
     */
    public function incrementHomeScore(): void
    {
        $this->increment('home_score');
    }

    /**
     * Increment the away team's score.
     */
    public function incrementAwayScore(): void
    {
        $this->increment('away_score');
    }

    /**
     * Decrement the home team's score.
     */
    public function decrementHomeScore(): void
    {
        if ($this->home_score > 0) {
            $this->decrement('home_score');
        }
    }

    /**
     * Decrement the away team's score.
     */
    public function decrementAwayScore(): void
    {
        if ($this->away_score > 0) {
            $this->decrement('away_score');
        }
    }

    /**
     * Handle a goal event for the home team.
     */
    public function homeTeamGoal(): void
    {
        $this->incrementHomeScore();
    }

    /**
     * Handle a goal event for the away team.
     */
    public function awayTeamGoal(): void
    {
        $this->incrementAwayScore();
    }

    /**
     * Handle a disallowed goal for the home team.
     */
    public function disallowHomeTeamGoal(): void
    {
        $this->decrementHomeScore();
    }

    /**
     * Handle a disallowed goal for the away team.
     */
    public function disallowAwayTeamGoal(): void
    {
        $this->decrementAwayScore();
    }
}
