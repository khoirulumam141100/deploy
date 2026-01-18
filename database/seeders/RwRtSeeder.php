<?php

namespace Database\Seeders;

use App\Models\Rw;
use App\Models\Rt;
use Illuminate\Database\Seeder;

class RwRtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // RW 01 dengan RT 03 dan RT 04
        $rw1 = Rw::updateOrCreate(
            ['name' => 'RW 01'],
            ['description' => 'Rukun Warga 01 Dusun Kauman, Desa Deras']
        );

        Rt::updateOrCreate(
            ['rw_id' => $rw1->id, 'name' => 'RT 03'],
            ['description' => 'Rukun Tetangga 03']
        );

        Rt::updateOrCreate(
            ['rw_id' => $rw1->id, 'name' => 'RT 04'],
            ['description' => 'Rukun Tetangga 04']
        );

        // RW 02 dengan RT 01 dan RT 02
        $rw2 = Rw::updateOrCreate(
            ['name' => 'RW 02'],
            ['description' => 'Rukun Warga 02 Dusun Kauman, Desa Deras']
        );

        Rt::updateOrCreate(
            ['rw_id' => $rw2->id, 'name' => 'RT 01'],
            ['description' => 'Rukun Tetangga 01']
        );

        Rt::updateOrCreate(
            ['rw_id' => $rw2->id, 'name' => 'RT 02'],
            ['description' => 'Rukun Tetangga 02']
        );

        $this->command->info('✅ RW dan RT berhasil di-seed!');
        $this->command->info('   - RW 01: RT 03, RT 04');
        $this->command->info('   - RW 02: RT 01, RT 02');
    }
}
