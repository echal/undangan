<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // nullOnDelete: jika theme dihapus, announcement tetap ada (theme_id jadi NULL)
            $table->foreignId('theme_id')
                  ->nullable()
                  ->after('is_global_banner')
                  ->constrained('themes')
                  ->nullOnDelete();

            $table->json('design_settings')->nullable()->after('theme_id');
        });

        // Data lama: theme_id=NULL → StatusController fallback ke system-status lama (tidak error)
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeign(['theme_id']);
            $table->dropColumn(['theme_id', 'design_settings']);
        });
    }
};
