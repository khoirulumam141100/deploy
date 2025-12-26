<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            // Active Members
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@gmail.com',
                'phone' => '081234567893',
                'address' => 'Jl. Melati No. 10, RT 02/RW 05, Desa Sukamaju',
                'birth_date' => '1988-03-15',
                'gender' => Gender::MALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-01-15',
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti.rahmawati@gmail.com',
                'phone' => '081234567894',
                'address' => 'Jl. Mawar No. 25, RT 03/RW 02, Desa Sukamaju',
                'birth_date' => '1992-07-22',
                'gender' => Gender::FEMALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-02-20',
            ],
            [
                'name' => 'Muhammad Rizki',
                'email' => 'muhammad.rizki@gmail.com',
                'phone' => '081234567895',
                'address' => 'Jl. Dahlia No. 8, RT 01/RW 03, Desa Sukamaju',
                'birth_date' => '1995-11-30',
                'gender' => Gender::MALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-04-10',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@gmail.com',
                'phone' => '081234567896',
                'address' => 'Jl. Anggrek No. 15, RT 04/RW 01, Desa Sukamaju',
                'birth_date' => '1990-05-18',
                'gender' => Gender::FEMALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-05-25',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'phone' => '081234567897',
                'address' => 'Jl. Kenanga No. 33, RT 02/RW 04, Desa Sukamaju',
                'birth_date' => '1985-09-08',
                'gender' => Gender::MALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-06-15',
            ],
            [
                'name' => 'Nur Hidayah',
                'email' => 'nur.hidayah@gmail.com',
                'phone' => '081234567898',
                'address' => 'Jl. Seroja No. 7, RT 05/RW 02, Desa Sukamaju',
                'birth_date' => '1993-12-25',
                'gender' => Gender::FEMALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-07-01',
            ],
            [
                'name' => 'Hasan Abdullah',
                'email' => 'hasan.abdullah@gmail.com',
                'phone' => '081234567899',
                'address' => 'Jl. Cempaka No. 12, RT 01/RW 05, Desa Sukamaju',
                'birth_date' => '1987-04-12',
                'gender' => Gender::MALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-08-20',
            ],
            [
                'name' => 'Fatimah Zahra',
                'email' => 'fatimah.zahra@gmail.com',
                'phone' => '081234567900',
                'address' => 'Jl. Teratai No. 20, RT 03/RW 03, Desa Sukamaju',
                'birth_date' => '1998-02-14',
                'gender' => Gender::FEMALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-09-05',
            ],
            [
                'name' => 'Umar Faruq',
                'email' => 'umar.faruq@gmail.com',
                'phone' => '081234567901',
                'address' => 'Jl. Flamboyan No. 5, RT 04/RW 04, Desa Sukamaju',
                'birth_date' => '1991-08-28',
                'gender' => Gender::MALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-10-15',
            ],
            [
                'name' => 'Aisyah Putri',
                'email' => 'aisyah.putri@gmail.com',
                'phone' => '081234567902',
                'address' => 'Jl. Kamboja No. 18, RT 02/RW 01, Desa Sukamaju',
                'birth_date' => '1996-06-03',
                'gender' => Gender::FEMALE,
                'status' => UserStatus::ACTIVE,
                'joined_at' => '2025-11-10',
            ],

            // Pending Members
            [
                'name' => 'Ridwan Hakim',
                'email' => 'ridwan.hakim@gmail.com',
                'phone' => '081234567903',
                'address' => 'Jl. Bougenville No. 22, RT 05/RW 03, Desa Sukamaju',
                'birth_date' => '1994-10-17',
                'gender' => Gender::MALE,
                'status' => UserStatus::PENDING,
                'joined_at' => null,
            ],
            [
                'name' => 'Khadijah Amina',
                'email' => 'khadijah.amina@gmail.com',
                'phone' => '081234567904',
                'address' => 'Jl. Tulip No. 9, RT 01/RW 02, Desa Sukamaju',
                'birth_date' => '1999-01-25',
                'gender' => Gender::FEMALE,
                'status' => UserStatus::PENDING,
                'joined_at' => null,
            ],
            [
                'name' => 'Ibrahim Malik',
                'email' => 'ibrahim.malik@gmail.com',
                'phone' => '081234567905',
                'address' => 'Jl. Sakura No. 14, RT 03/RW 05, Desa Sukamaju',
                'birth_date' => '1997-07-08',
                'gender' => Gender::MALE,
                'status' => UserStatus::PENDING,
                'joined_at' => null,
            ],

            // Inactive Member
            [
                'name' => 'Yusuf Hamid',
                'email' => 'yusuf.hamid@gmail.com',
                'phone' => '081234567906',
                'address' => 'Jl. Lily No. 30, RT 04/RW 02, Desa Sukamaju',
                'birth_date' => '1989-11-11',
                'gender' => Gender::MALE,
                'status' => UserStatus::INACTIVE,
                'joined_at' => '2025-03-10',
                'rejection_reason' => 'Pindah domisili ke luar kota',
            ],
        ];

        foreach ($members as $member) {
            User::updateOrCreate(
                ['email' => $member['email']],
                [
                    ...$member,
                    'password' => Hash::make('password123'),
                    'role' => UserRole::ANGGOTA,
                ]
            );
        }
    }
}
