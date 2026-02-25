<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'phone',
        'rsvp_status',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
