<?php

namespace Database\Seeders;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@kauman.id')->first();

        if (!$admin) {
            $this->command->warn('⚠️ Admin tidak ditemukan. Jalankan AdminSeeder terlebih dahulu.');
            return;
        }

        $events = [
            // Completed Events (Past)
            [
                'title' => 'Rapat RT/RW Awal Tahun',
                'description' => 'Rapat koordinasi seluruh RT/RW Dusun Kauman membahas program kerja tahun 2026. Agenda meliputi evaluasi tahun sebelumnya dan penyusunan rencana kerja.',
                'event_date' => '2026-01-05',
                'start_time' => '09:00',
                'end_time' => '12:00',
                'location' => 'Balai Dusun Kauman',
                'status' => EventStatus::COMPLETED,
            ],
            [
                'title' => 'Pengajian Akbar Tahun Baru',
                'description' => 'Pengajian akbar dalam rangka menyambut tahun baru dengan tema "Muhasabah Diri". Pembicara: Ustadz H. Ahmad Fauzi.',
                'event_date' => '2026-01-08',
                'start_time' => '19:00',
                'end_time' => '22:00',
                'location' => 'Masjid Al-Ikhlas Kauman',
                'status' => EventStatus::COMPLETED,
            ],
            [
                'title' => 'Kerja Bakti Bersih Lingkungan',
                'description' => 'Kegiatan kerja bakti membersihkan lingkungan RT/RW. Warga diharapkan membawa peralatan kebersihan masing-masing.',
                'event_date' => '2026-01-09',
                'start_time' => '07:00',
                'end_time' => '11:00',
                'location' => 'Seluruh Area RT/RW Kauman',
                'status' => EventStatus::COMPLETED,
            ],

            // Ongoing Event (Today)
            [
                'title' => 'Posyandu Balita Bulanan',
                'description' => 'Kegiatan posyandu balita rutin bulanan. Layanan meliputi penimbangan, imunisasi, dan konsultasi gizi.',
                'event_date' => now()->toDateString(),
                'start_time' => '08:00',
                'end_time' => '12:00',
                'location' => 'Pos Posyandu RT 03',
                'status' => EventStatus::ONGOING,
            ],

            // Upcoming Events (Future)
            [
                'title' => 'Pengajian Rutin Mingguan',
                'description' => 'Pengajian rutin mingguan dengan tema "Menjaga Keharmonisan Keluarga". Terbuka untuk seluruh warga.',
                'event_date' => now()->addDays(3)->toDateString(),
                'start_time' => '19:00',
                'end_time' => '21:00',
                'location' => 'Masjid Al-Ikhlas Kauman',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Senam Sehat Bersama',
                'description' => 'Kegiatan senam sehat bersama untuk warga. Instruktur dari Puskesmas Kecamatan.',
                'event_date' => now()->addDays(5)->toDateString(),
                'start_time' => '06:00',
                'end_time' => '08:00',
                'location' => 'Lapangan Dusun Kauman',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Rapat Bulanan RT/RW',
                'description' => 'Rapat bulanan membahas perkembangan lingkungan dan rencana kegiatan bulan depan.',
                'event_date' => now()->addDays(7)->toDateString(),
                'start_time' => '19:30',
                'end_time' => '21:30',
                'location' => 'Balai Dusun Kauman',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Pelatihan Bank Sampah',
                'description' => 'Pelatihan pengelolaan bank sampah untuk warga. Narasumber dari Dinas Lingkungan Hidup.',
                'event_date' => now()->addDays(14)->toDateString(),
                'start_time' => '09:00',
                'end_time' => '12:00',
                'location' => 'Balai Dusun Kauman',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Arisan Ibu-ibu PKK',
                'description' => 'Kegiatan arisan rutin ibu-ibu PKK RT/RW Kauman.',
                'event_date' => now()->addDays(10)->toDateString(),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'location' => 'Rumah Ibu Ketua PKK',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Bakti Sosial Santunan Yatim',
                'description' => 'Kegiatan santunan untuk anak yatim di wilayah RW. Dana dari pengumpulan donasi warga.',
                'event_date' => now()->addDays(21)->toDateString(),
                'start_time' => '10:00',
                'end_time' => '12:00',
                'location' => 'Masjid Al-Ikhlas Kauman',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Ronda Malam Bersama',
                'description' => 'Kegiatan ronda malam bersama warga untuk menjaga keamanan lingkungan.',
                'event_date' => now()->addDays(2)->toDateString(),
                'start_time' => '22:00',
                'end_time' => '05:00',
                'location' => 'Pos Ronda RT 04',
                'status' => EventStatus::UPCOMING,
            ],
        ];

        foreach ($events as $event) {
            Event::create([
                ...$event,
                'created_by' => $admin->id,
            ]);
        }

        $this->command->info('✅ Kegiatan berhasil di-seed! (' . count($events) . ' kegiatan)');
    }
}
