<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kas RT',
                'slug' => 'kas-rt',
                'description' => 'Dana utama RT dari iuran warga',
                'icon' => '💰',
                'color' => 'teal',
            ],
            [
                'name' => 'Dana Sosial',
                'slug' => 'dana-sosial',
                'description' => 'Dana untuk bantuan warga (sakit, duka, dll)',
                'icon' => '🤝',
                'color' => 'blue',
            ],
            [
                'name' => 'Keuangan Kegiatan',
                'slug' => 'keuangan-kegiatan',
                'description' => 'Anggaran untuk acara dan kegiatan RT/RW',
                'icon' => '📅',
                'color' => 'purple',
            ],
            [
                'name' => 'Iuran Kebersihan',
                'slug' => 'iuran-kebersihan',
                'description' => 'Dana untuk sampah dan kebersihan lingkungan',
                'icon' => '🧹',
                'color' => 'green',
            ],
            [
                'name' => 'Dana Keamanan',
                'slug' => 'dana-keamanan',
                'description' => 'Dana untuk ronda dan satpam lingkungan',
                'icon' => '🛡️',
                'color' => 'orange',
            ],
            [
                'name' => 'Bank Sampah',
                'slug' => 'bank-sampah',
                'description' => 'Pendapatan dari pengelolaan bank sampah',
                'icon' => '♻️',
                'color' => 'emerald',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('✅ Kategori keuangan berhasil di-seed! (' . count($categories) . ' kategori)');
    }
}
