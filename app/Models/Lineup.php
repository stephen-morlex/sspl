<?php

namespace App\Models;

use App\Enums\LineupStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lineup extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'fixture_id',
        'team_id',
        'player_id',
        'position',
        'is_starting',
        'status',
    ];

    protected $casts = [
        'is_starting' => 'boolean',
        'status' => LineupStatus::class,
    ];

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
