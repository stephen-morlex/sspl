<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FixtureCoach extends BaseModel
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'fixture_id',
        'coach_id',
        'team_id',
    ];

    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixture::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
