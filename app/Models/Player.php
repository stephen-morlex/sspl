<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends BaseModel
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'first_name',
        'last_name',
        'team_id',
        'position',
        'shirt_number',
        'date_of_birth',
        'nationality',
        'height',
        'weight',
        'bio',
        'photo_path',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'integer',
        'weight' => 'integer',
        'is_active' => 'boolean',
        'shirt_number' => 'integer',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the statistics for the player.
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(Statistics::class);
    }
    
    /**
     * Get the player's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
