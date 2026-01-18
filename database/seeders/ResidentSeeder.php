<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\ResidenceStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Rt;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rts = Rt::all();

        if ($rts->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data RT. Jalankan RwRtSeeder terlebih dahulu.');
            return;
        }

        $residents = [
            // RT 03 / RW 01
            [
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad.wijaya@gmail.com',
                'phone' => '081234567001',
                'address' => 'Jl. Mawar No. 1, RT 03/RW 01',
                'birth_date' => '1985-03-15',
                'gender' => Gender::MALE,
                'nik' => '3301010503850001',
                'rt_name' => 'RT 03',
                'rw_name' => 'RW 01',
                'residence_status' => ResidenceStatus::TETAP,
                'occupation' => 'Pedagang',
                'status' => UserStatus::ACTIVE,
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti.rahayu@gmail.com',
                'phone' => '081234567002',
                'address' => 'Jl. Mawar No. 2, RT 03/RW 01',
                'birth_date' => '1990-07-20',
                'gender' => Gender::FEMALE,
                'nik' => '3301012007900002',
                'rt_name' => 'RT 03',
                'rw_name' => 'RW 01',
                'residence_status' => ResidenceStatus::TETAP,
                'occupation' => 'Ibu Rumah Tangga',
                'status' => UserStatus::ACTIVE,
            ],
            // RT 04 / RW 01
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'phone' => '081234567003',
                'address' => 'Jl. Melati No. 5, RT 04/RW 01',
                'birth_date' => '1988-11-10',
                'gender' => Gender::MALE,
                'nik' => '3301011011880003',
                'rt_name' => 'RT 04',
                'rw_name' => 'RW 01',
                'residence_status' => ResidenceStatus::TETAP,
                'occupation' => 'Karyawan Swasta',
                'status' => UserStatus::ACTIVE,
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@gmail.com',
                'phone' => '081234567004',
                'address' => 'Jl. Melati No. 7, RT 04/RW 01',
                'birth_date' => '1992-05-25',
                'gender' => Gender::FEMALE,
                'nik' => '3301012505920004',
                'rt_name' => 'RT 04',
                'rw_name' => 'RW 01',
                'residence_status' => ResidenceStatus::KONTRAK,
                'occupation' => 'Guru',
                'status' => UserStatus::ACTIVE,
            ],
            // RT 01 / RW 02
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@gmail.com',
                'phone' => '081234567005',
                'address' => 'Jl. Anggrek No. 3, RT 01/RW 02',
                'birth_date' => '1982-09-08',
                'gender' => Gender::MALE,
                'nik' => '3301010809820005',
                'rt_name' => 'RT 01',
                'rw_name' => 'RW 02',
                'residence_status' => ResidenceStatus::TETAP,
                'occupation' => 'Wiraswasta',
                'status' => UserStatus::ACTIVE,
            ],
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri.handayani@gmail.com',
                'phone' => '081234567006',
                'address' => 'Jl. Anggrek No. 9, RT 01/RW 02',
                'birth_date' => '1995-12-30',
                'gender' => Gender::FEMALE,
                'nik' => '3301013012950006',
                'rt_name' => 'RT 01',
                'rw_name' => 'RW 02',
                'residence_status' => ResidenceStatus::KOS,
                'occupation' => 'Mahasiswa',
                'status' => UserStatus::ACTIVE,
            ],
            // RT 02 / RW 02
            [
                'name' => 'Gunawan Hidayat',
                'email' => 'gunawan.hidayat@gmail.com',
                'phone' => '081234567007',
                'address' => 'Jl. Dahlia No. 11, RT 02/RW 02',
                'birth_date' => '1978-04-17',
                'gender' => Gender::MALE,
                'nik' => '3301011704780007',
                'rt_name' => 'RT 02',
                'rw_name' => 'RW 02',
                'residence_status' => ResidenceStatus::TETAP,
                'occupation' => 'PNS',
                'status' => UserStatus::ACTIVE,
            ],
            [
                'name' => 'Heni Susanti',
                'email' => 'heni.susanti@gmail.com',
                'phone' => '081234567008',
                'address' => 'Jl. Dahlia No. 15, RT 02/RW 02',
                'birth_date' => '1989-02-14',
                'gender' => Gender::FEMALE,
                'nik' => '3301011402890008',
                'rt_name' => 'RT 02',
                'rw_name' => 'RW 02',
                'residence_status' => ResidenceStatus::TETAP,
                'occupation' => 'Dokter',
                'status' => UserStatus::ACTIVE,
            ],
            // Pending resident for testing
            [
                'name' => 'Irfan Maulana',
                'email' => 'irfan.maulana@gmail.com',
                'phone' => '081234567009',
                'address' => 'Jl. Kenanga No. 20, RT 03/RW 01',
                'birth_date' => '1998-08-22',
                'gender' => Gender::MALE,
                'nik' => '3301012208980009',
                'rt_name' => 'RT 03',
                'rw_name' => 'RW 01',
                'residence_status' => ResidenceStatus::KONTRAK,
                'occupation' => 'Karyawan',
                'status' => UserStatus::PENDING,
            ],
        ];

        foreach ($residents as $residentData) {
            // Find the RT
            $rt = Rt::whereHas('rw', function ($query) use ($residentData) {
                $query->where('name', $residentData['rw_name']);
            })->where('name', $residentData['rt_name'])->first();

            if (!$rt) {
                $this->command->warn("⚠️ RT {$residentData['rt_name']}/{$residentData['rw_name']} tidak ditemukan. Skip: {$residentData['name']}");
                continue;
            }

            User::updateOrCreate(
                ['email' => $residentData['email']],
                [
                    'name' => $residentData['name'],
                    'password' => Hash::make('password123'),
                    'phone' => $residentData['phone'],
                    'address' => $residentData['address'],
                    'birth_date' => $residentData['birth_date'],
                    'gender' => $residentData['gender'],
                    'nik' => $residentData['nik'],
                    'rt_id' => $rt->id,
                    'rw_id' => $rt->rw_id,
                    'residence_status' => $residentData['residence_status'],
                    'occupation' => $residentData['occupation'],
                    'role' => UserRole::ANGGOTA,
                    'status' => $residentData['status'],
                    'joined_at' => $residentData['status'] === UserStatus::ACTIVE ? now()->subDays(rand(30, 365)) : null,
                    'waste_balance' => 0,
                ]
            );
        }

        $this->command->info('✅ Warga berhasil di-seed! (' . count($residents) . ' warga)');
        $this->command->info('   Password default: password123');
    }
}
