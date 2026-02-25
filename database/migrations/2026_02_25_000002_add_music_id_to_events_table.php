<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('music_id')
                  ->nullable()
                  ->constrained('music_library')
                  ->nullOnDelete()
                  ->after('background_music');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['music_id']);
            $table->dropColumn('music_id');
        });
    }
};
