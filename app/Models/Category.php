<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends BaseModel
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}