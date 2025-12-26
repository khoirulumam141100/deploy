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
        $admin = User::where('email', 'admin@gmail.com')->first();

        if (!$admin) {
            return;
        }

        $events = [
            // Completed Events (Past - earlier in 2025)
            [
                'title' => 'Rapat Kerja Tahunan 2025',
                'description' => 'Rapat kerja tahunan membahas program kerja PADRP ASSYUKRO tahun 2025. Agenda meliputi evaluasi program tahun sebelumnya, penyusunan anggaran, dan pembagian tugas pengurus.',
                'event_date' => '2025-01-15',
                'start_time' => '09:00',
                'end_time' => '12:00',
                'location' => 'Aula Balai Desa',
                'status' => EventStatus::COMPLETED,
            ],
            [
                'title' => 'Pengajian Akbar Awal Tahun',
                'description' => 'Pengajian akbar dalam rangka menyambut tahun baru dengan tema "Muhasabah Diri dan Persiapan Tahun Baru". Pembicara: Ustadz H. Ahmad Fauzi.',
                'event_date' => '2025-01-28',
                'start_time' => '19:00',
                'end_time' => '22:00',
                'location' => 'Masjid Al-Ikhlas',
                'status' => EventStatus::COMPLETED,
            ],
            [
                'title' => 'Kegiatan Bakti Sosial',
                'description' => 'Pembagian sembako dan santunan kepada warga kurang mampu di sekitar desa. Kegiatan ini rutin dilakukan setiap awal bulan.',
                'event_date' => '2025-02-05',
                'start_time' => '08:00',
                'end_time' => '11:00',
                'location' => 'Sekretariat PADRP ASSYUKRO',
                'status' => EventStatus::COMPLETED,
            ],
            [
                'title' => 'Pertemuan Rutin Mingguan',
                'description' => 'Pertemuan rutin anggota membahas perkembangan organisasi dan rencana kegiatan minggu depan.',
                'event_date' => '2025-02-12',
                'start_time' => '19:30',
                'end_time' => '21:30',
                'location' => 'Rumah Ketua RT 05',
                'status' => EventStatus::COMPLETED,
            ],

            // Ongoing Event (Today)
            [
                'title' => 'Olahraga Bersama Sekarang',
                'description' => 'Kegiatan olahraga bersama anggota PADRP ASSYUKRO untuk menjaga kesehatan dan mempererat silaturahmi. Olahraga: Senam pagi dan jalan sehat.',
                'event_date' => now()->toDateString(),
                'start_time' => '06:00',
                'end_time' => '08:00',
                'location' => 'Lapangan Desa',
                'status' => EventStatus::ONGOING,
            ],

            // Upcoming Events (Future)
            [
                'title' => 'Pengajian Rutin Bulanan',
                'description' => 'Pengajian rutin bulanan dengan tema "Menjaga Keharmonisan Keluarga". Wajib dihadiri seluruh anggota dan keluarga.',
                'event_date' => now()->addDays(3)->toDateString(),
                'start_time' => '19:00',
                'end_time' => '21:00',
                'location' => 'Masjid Al-Ikhlas',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Gotong Royong Bersih Desa',
                'description' => 'Kegiatan gotong royong membersihkan lingkungan desa dalam rangka menyambut bulan Ramadhan. Diharapkan partisipasi penuh seluruh anggota.',
                'event_date' => now()->addDays(7)->toDateString(),
                'start_time' => '07:00',
                'end_time' => '11:00',
                'location' => 'Seluruh Area Desa',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Pelatihan Keterampilan',
                'description' => 'Pelatihan keterampilan membuat kerajinan tangan dari bahan daur ulang. Narasumber dari Dinas UKM Kabupaten.',
                'event_date' => now()->addDays(14)->toDateString(),
                'start_time' => '09:00',
                'end_time' => '15:00',
                'location' => 'Balai Desa',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Santunan Anak Yatim',
                'description' => 'Kegiatan santunan untuk anak yatim di wilayah desa. Dana dari pengumpulan donasi anggota dan masyarakat.',
                'event_date' => now()->addDays(21)->toDateString(),
                'start_time' => '10:00',
                'end_time' => '12:00',
                'location' => 'Aula Masjid Al-Ikhlas',
                'status' => EventStatus::UPCOMING,
            ],
            [
                'title' => 'Musyawarah Besar PADRP',
                'description' => 'Musyawarah besar membahas perkembangan organisasi dan rencana program semester kedua. Seluruh anggota wajib hadir.',
                'event_date' => now()->addDays(30)->toDateString(),
                'start_time' => '08:00',
                'end_time' => '14:00',
                'location' => 'Aula Kecamatan',
                'status' => EventStatus::UPCOMING,
            ],
        ];

        foreach ($events as $event) {
            Event::create([
                ...$event,
                'created_by' => $admin->id,
            ]);
        }
    }
}
