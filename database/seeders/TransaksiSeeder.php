<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = collect([
            [
                'id' => Str::uuid(),
                'name' => 'Andi Wijaya',
                'email' => 'andi@example.com',
                'telephone' => '081234567890',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'telephone' => '081234567891',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Citra Dewi',
                'email' => 'citra@example.com',
                'telephone' => '081234567892',
            ],
        ]);

        foreach ($customers as $cust) {
            Customer::create($cust);
        }

        // Ambil id payment methode dan status transaction pertama
        $paymentMethodeId = DB::table('payment_methode')->first()->id ?? 1;
        $statusTransactionId = DB::table('status_transaction')->first()->id ?? 1;
        $ticket = DB::table('ticket')->first();

        if (!$ticket) {
            $this->command->warn("Seeder dihentikan: table ticket kosong.");
            return;
        }

        // Buat transaksi untuk setiap customer
        foreach (Customer::all() as $customer) {
            $transaction = Transaction::create([
                'id' => Str::uuid(),
                'code' => 'TRX-' . strtoupper(Str::random(6)),
                'midtrans_order_id' => 'ORDER-' . strtoupper(Str::random(8)),
                'midtrans_tr_id' => null,
                'total_price' => $ticket->price * 2, // contoh beli 2 tiket
                'customer_id' => $customer->id,
                'payment_methode_id' => $paymentMethodeId,
                'status_transaction_id' => $statusTransactionId,
            ]);

            TransactionDetail::create([
                'id' => Str::uuid(),
                'transaction_id' => $transaction->id,
                'ticket_id' => $ticket->id,
                'quantity' => 2,
                'price' => $ticket->price,
                'subtotal' => $ticket->price * 2,
            ]);
        }
    }
}
