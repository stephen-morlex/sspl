<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends BaseModel
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'country',
        'season_start_year',
        'season_end_year',
        'logo_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'season_start_year' => 'integer',
        'season_end_year' => 'integer',
        'is_active' => 'boolean',
    ];

    public function fixtures(): HasMany
    {
        return $this->hasMany(Fixture::class);
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }
}
