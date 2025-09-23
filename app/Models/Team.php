<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends BaseModel
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'name',
        'short_name',
        'logo_path',
        'city',
        'stadium',
        'founded_year',
        'description',
    ];

    protected $casts = [
        'founded_year' => 'integer',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function coach(): HasOne
    {
        return $this->hasOne(Coach::class);
    }

    public function homeFixtures(): HasMany
    {
        return $this->hasMany(Fixture::class, 'home_team_id');
    }

    public function awayFixtures(): HasMany
    {
        return $this->hasMany(Fixture::class, 'away_team_id');
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    /**
     * Get the lineups for this team.
     */
    public function lineups(): HasMany
    {
        return $this->hasMany(Lineup::class);
    }

    /**
     * Get the fixture coaches for this team.
     */
    public function fixtureCoaches(): HasMany
    {
        return $this->hasMany(FixtureCoach::class);
    }
}
