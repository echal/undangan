<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notice_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('nama');
            $table->string('nip', 30);
            $table->string('unit_kerja');
            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('total_target_asn')->default(0)->after('notice_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notice_reports');

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('total_target_asn');
        });
    }
};
