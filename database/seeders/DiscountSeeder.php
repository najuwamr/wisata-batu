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
                'total_qty' => null,
                'max_disc_amount' => 50000,
                'discount_percent'=>25,
                'start_date'=>'2025-10-10',
                'end_date'=>'2025-10-20',
                'image' => 'promo/newyear2025.jpg', // sesuaikan path
                'is_active' => true,
                'category' => 'periodik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Promo Akhir Pekan',
                'code' => 'WEEKEND50',
                'total_qty'=>10,
                'discount_percent'=>50,
                'max_disc_amount' => 50000,
                'start_date'=>'2025-10-10',
                'end_date'=>'2025-10-20',
                'description' => 'Dapatkan diskon 50% untuk pembelian tiket di akhir pekan.',
                'image' => 'promo/weekend50.jpg',
                'is_active' => true,
                'category' => 'nonperiodik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Spesial Pelajar',
                'code' => 'STUDENT26',
                'description' => 'Khusus pelajar, nikmati potongan harga 25% dengan menunjukkan kartu pelajar.',
                'discount_percent'=>25,
                'max_disc_amount' => 50000,
                'total_qty' => null,
                'start_date'=>'2025-10-10',
                'end_date'=>'2025-10-20',
                'image' => null,
                'is_active' => true,
                'category' => 'periodik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Spesial Pelajar',
                'code' => 'STUDENT25',
                'description' => 'Khusus pelajar, nikmati potongan harga 25% dengan menunjukkan kartu pelajar.',
                'total_qty'=>100,
                'max_disc_amount' => 50000,
                'discount_percent'=>25,
                'start_date'=>'2025-10-10',
                'end_date'=>'2025-10-20',
                'image' => null,
                'is_active' => true,
                'category' => 'nonperiodik',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
