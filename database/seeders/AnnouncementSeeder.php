<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\AnnouncementLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (! $admin) {
            $this->command->warn('Tidak ada user admin. Lewati AnnouncementSeeder.');
            return;
        }

        // Pengumuman 1: Published — Gangguan Database
        $a1 = Announcement::create([
            'title'            => 'Gangguan Layanan — Database Terjadwal',
            'body'             => "Kami akan melakukan pemeliharaan database terjadwal pada sistem undangan digital.\n\nSelama periode ini, halaman undangan mungkin tidak dapat diakses sementara. Tim kami bekerja keras untuk meminimalkan dampak terhadap pengguna.\n\nMohon maaf atas ketidaknyamanan ini.",
            'severity'         => 'warning',
            'status'           => 'published',
            'starts_at'        => now()->subHours(2),
            'ends_at'          => now()->addHours(1),
            'is_global_banner' => true,
            'created_by'       => $admin->id,
        ]);

        AnnouncementLog::create(['announcement_id' => $a1->id, 'message' => 'Tim engineering sedang menginvestigasi masalah performa database.', 'created_by' => $admin->id]);
        AnnouncementLog::create(['announcement_id' => $a1->id, 'message' => 'Penyebab diidentifikasi: query panjang pada tabel events. Rollback sedang dilakukan.', 'created_by' => $admin->id]);
        AnnouncementLog::create(['announcement_id' => $a1->id, 'message' => 'Perbaikan diterapkan. Sistem sedang dipantau.', 'created_by' => $admin->id]);

        // Pengumuman 2: Resolved — Pembaruan Selesai
        $a2 = Announcement::create([
            'title'            => 'Pembaruan Sistem v1.1 — Selesai',
            'body'             => "Pembaruan sistem versi 1.1 telah berhasil diterapkan.\n\nPembaruan ini mencakup peningkatan performa, perbaikan bug pada fitur RSVP, dan tambahan tema baru untuk undangan.",
            'severity'         => 'info',
            'status'           => 'resolved',
            'starts_at'        => now()->subDays(3),
            'ends_at'          => now()->subDays(2)->addHours(4),
            'is_global_banner' => false,
            'created_by'       => $admin->id,
        ]);

        AnnouncementLog::create(['announcement_id' => $a2->id, 'message' => 'Mulai deployment versi 1.1 ke server produksi.', 'created_by' => $admin->id]);
        AnnouncementLog::create(['announcement_id' => $a2->id, 'message' => 'Deployment selesai. Semua fitur berjalan normal.', 'created_by' => $admin->id]);

        // Pengumuman 3: Draft — Rencana Maintenance
        Announcement::create([
            'title'            => 'Pemeliharaan Infrastruktur — Maret 2026',
            'body'             => "Kami berencana melakukan pemeliharaan infrastruktur server pada bulan Maret 2026.\n\nDetail jadwal akan diumumkan H-3 sebelum maintenance dilakukan.",
            'severity'         => 'info',
            'status'           => 'draft',
            'starts_at'        => now()->addDays(14),
            'ends_at'          => now()->addDays(14)->addHours(3),
            'is_global_banner' => false,
            'created_by'       => $admin->id,
        ]);

        $this->command->info('AnnouncementSeeder: 3 demo announcements dibuat.');
    }
}
