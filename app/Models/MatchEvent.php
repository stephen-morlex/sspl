<?php

namespace App\Models;

use App\Events\MatchEventCreated;
use App\Events\MatchEventDeleted;
use App\Jobs\UpdateStatsJob;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchEvent extends Model
{
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'match_id',
        'team_id',
        'player_id',
        'event_type',
        'minute',
        'period',
        'details',
        'pitch_position',
        'updated_score',
        'source',
        'created_by',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'details' => 'array',
        'pitch_position' => 'array',
        'updated_score' => 'array',
        'processed_at' => 'datetime',
        'minute' => 'integer',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => MatchEventCreated::class,
        'deleted' => MatchEventDeleted::class,
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($matchEvent) {
            $matchEvent->updateFixtureScore();
        });

        static::updated(function ($matchEvent) {
            $matchEvent->updateFixtureScore();
        });

        static::deleted(function ($matchEvent) {
            $matchEvent->updateFixtureScoreOnDelete();
        });
    }

    /**
     * Get the fixture that owns the event.
     */
    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixture::class, 'match_id');
    }

    /**
     * Get the team associated with the event.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the player associated with the event.
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Update fixture score based on the event type.
     *
     * @return void
     */
    public function updateFixtureScore()
    {
        // Only update score for goal-related events
        if (!in_array($this->event_type, ['goal', 'penalty_goal', 'own_goal'])) {
            return;
        }

        $fixture = $this->fixture;
        if (!$fixture) {
            return;
        }

        // Determine if it's a home or away goal
        $isHomeTeamGoal = $this->isHomeTeamGoal();

        // Update the score based on the event type
        switch ($this->event_type) {
            case 'goal':
            case 'penalty_goal':
                if ($isHomeTeamGoal) {
                    $fixture->incrementHomeScore();
                } else {
                    $fixture->incrementAwayScore();
                }
                break;

            case 'own_goal':
                // For own goals, the scoring team is the opposite
                if ($isHomeTeamGoal) {
                    $fixture->incrementAwayScore(); // Opposite team scores
                } else {
                    $fixture->incrementHomeScore(); // Opposite team scores
                }
                break;
        }
    }

    /**
     * Update fixture score when an event is deleted.
     *
     * @return void
     */
    public function updateFixtureScoreOnDelete()
    {
        // Only update score for goal-related events
        if (!in_array($this->event_type, ['goal', 'penalty_goal', 'own_goal'])) {
            return;
        }

        $fixture = $this->fixture;
        if (!$fixture) {
            return;
        }

        // Determine if it's a home or away goal
        $isHomeTeamGoal = $this->isHomeTeamGoal();

        // Update the score based on the event type (reverse the increment)
        switch ($this->event_type) {
            case 'goal':
            case 'penalty_goal':
                if ($isHomeTeamGoal) {
                    $fixture->decrementHomeScore();
                } else {
                    $fixture->decrementAwayScore();
                }
                break;

            case 'own_goal':
                // For own goals, the scoring team is the opposite
                if ($isHomeTeamGoal) {
                    $fixture->decrementAwayScore(); // Opposite team scored
                } else {
                    $fixture->decrementHomeScore(); // Opposite team scored
                }
                break;
        }
    }

    /**
     * Determine if the event is a goal for the home team.
     *
     * @return bool
     */
    protected function isHomeTeamGoal()
    {
        $fixture = $this->fixture;
        return $this->team_id == $fixture->home_team_id;
    }
}
