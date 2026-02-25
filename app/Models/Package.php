<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
