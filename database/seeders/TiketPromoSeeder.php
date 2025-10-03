<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiketPromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promo = DB::table('promo')->pluck('id', 'code');
        $ticket = DB::table('ticket')->pluck('id', 'name');

        DB::table('ticket_promo')->insert([
            [
                'ticket_id' => $ticket['Tiket Masuk Dewasa'],
                'promo_id'  => $promo['WEEKEND50'],
            ],
            [
                'ticket_id' => $ticket['Tiket Masuk Anak'],
                'promo_id'  => $promo['STUDENT20'],
            ],
        ]);
    }
}
