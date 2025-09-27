<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methode')->insert([
            [
                'type' => 'Bank Transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'E-Wallet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Credit Card',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Virtual Account',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
