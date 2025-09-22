<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_transaction')->insert([
            [
                'name' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'failed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'expired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
