<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            [
                'id' => Str::uuid(),
                'name' => 'Tiket Reguler',
                'description' => 'Tiket masuk reguler untuk pengunjung.',
                'price' => 250,
                'image' => 'p.jpg',
                'category' => 'tiket',
                'is_active' => true,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Tiket Paket Wahana',
                'description' => 'Tiket paket termasuk beberapa wahana.',
                'price' => 50000,
                'image' => 'p.jpg',
                'category' => 'tiket',
                'is_active' => true,
            ],
            [
                'price' => 10000,
                'image' => 'p.jpg',
                'category' => 'parkir',
                'is_active' => true,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Motor',
                'description' => 'Tiket parkir untuk motor.',
                'price' => 5000,
                'image' => 'p.jpg',
                'category' => 'parkir',
                'is_active' => true,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Bus',
                'description' => 'Tiket parkir untuk bus.',
                'price' => 20000,
                'image' => 'p.jpg',
                'category' => 'parkir',
                'is_active' => true,
            ],
        ];

        DB::table('ticket')->insert($tickets);
    }
}
