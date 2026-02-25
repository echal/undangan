<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('maintenance_type', ['disabled', 'manual', 'scheduled'])->default('disabled');
            $table->dateTime('maintenance_start_at')->nullable();
            $table->dateTime('maintenance_end_at')->nullable();
            $table->string('maintenance_title')->default('Sistem Sedang Maintenance');
            $table->text('maintenance_message')->default('Kami sedang melakukan peningkatan sistem untuk memberikan pengalaman yang lebih baik.');
            $table->string('contact_email')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('system_settings')->insert([
            'maintenance_type'    => 'disabled',
            'maintenance_title'   => 'Sistem Sedang Maintenance',
            'maintenance_message' => 'Kami sedang melakukan peningkatan sistem untuk memberikan pengalaman yang lebih baik. Mohon bersabar sebentar.',
            'updated_at'          => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
