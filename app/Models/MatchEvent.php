<?php

namespace App\Models;

use App\Events\MatchEventCreated;
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
    ];

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
}