<?php

namespace Database\Seeders;

use App\Models\WasteType;
use Illuminate\Database\Seeder;

class WasteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wasteTypes = [
            [
                'name' => 'Plastik',
                'slug' => 'plastik',
                'description' => 'Sampah plastik seperti botol plastik, kantong plastik, wadah plastik, dll.',
                'price_per_kg' => 2000,
                'unit' => 'kg',
                'icon' => '♻️',
                'is_active' => true,
            ],
            [
                'name' => 'Kertas/Kardus',
                'slug' => 'kertas-kardus',
                'description' => 'Sampah kertas, kardus, koran, majalah, buku bekas, dll.',
                'price_per_kg' => 1500,
                'unit' => 'kg',
                'icon' => '📄',
                'is_active' => true,
            ],
            [
                'name' => 'Logam/Besi',
                'slug' => 'logam-besi',
                'description' => 'Sampah logam dan besi seperti paku, kawat, besi tua, dll.',
                'price_per_kg' => 5000,
                'unit' => 'kg',
                'icon' => '⚙️',
                'is_active' => true,
            ],
            [
                'name' => 'Botol Kaca',
                'slug' => 'botol-kaca',
                'description' => 'Sampah kaca seperti botol kaca, toples, gelas kaca, dll.',
                'price_per_kg' => 1000,
                'unit' => 'kg',
                'icon' => '🍾',
                'is_active' => true,
            ],
            [
                'name' => 'Aluminium/Kaleng',
                'slug' => 'aluminium-kaleng',
                'description' => 'Sampah aluminium dan kaleng seperti kaleng minuman, kaleng makanan, dll.',
                'price_per_kg' => 8000,
                'unit' => 'kg',
                'icon' => '🥫',
                'is_active' => true,
            ],
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Sampah elektronik (e-waste) seperti HP rusak, charger, kabel, dll.',
                'price_per_kg' => 3000,
                'unit' => 'kg',
                'icon' => '📱',
                'is_active' => true,
            ],
            [
                'name' => 'Minyak Jelantah',
                'slug' => 'minyak-jelantah',
                'description' => 'Minyak goreng bekas yang sudah tidak digunakan.',
                'price_per_kg' => 4000,
                'unit' => 'liter',
                'icon' => '🛢️',
                'is_active' => true,
            ],
        ];

        foreach ($wasteTypes as $type) {
            WasteType::updateOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }

        $this->command->info('✅ Jenis sampah berhasil di-seed! (' . count($wasteTypes) . ' jenis)');
    }
}
