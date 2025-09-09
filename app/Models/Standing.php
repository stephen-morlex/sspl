<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends BaseModel
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'team_id',
        'league_id',
    ];

    // Remove the appended attributes that cause N+1 queries
    // protected $appends = [
    //     'played',
    //     'won',
    //     'drawn',
    //     'lost',
    //     'goals_for',
    //     'goals_against',
    //     'goal_difference',
    //     'points',
    //     'position',
    // ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    // Remove all the calculated attribute methods to prevent N+1 queries
    // The Livewire component will handle the calculations efficiently
}
