<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends BaseModel
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'news_tag')
            ->withTimestamps();
    }
}