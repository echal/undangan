<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoticeReport extends Model
{
    protected $fillable = [
        'event_id',
        'nama',
        'nip',
        'unit_kerja',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
