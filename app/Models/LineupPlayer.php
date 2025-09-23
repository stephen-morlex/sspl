<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LineupPlayer extends BaseModel
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'lineup_id',
        'player_id',
        'role',
        'position_on_pitch',
        'entered_at_minute',
        'substituted_out_minute',
    ];

    protected $casts = [
        'entered_at_minute' => 'integer',
        'substituted_out_minute' => 'integer',
    ];

    public function lineup(): BelongsTo
    {
        return $this->belongsTo(Lineup::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Check if this player has been substituted out.
     */
    public function isSubstituted(): bool
    {
        return $this->substituted_out_minute !== null;
    }

    /**
     * Check if this player is currently on the pitch.
     */
    public function isOnPitch(): bool
    {
        return $this->entered_at_minute !== null && $this->substituted_out_minute === null;
    }
}
