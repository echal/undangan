<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name'       => 'Wedding Elegant',
                'slug'       => 'wedding-elegant',
                'event_type' => 'pernikahan',
                'status'     => true,
            ],
            [
                'name'       => 'Ramadan Glow',
                'slug'       => 'ramadan-glow',
                'event_type' => 'buka_puasa',
                'status'     => true,
            ],
            [
                'name'       => 'Workshop Modern',
                'slug'       => 'workshop-modern',
                'event_type' => 'workshop',
                'status'     => true,
            ],
            [
                'name'       => 'Government Clean',
                'slug'       => 'government-clean',
                'event_type' => 'kegiatan_kantor',
                'status'     => true,
            ],
            [
                'name'       => 'Corporate Modern',
                'slug'       => 'corporate-modern',
                'event_type' => 'rapat',
                'status'     => true,
            ],
            [
                'name'       => 'Executive Dark',
                'slug'       => 'executive-dark',
                'event_type' => 'pelatihan',
                'status'     => true,
            ],
        ];

        foreach ($templates as $template) {
            Template::updateOrCreate(['slug' => $template['slug']], $template);
        }
    }
}
