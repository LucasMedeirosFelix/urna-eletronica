<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    protected $fillable = [
        'name',
        'number',
        'party',
        'image',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}