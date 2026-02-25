<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'severity',
        'status',
        'starts_at',
        'ends_at',
        'is_global_banner',
        'theme_id',
        'design_settings',
        'og_image',
    ];

    protected $casts = [
        'starts_at'        => 'datetime',
        'ends_at'          => 'datetime',
        'is_global_banner' => 'boolean',
        'design_settings'  => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $base = Str::slug($model->title);
                $model->slug = $base . '-' . Str::lower(Str::random(6));
            }
        });
    }

    public function logs(): HasMany
    {
        return $this->hasMany(AnnouncementLog::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function getComputedStatusAttribute(): string
    {
        if ($this->status === 'published' && $this->ends_at && $this->ends_at->isPast()) {
            return 'resolved';
        }

        return $this->status;
    }

    public function getSeverityColorAttribute(): string
    {
        return match ($this->severity) {
            'warning'  => 'yellow',
            'critical' => 'red',
            default    => 'blue',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->computed_status) {
            'published' => 'green',
            'resolved'  => 'slate',
            'archived'  => 'gray',
            default     => 'yellow', // draft
        };
    }
}
