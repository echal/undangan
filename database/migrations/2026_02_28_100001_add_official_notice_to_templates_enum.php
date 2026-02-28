<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE templates MODIFY COLUMN event_type
            ENUM('pernikahan','buka_puasa','workshop','kegiatan_kantor','rapat','pelatihan','official_notice')
            NOT NULL DEFAULT 'pernikahan'");

        \App\Models\Template::updateOrCreate(
            ['slug' => 'official-notice-default'],
            [
                'name'       => 'Pemberitahuan Kedinasan',
                'slug'       => 'official-notice-default',
                'event_type' => 'official_notice',
                'status'     => true,
            ]
        );
    }

    public function down(): void
    {
        \App\Models\Template::where('slug', 'official-notice-default')->delete();

        DB::statement("ALTER TABLE templates MODIFY COLUMN event_type
            ENUM('pernikahan','buka_puasa','workshop','kegiatan_kantor','rapat','pelatihan')
            NOT NULL DEFAULT 'pernikahan'");
    }
};
