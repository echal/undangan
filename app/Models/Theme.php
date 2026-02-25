<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'folder',
        'category',
        'preview_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    /**
     * Cek apakah view untuk tema ini tersedia.
     * Invitation themes: themes.{folder}.index
     * Announcement themes: themes.{category}.{folder}.index
     */
    public function viewExists(): bool
    {
        if ($this->category && $this->category !== 'event') {
            return view()->exists("themes.{$this->category}.{$this->folder}.index");
        }

        return view()->exists("themes.{$this->folder}.index");
    }
}
