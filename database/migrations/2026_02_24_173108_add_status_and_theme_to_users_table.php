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
        Schema::table('users', function (Blueprint $table): void {
            // pending | approved | rejected
            $table->string('status')->default('pending')->after('role');
            // Slug tema yang dipilih dari landing page (nullable)
            $table->string('selected_theme_slug')->nullable()->after('status');
            // Alasan penolakan oleh admin (nullable)
            $table->text('rejection_reason')->nullable()->after('selected_theme_slug');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['status', 'selected_theme_slug', 'rejection_reason']);
        });
    }
};
