<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wish extends Model
{
    protected $fillable = [
        'event_id',
        'guest_name',
        'message',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
