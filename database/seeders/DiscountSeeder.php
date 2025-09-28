<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promo')->insert([
            [
                'id' => (string) Str::uuid(),
                'name' => 'Diskon Awal Tahun',
                'code' => 'NEWYEAR2025',
                'description' => 'Nikmati diskon spesial awal tahun untuk semua tiket!',
                'qty'=>10,
                'discount_percent'=>25,
                'valid_until'=>'2025-10-10',
                'image' => 'promo/newyear2025.jpg', // sesuaikan path
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Promo Akhir Pekan',
                'code' => 'WEEKEND50',
                'qty'=>10,
                'discount_percent'=>50,
                'valid_until'=>'2025-10-10',
                'description' => 'Dapatkan diskon 50% untuk pembelian tiket di akhir pekan.',
                'image' => 'promo/weekend50.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Spesial Pelajar',
                'code' => 'STUDENT25',
                'description' => 'Khusus pelajar, nikmati potongan harga 25% dengan menunjukkan kartu pelajar.',
                'qty'=>10,
                'discount_percent'=>25,
                'valid_until'=>'2025-10-10',
                'image' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
