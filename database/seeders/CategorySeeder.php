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
                'name' => 'Kas Assyukro',
                'slug' => 'kas-assyukro',
                'description' => 'Keuangan utama organisasi PADRP ASSYUKRO',
                'icon' => '💰',
                'color' => 'teal',
            ],
            [
                'name' => 'Rutinan Mingguan',
                'slug' => 'rutinan-mingguan',
                'description' => 'Dana untuk kegiatan rutin setiap minggu',
                'icon' => '📆',
                'color' => 'green',
            ],
            [
                'name' => 'Rutinan Bulanan',
                'slug' => 'rutinan-bulanan',
                'description' => 'Dana untuk kegiatan rutin setiap bulan',
                'icon' => '📅',
                'color' => 'purple',
            ],
            [
                'name' => 'Keuangan Idul Fitri',
                'slug' => 'keuangan-idul-fitri',
                'description' => 'Dana khusus untuk kegiatan Idul Fitri',
                'icon' => '🌙',
                'color' => 'yellow',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
