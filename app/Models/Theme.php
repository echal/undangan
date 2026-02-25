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

    /**
     * Cek apakah view untuk tema ini tersedia.
     */
    public function viewExists(): bool
    {
        return view()->exists("themes.{$this->folder}.index");
    }
}
