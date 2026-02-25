<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('announcement_id');
            $table->foreign('announcement_id')
                  ->references('id')
                  ->on('announcements')
                  ->cascadeOnDelete();
            $table->text('message');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_logs');
    }
};
