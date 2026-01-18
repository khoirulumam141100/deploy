<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Rt;
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
            ['email' => 'admin@kauman.id'],
            [
                'name' => 'Administrator Kauman',
                'password' => Hash::make('password123'),
                'phone' => '081234567890',
                'address' => 'Kantor RT/RW Dusun Kauman',
                'birth_date' => '1990-01-01',
                'gender' => Gender::MALE,
                'role' => UserRole::ADMIN,
                'status' => UserStatus::ACTIVE,
                'joined_at' => now(),
                'nik' => null,
                'rt_id' => null,
                'rw_id' => null,
                'residence_status' => 'tetap',
                'occupation' => 'Administrator',
                'waste_balance' => 0,
            ]
        );

        $this->command->info('✅ Admin berhasil dibuat!');
        $this->command->info('   Email: admin@kauman.id');
        $this->command->info('   Password: password123');
    }
}
