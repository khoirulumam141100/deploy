<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Models\Category;
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
        $admin = User::where('email', 'admin@gmail.com')->first();

        if (!$admin) {
            return;
        }

        $categories = Category::all();

        // Sample transactions for each category
        $transactions = [
            // Kas Assyukro
            [
                'category_slug' => 'kas-assyukro',
                'transactions' => [
                    ['type' => TransactionType::INCOME, 'amount' => 5000000, 'description' => 'Iuran Anggota Bulan Januari', 'date' => '2025-01-05'],
                    ['type' => TransactionType::INCOME, 'amount' => 3000000, 'description' => 'Donasi dari Warga Desa', 'date' => '2025-01-10'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 500000, 'description' => 'Pembelian ATK Organisasi', 'date' => '2025-01-15'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 750000, 'description' => 'Biaya Listrik dan Air', 'date' => '2025-01-20'],
                    ['type' => TransactionType::INCOME, 'amount' => 2500000, 'description' => 'Iuran Anggota Bulan Februari', 'date' => '2025-02-05'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 1200000, 'description' => 'Renovasi Sekretariat', 'date' => '2025-02-10'],
                    ['type' => TransactionType::INCOME, 'amount' => 1000000, 'description' => 'Sumbangan Haji Ahmad', 'date' => '2025-02-15'],
                    ['type' => TransactionType::INCOME, 'amount' => 4500000, 'description' => 'Iuran Anggota Bulan Maret', 'date' => '2025-03-05'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 800000, 'description' => 'Pembelian Proyektor', 'date' => '2025-03-12'],
                    ['type' => TransactionType::INCOME, 'amount' => 2000000, 'description' => 'Dana Bantuan Pemerintah Desa', 'date' => '2025-03-20'],
                ],
            ],
            // Rutinan Mingguan
            [
                'category_slug' => 'rutinan-mingguan',
                'transactions' => [
                    ['type' => TransactionType::INCOME, 'amount' => 350000, 'description' => 'Iuran Rutinan Minggu Ke-1 Januari', 'date' => '2025-01-04'],
                    ['type' => TransactionType::INCOME, 'amount' => 400000, 'description' => 'Iuran Rutinan Minggu Ke-2 Januari', 'date' => '2025-01-11'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 150000, 'description' => 'Konsumsi Rapat Rutin', 'date' => '2025-01-11'],
                    ['type' => TransactionType::INCOME, 'amount' => 375000, 'description' => 'Iuran Rutinan Minggu Ke-3 Januari', 'date' => '2025-01-18'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 200000, 'description' => 'Transportasi Pengurus', 'date' => '2025-01-20'],
                    ['type' => TransactionType::INCOME, 'amount' => 425000, 'description' => 'Iuran Rutinan Minggu Ke-4 Januari', 'date' => '2025-01-25'],
                    ['type' => TransactionType::INCOME, 'amount' => 500000, 'description' => 'Iuran Rutinan Februari Minggu Ke-1', 'date' => '2025-02-01'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 175000, 'description' => 'Konsumsi Rapat Rutin', 'date' => '2025-02-08'],
                    ['type' => TransactionType::INCOME, 'amount' => 450000, 'description' => 'Iuran Rutinan Februari Minggu Ke-2', 'date' => '2025-02-08'],
                ],
            ],
            // Rutinan Bulanan
            [
                'category_slug' => 'rutinan-bulanan',
                'transactions' => [
                    ['type' => TransactionType::INCOME, 'amount' => 1500000, 'description' => 'Iuran Bulanan Januari', 'date' => '2025-01-01'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 300000, 'description' => 'Kegiatan Pengajian Bulanan', 'date' => '2025-01-15'],
                    ['type' => TransactionType::INCOME, 'amount' => 1750000, 'description' => 'Iuran Bulanan Februari', 'date' => '2025-02-01'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 450000, 'description' => 'Kegiatan Pengajian Bulanan + Tausiyah', 'date' => '2025-02-15'],
                    ['type' => TransactionType::INCOME, 'amount' => 1600000, 'description' => 'Iuran Bulanan Maret', 'date' => '2025-03-01'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 500000, 'description' => 'Bakti Sosial Bulanan', 'date' => '2025-03-10'],
                    ['type' => TransactionType::INCOME, 'amount' => 800000, 'description' => 'Sumbangan Sukarela', 'date' => '2025-03-15'],
                ],
            ],
            // Keuangan Idul Fitri
            [
                'category_slug' => 'keuangan-idul-fitri',
                'transactions' => [
                    ['type' => TransactionType::INCOME, 'amount' => 2000000, 'description' => 'Tabungan Idul Fitri Januari', 'date' => '2025-01-10'],
                    ['type' => TransactionType::INCOME, 'amount' => 2500000, 'description' => 'Tabungan Idul Fitri Februari', 'date' => '2025-02-10'],
                    ['type' => TransactionType::INCOME, 'amount' => 3000000, 'description' => 'Tabungan Idul Fitri Maret', 'date' => '2025-03-10'],
                    ['type' => TransactionType::INCOME, 'amount' => 5000000, 'description' => 'Donasi untuk Kegiatan Idul Fitri', 'date' => '2025-03-15'],
                    ['type' => TransactionType::EXPENSE, 'amount' => 1500000, 'description' => 'Persiapan Takjil Ramadhan', 'date' => '2025-03-01'],
                ],
            ],
        ];

        foreach ($transactions as $categoryData) {
            $category = $categories->where('slug', $categoryData['category_slug'])->first();

            if (!$category) {
                continue;
            }

            foreach ($categoryData['transactions'] as $trans) {
                Transaction::create([
                    'category_id' => $category->id,
                    'user_id' => $admin->id,
                    'type' => $trans['type'],
                    'amount' => $trans['amount'],
                    'description' => $trans['description'],
                    'transaction_date' => $trans['date'],
                ]);
            }
        }
    }
}
