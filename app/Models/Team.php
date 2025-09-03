<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

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

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function homeFixtures()
    {
        return $this->hasMany(Fixture::class, 'home_team_id');
    }

    public function awayFixtures()
    {
        return $this->hasMany(Fixture::class, 'away_team_id');
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }
}
