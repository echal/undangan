<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'template_id',
        'theme_id',
        'event_type',
        'notice_level',
        'total_target_asn',
        'official_document',
        'event_data',
        'title',
        'slug',
        'bride_name',
        'groom_name',
        'event_date',
        'location',
        'maps_link',
        'cover_image',
        'banner_image',
        'gallery_images',
        'background_music',
        'music_id',
        'rsvp_enabled',
        'is_published',
        'enable_cover',
        'expired_at',
    ];

    protected $casts = [
        'event_date'     => 'datetime',
        'expired_at'     => 'datetime',
        'is_published'   => 'boolean',
        'rsvp_enabled'   => 'boolean',
        'enable_cover'   => 'boolean',
        'event_data'     => 'array',
        'gallery_images' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function musicTrack(): BelongsTo
    {
        return $this->belongsTo(MusicLibrary::class, 'music_id');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class);
    }

    public function noticeReports(): HasMany
    {
        return $this->hasMany(NoticeReport::class);
    }

    public function isExpired(): bool
    {
        return $this->expired_at !== null && $this->expired_at->isPast();
    }

    public function getStatusLabelAttribute(): string
    {
        if (! $this->is_published) {
            return 'draft';
        }

        if ($this->isExpired()) {
            return 'expired';
        }

        return 'aktif';
    }
}
