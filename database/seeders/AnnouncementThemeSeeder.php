<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class AnnouncementThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            [
                'name'          => 'Dark Maintenance',
                'slug'          => 'maintenance-dark',
                'category'      => 'maintenance',
                'folder'        => 'dark',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Clean Maintenance',
                'slug'          => 'maintenance-clean',
                'category'      => 'maintenance',
                'folder'        => 'clean',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Elegant Event',
                'slug'          => 'event-elegant',
                'category'      => 'event',
                'folder'        => 'elegant',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Classic Event',
                'slug'          => 'event-classic',
                'category'      => 'event',
                'folder'        => 'classic',
                'preview_image' => null,
                'is_active'     => true,
            ],
        ];

        foreach ($themes as $theme) {
            Theme::updateOrCreate(['slug' => $theme['slug']], $theme);
        }

        $this->command->info('AnnouncementThemeSeeder: 4 announcement themes registered.');
    }
}
