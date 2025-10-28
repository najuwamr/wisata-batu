<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'discount_percent' => 25,
                'max_disc_amount' => 50000,
                'total_qty' => null,
                'daily_qty' => null,
                'used_qty' => 0,
                'start_date' => '2025-10-10 00:00:00',
                'end_date' => '2025-10-20 23:59:59',
                'image' => 'promo/newyear2025.jpg',
                'is_active' => true,
                'category' => 'periodik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Promo Akhir Pekan',
                'code' => 'WEEKEND50',
                'discount_percent' => 50,
                'max_disc_amount' => 50000,
                'total_qty' => 10,
                'daily_qty' => 5,
                'used_qty' => 0,
                'start_date' => '2025-10-10 00:00:00',
                'end_date' => '2025-10-20 23:59:59',
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
                'discount_percent' => 25,
                'max_disc_amount' => 50000,
                'total_qty' => null,
                'daily_qty' => null,
                'used_qty' => 0,
                'start_date' => '2025-10-10 00:00:00',
                'end_date' => '2025-10-20 23:59:59',
                'image' => null,
                'is_active' => true,
                'category' => 'periodik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Spesial Pelajar Nonperiodik',
                'code' => 'STUDENT25',
                'discount_percent' => 25,
                'max_disc_amount' => 50000,
                'total_qty' => 100,
                'daily_qty' => 20,
                'used_qty' => 0,
                'start_date' => '2025-10-10 00:00:00',
                'end_date' => '2025-10-20 23:59:59',
                'image' => null,
                'is_active' => true,
                'category' => 'nonperiodik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
