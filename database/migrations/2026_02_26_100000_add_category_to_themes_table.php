<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            // category: 'event' untuk invitation themes, 'maintenance' untuk announcement themes
            $table->string('category')->default('event')->after('folder');
        });

        // Semua existing invitation themes sudah cover oleh default 'event'
        // tapi eksplisit update untuk memastikan
        DB::table('themes')->whereNull('category')->orWhere('category', '')->update(['category' => 'event']);
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
