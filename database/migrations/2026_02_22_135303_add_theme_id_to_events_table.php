<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('theme_id')
                  ->nullable()
                  ->after('template_id')
                  ->constrained('themes')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Theme::class);
            $table->dropColumn('theme_id');
        });
    }
};
