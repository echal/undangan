<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            [
                'name'          => 'Minimal',
                'slug'          => 'minimal',
                'folder'        => 'minimal',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Sakura',
                'slug'          => 'sakura',
                'folder'        => 'sakura',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Ramadan Glow',
                'slug'          => 'ramadan-glow',
                'folder'        => 'ramadan-glow',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Workshop Digital AI',
                'slug'          => 'workshop-ai',
                'folder'        => 'workshop-ai',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Wedding Elegant',
                'slug'          => 'wedding-elegant',
                'folder'        => 'wedding-elegant',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Workshop Modern',
                'slug'          => 'workshop-modern',
                'folder'        => 'workshop-modern',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Government Clean',
                'slug'          => 'government-clean',
                'folder'        => 'government-clean',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Corporate Modern',
                'slug'          => 'corporate-modern',
                'folder'        => 'corporate-modern',
                'preview_image' => null,
                'is_active'     => true,
            ],
            [
                'name'          => 'Executive Dark',
                'slug'          => 'executive-dark',
                'folder'        => 'executive-dark',
                'preview_image' => null,
                'is_active'     => true,
            ],
        ];

        foreach ($themes as $theme) {
            Theme::updateOrCreate(['slug' => $theme['slug']], $theme);
        }
    }
}
