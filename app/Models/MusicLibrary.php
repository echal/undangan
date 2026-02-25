<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MusicLibrary extends Model
{
    protected $table = 'music_library';

    protected $fillable = [
        'title',
        'artist',
        'file_path',
        'duration',
        'file_size',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration'  => 'integer',
        'file_size' => 'integer',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'music_id');
    }

    /**
     * URL lengkap untuk audio src (kompatibel dengan XAMPP subdirectory).
     */
    public function getUrlAttribute(): string
    {
        return rtrim(config('app.url'), '/') . '/storage/' . ltrim($this->file_path, '/');
    }

    /**
     * Ukuran file dalam format KB atau MB.
     */
    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) {
            return '';
        }
        $kb = $this->file_size / 1024;
        if ($kb < 1024) {
            return round($kb, 1) . ' KB';
        }
        return round($kb / 1024, 2) . ' MB';
    }

    /**
     * Durasi dalam format m:ss.
     */
    public function getDurationFormattedAttribute(): string
    {
        if (!$this->duration) {
            return '';
        }
        return sprintf('%d:%02d', intdiv($this->duration, 60), $this->duration % 60);
    }
}
