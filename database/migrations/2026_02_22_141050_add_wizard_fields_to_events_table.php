<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('event_type')->nullable()->after('theme_id');
            $table->json('event_data')->nullable()->after('event_type');
            $table->string('banner_image')->nullable()->after('cover_image');
            $table->json('gallery_images')->nullable()->after('banner_image');
            $table->boolean('rsvp_enabled')->default(true)->after('gallery_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['event_type', 'event_data', 'banner_image', 'gallery_images', 'rsvp_enabled']);
        });
    }
};
