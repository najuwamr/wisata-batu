<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\CoreApi;
use Illuminate\Support\Str;
use Illuminates\Support\Facades\Storage;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Midtrans\Transaction as MidtransTransaction;

class TransaksiController extends Controller
{
    public function charge(Request $request)
    {
        // dd(session()->all());
        $checkout = session('checkout_data');

        if (!$checkout) {
            return response()->json(['error' => 'Checkout session tidak ditemukan'], 400);
        }

        $orderId = 'ORDER-' . strtoupper(uniqid());
        $grossAmount = $checkout['total'] ?? $request->gross_amount;

        session(['midtrans_order_id' => $orderId]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $checkout['name'],
                'email' => $checkout['email'],
                'phone' => $checkout['whatsapp'],
            ],
            'callbacks' => [
                'finish' => url('/payment/finish?order_id=' . $orderId),
            ],
        ];

        $paymentType = $request->input('payment_type');
        switch ($paymentType) {
            case 'bca_va':
            case 'bni_va':
            case 'bri_va':
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => explode('_', $paymentType)[0]];
                break;

            case 'mandiri_bill':
                $params['payment_type'] = 'echannel';
                $params['echannel'] = [
                    'bill_info1' => 'Payment',
                    'bill_info2' => 'Online Purchase',
                ];
                break;

            case 'qris':
                $params['payment_type'] = 'qris';
                break;

            case 'gopay':
            case 'shopeepay':
                $params['payment_type'] = $paymentType;
                $params[$paymentType] = [
                    'callback_url' => url('/payment/finish'),
                ];
                break;

            default:
                return response()->json(['error' => 'Metode pembayaran tidak valid'], 400);
        }

        try {
            DB::beginTransaction();

            // 1️⃣ Coba cari berdasarkan email
            $customer = Customer::where('email', $checkout['email'])->first();

            // 2️⃣ Kalau tidak ada, coba cari berdasarkan telepon
            if (!$customer) {
                $customer = Customer::where('telephone', $checkout['whatsapp'])->first();
            }

            // 3️⃣ Jika ada (entah dari email atau telepon), update data jika berbeda
            if ($customer) {
                $needsUpdate = false;

                if ($customer->name !== $checkout['name']) {
                    $customer->name = $checkout['name'];
                    $needsUpdate = true;
                }

                if ($customer->email !== $checkout['email']) {
                    $customer->email = $checkout['email'];
                    $needsUpdate = true;
                }

                if ($customer->telephone !== $checkout['whatsapp']) {
                    $customer->telephone = $checkout['whatsapp'];
                    $needsUpdate = true;
                }

                if ($needsUpdate) {
                    $customer->save();
                }
            }
            // 4️⃣ Jika belum ada sama sekali, buat baru
            else {
                $customer = Customer::create([
                    'name' => $checkout['name'],
                    'email' => $checkout['email'],
                    'telephone' => $checkout['whatsapp'],
                ]);
            }

            // 2️⃣ Simpan transaksi utama
            $today = now()->format('Y-m-d');

            do {
                $todayCount = Transaction::whereDate('created_at', $today)->count() + 1;
                $sequence = str_pad($todayCount % 1000, 3, '0', STR_PAD_LEFT); // reset tiap 1000
                $random = Str::upper(Str::random(6));
                $code = 'SLCT-' . $random . $sequence;
            } while (Transaction::where('code', $code)->exists());

            $transaction = Transaction::create([
                'code' => $code,
                'tanggal_kedatangan' => $checkout['date'],
                'midtrans_order_id' => $orderId,
                'total_price' => $grossAmount,
                'status' => 'pending',
                'customer_id' => $customer->id,
                'payment_methode_id' => $checkout['payment_methode_id'] ?? 1,
            ]);

            // 3️⃣ Simpan detail transaksi
           if (!empty($checkout['cart_items'])) {
                foreach ($checkout['cart_items'] as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'ticket_id' => $item['id'],
                        'quantity' => $item['qty'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }
            }

            // 4️⃣ Kirim ke Midtrans
            $charge = CoreApi::charge($params);

            // Update transaksi dengan data Midtrans
            $transaction->update([
                'midtrans_tr_id' => $charge->transaction_id ?? null,
                'status' => $charge->transaction_status ?? 'pending',
            ]);

            DB::commit();

            // 5️⃣ Response hasil pembayaran
            if (isset($charge->va_numbers)) {
                $va = $charge->va_numbers[0];
                return response()->json([
                    'status' => 'success',
                    'type' => 'va',
                    'bank' => strtoupper($va->bank),
                    'va_number' => $va->va_number,
                    'amount' => $charge->gross_amount,
                    'order_id' => $orderId,
                ]);
            }

            if (isset($charge->bill_key)) {
                return response()->json([
                    'status' => 'success',
                    'type' => 'mandiri',
                    'bill_key' => $charge->bill_key,
                    'biller_code' => $charge->biller_code,
                    'amount' => $charge->gross_amount,
                    'order_id' => $orderId,
                ]);
            }

            if (isset($charge->actions)) {
                return response()->json([
                    'status' => 'redirect',
                    'url' => $charge->actions[0]->url,
                    'order_id' => $orderId,
                ]);
            }

            return response()->json(['status' => 'unknown', 'data' => $charge]);

        } catch (\Exception $e) {
        DB::rollBack();
        }
    }

    // 📌 Webhook dari Midtrans
    public function notification(Request $request)
    {
        // Simpan notifikasi mentah dari Midtrans (untuk dicek manual kalau perlu)
        FacadesStorage::put('midtrans_notification.json', json_encode($request->all(), JSON_PRETTY_PRINT));

        $data = $request->all();

        try {
            // Ambil data penting dari payload Midtrans
            $orderId = $data['order_id'] ?? null;
            $transactionStatus = $data['transaction_status'] ?? null;
            $paymentType = $data['payment_type'] ?? null;
            $transactionTime = $data['transaction_time'] ?? now();

            // Validasi minimal
            if (!$orderId) {
                return response()->json(['message' => 'Missing order_id'], 400);
            }

            // Cari transaksi di database
            $transaction = Transaction::where('order_id', $orderId)->first();

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Mapping status dari Midtrans ke ENUM kamu
            $statusMap = [
                'capture'   => 'paid',
                'settlement'=> 'paid',
                'pending'   => 'pending',
                'deny'      => 'failed',
                'cancel'    => 'failed',
                'expire'    => 'failed',
                'failure'   => 'failed',
                // 'redeemed' nanti diatur manual oleh sistem kamu
            ];

            $finalStatus = $statusMap[$transactionStatus] ?? 'failed';

            // Update status transaksi di database
            $transaction->update([
                'status' => $finalStatus,
                'payment_type' => $paymentType,
                'transaction_time' => $transactionTime,
            ]);

            // Simpan hasil pemrosesan agar bisa dicek di file storage
            $result = [
                'order_id' => $orderId,
                'from' => $transactionStatus,
                'mapped_to' => $finalStatus,
                'payment_type' => $paymentType,
                'updated_at' => now()->toDateTimeString(),
            ];
            FacadesStorage::put('midtrans_processed.json', json_encode($result, JSON_PRETTY_PRINT));

            return response()->json(['message' => 'Notification processed successfully'], 200);

        } catch (\Throwable $e) {
            // Simpan error ke file biar bisa dilihat tanpa pakai Log
            $error = [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ];
            FacadesStorage::put('midtrans_error.json', json_encode($error, JSON_PRETTY_PRINT));

            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }


    // 📌 Callback redirect ke user
    public function finish(Request $request)
    {
        // Ambil order_id dari query kalau ada
        $orderId = $request->query('order_id');

        // Ambil transaksi sesuai order_id, kalau gak ada ambil yang terakhir
        $transaction = Transaction::when($orderId, function ($query) use ($orderId) {
                return $query->where('midtrans_order_id', $orderId);
            })
            ->with('customer') // pastikan relasi ke customer ada
            ->latest()
            ->first();

        if (!$transaction) {
            return redirect()->route('checkout.pembayaran')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Update status biar gak pending
        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'paid']);
        }

        // Kirim ke view
        return view('customer.finish', [
            'transaction' => $transaction,
            'customer' => $transaction->customer, // kirim juga relasinya
        ]);
    }


}
