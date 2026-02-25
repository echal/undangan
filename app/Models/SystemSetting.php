<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'maintenance_type',
        'maintenance_start_at',
        'maintenance_end_at',
        'maintenance_title',
        'maintenance_message',
        'contact_email',
    ];

    protected $casts = [
        'maintenance_start_at' => 'datetime',
        'maintenance_end_at'   => 'datetime',
        'updated_at'           => 'datetime',
    ];

    public static function current(): static
    {
        $instance = static::query()->first();

        if ($instance) {
            return $instance;
        }

        return static::create([
            'maintenance_type'    => 'disabled',
            'maintenance_title'   => 'Sistem Sedang Maintenance',
            'maintenance_message' => 'Kami sedang melakukan peningkatan sistem.',
        ]);
    }

    public function isInMaintenance(): bool
    {
        return match ($this->maintenance_type) {
            'manual'    => true,
            'scheduled' => now()->between(
                $this->maintenance_start_at ?? now(),
                $this->maintenance_end_at   ?? now()
            ),
            default => false,
        };
    }
}
