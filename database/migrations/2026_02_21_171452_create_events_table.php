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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->string('bride_name');
            $table->string('groom_name');
            $table->datetime('event_date');
            $table->text('location');
            $table->string('maps_link')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('music')->nullable();
            $table->boolean('is_published')->default(false);
            $table->datetime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
