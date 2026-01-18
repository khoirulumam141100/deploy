<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WasteDeposit;
use App\Models\WasteType;
use Illuminate\Database\Seeder;

class WasteDepositSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wasteTypes = WasteType::all();
        $residents = User::residents()->active()->get();

        if ($wasteTypes->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data jenis sampah. Jalankan WasteTypeSeeder terlebih dahulu.');
            return;
        }

        if ($residents->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data warga. Jalankan ResidentSeeder terlebih dahulu.');
            return;
        }

        $admin = User::where('role', 'admin')->first();
        $depositCount = 0;

        foreach ($residents as $resident) {
            // Each resident makes 2-5 deposits
            $numDeposits = rand(2, 5);

            for ($i = 0; $i < $numDeposits; $i++) {
                $wasteType = $wasteTypes->random();
                $weight = rand(10, 100) / 10; // 1.0 - 10.0 kg
                $pricePerKg = $wasteType->price_per_kg;
                $totalAmount = $weight * $pricePerKg;

                WasteDeposit::create([
                    'user_id' => $resident->id,
                    'waste_type_id' => $wasteType->id,
                    'weight' => $weight,
                    'price_per_kg' => $pricePerKg,
                    'total_amount' => $totalAmount,
                    'deposit_date' => now()->subDays(rand(1, 90)),
                    'notes' => $this->getRandomNote(),
                    'recorded_by' => $admin?->id,
                ]);

                // Update resident's waste balance
                $resident->waste_balance = ($resident->waste_balance ?? 0) + $totalAmount;
                $depositCount++;
            }

            $resident->save();
        }

        $this->command->info("✅ Setoran sampah berhasil di-seed! ({$depositCount} setoran)");
    }

    /**
     * Get random note for deposit.
     */
    private function getRandomNote(): ?string
    {
        $notes = [
            null,
            null,
            null,
            'Sampah dari rumah',
            'Sampah bulanan',
            'Hasil membersihkan gudang',
            'Sampah dari warung',
            'Botol bekas minuman',
            'Kardus bekas paket',
        ];

        return $notes[array_rand($notes)];
    }
}
