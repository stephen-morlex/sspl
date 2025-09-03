<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

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

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function fixtures()
    {
        return $this->belongsToMany(Fixture::class);
    }
}
