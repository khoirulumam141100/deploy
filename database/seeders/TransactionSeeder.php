<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Models\Category;
use App\Models\Rt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
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

        $categories = Category::all();
        $rts = Rt::all();

        if ($rts->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data RT. Jalankan RwRtSeeder terlebih dahulu.');
            return;
        }

        // Transactions per RT per category
        $transactionTemplates = [
            // Kas RT
            'kas-rt' => [
                ['type' => TransactionType::INCOME, 'amount' => 5000000, 'description' => 'Iuran Warga Bulan Januari'],
                ['type' => TransactionType::INCOME, 'amount' => 3000000, 'description' => 'Donasi dari Warga'],
                ['type' => TransactionType::EXPENSE, 'amount' => 500000, 'description' => 'Pembelian ATK'],
                ['type' => TransactionType::EXPENSE, 'amount' => 750000, 'description' => 'Biaya Listrik Pos'],
                ['type' => TransactionType::INCOME, 'amount' => 4500000, 'description' => 'Iuran Warga Bulan Februari'],
            ],
            // Dana Sosial
            'dana-sosial' => [
                ['type' => TransactionType::INCOME, 'amount' => 2000000, 'description' => 'Sumbangan Dana Sosial'],
                ['type' => TransactionType::EXPENSE, 'amount' => 500000, 'description' => 'Bantuan Warga Sakit'],
                ['type' => TransactionType::EXPENSE, 'amount' => 1000000, 'description' => 'Santunan Duka Cita'],
                ['type' => TransactionType::INCOME, 'amount' => 1500000, 'description' => 'Donasi untuk Dana Sosial'],
            ],
            // Keuangan Kegiatan
            'keuangan-kegiatan' => [
                ['type' => TransactionType::INCOME, 'amount' => 3000000, 'description' => 'Dana Kegiatan 17 Agustus'],
                ['type' => TransactionType::EXPENSE, 'amount' => 1500000, 'description' => 'Konsumsi Acara 17 Agustus'],
                ['type' => TransactionType::EXPENSE, 'amount' => 800000, 'description' => 'Dekorasi dan Perlengkapan'],
                ['type' => TransactionType::INCOME, 'amount' => 2000000, 'description' => 'Sponsor Kegiatan'],
            ],
            // Iuran Kebersihan
            'iuran-kebersihan' => [
                ['type' => TransactionType::INCOME, 'amount' => 1000000, 'description' => 'Iuran Kebersihan Januari'],
                ['type' => TransactionType::EXPENSE, 'amount' => 300000, 'description' => 'Gaji Petugas Kebersihan'],
                ['type' => TransactionType::EXPENSE, 'amount' => 200000, 'description' => 'Pembelian Alat Kebersihan'],
                ['type' => TransactionType::INCOME, 'amount' => 1000000, 'description' => 'Iuran Kebersihan Februari'],
            ],
            // Dana Keamanan
            'dana-keamanan' => [
                ['type' => TransactionType::INCOME, 'amount' => 1500000, 'description' => 'Iuran Keamanan Januari'],
                ['type' => TransactionType::EXPENSE, 'amount' => 500000, 'description' => 'Honor Petugas Ronda'],
                ['type' => TransactionType::EXPENSE, 'amount' => 200000, 'description' => 'Konsumsi Ronda'],
                ['type' => TransactionType::INCOME, 'amount' => 1500000, 'description' => 'Iuran Keamanan Februari'],
            ],
            // Bank Sampah
            'bank-sampah' => [
                ['type' => TransactionType::INCOME, 'amount' => 500000, 'description' => 'Penjualan Sampah ke Pengepul'],
                ['type' => TransactionType::INCOME, 'amount' => 750000, 'description' => 'Hasil Penjualan Plastik'],
                ['type' => TransactionType::EXPENSE, 'amount' => 100000, 'description' => 'Operasional Bank Sampah'],
            ],
        ];

        $transactionCount = 0;

        foreach ($rts as $rt) {
            foreach ($transactionTemplates as $categorySlug => $transactions) {
                $category = $categories->where('slug', $categorySlug)->first();

                if (!$category) {
                    continue;
                }

                foreach ($transactions as $index => $trans) {
                    // Randomize date within last 3 months
                    $date = now()->subDays(rand(1, 90))->toDateString();

                    Transaction::create([
                        'category_id' => $category->id,
                        'user_id' => $admin->id,
                        'rt_id' => $rt->id,
                        'type' => $trans['type'],
                        'amount' => $trans['amount'] + rand(-100000, 100000), // Add some variance
                        'description' => $trans['description'] . ' - ' . $rt->name,
                        'transaction_date' => $date,
                    ]);

                    $transactionCount++;
                }
            }
        }

        $this->command->info("✅ Transaksi berhasil di-seed! ({$transactionCount} transaksi)");
    }
}
