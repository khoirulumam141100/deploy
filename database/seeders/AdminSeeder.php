<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'phone' => '081234567890',
                'address' => 'Kantor PADRP ASSYUKRO',
                'birth_date' => '1990-01-01',
                'gender' => Gender::MALE,
                'role' => UserRole::ADMIN,
                'status' => UserStatus::ACTIVE,
                'joined_at' => now(),
            ]
        );

        // Create a sample member for testing
        User::updateOrCreate(
            ['email' => 'anggota@gmail.com'],
            [
                'name' => 'Anggota Demo',
                'password' => Hash::make('password123'),
                'phone' => '081234567891',
                'address' => 'Jl. Contoh No. 123, Desa Contoh',
                'birth_date' => '1995-06-15',
                'gender' => Gender::MALE,
                'role' => UserRole::ANGGOTA,
                'status' => UserStatus::ACTIVE,
                'joined_at' => now(),
            ]
        );

        // Create a pending member for testing approval flow
        User::updateOrCreate(
            ['email' => 'pending@gmail.com'],
            [
                'name' => 'Calon Anggota',
                'password' => Hash::make('password123'),
                'phone' => '081234567892',
                'address' => 'Jl. Pendaftaran No. 456, Desa Baru',
                'birth_date' => '2000-03-20',
                'gender' => Gender::FEMALE,
                'role' => UserRole::ANGGOTA,
                'status' => UserStatus::PENDING,
                'joined_at' => null,
            ]
        );
    }
}
