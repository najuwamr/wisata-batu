<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\CoreApi;
use Illuminate\Support\Str;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
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
        try {
            Log::info('=== MIDTRANS NOTIFICATION CALLBACK ===');
            Log::info('Request Method: ' . $request->method());
            Log::info('Request Headers:', $request->headers->all());
            Log::info('Raw Body: ' . $request->getContent());

            // Ambil body JSON
            $payload = $request->getContent();

            // Kalau test dari Midtrans kadang kosong, kita tetap return 200 agar tidak dianggap gagal
            if (empty($payload)) {
                Log::warning('⚠️ Empty payload received (possibly from test notification)');
                return response()->json(['message' => 'OK (empty payload received)'], 200);
            }

            // Decode JSON
            $notif = json_decode($payload, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('❌ JSON decode error: ' . json_last_error_msg());
                return response()->json(['error' => 'Invalid JSON format'], 400);
            }

            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Dapatkan notifikasi dari SDK
            $notifObject = new \Midtrans\Notification();

            $transactionStatus = $notifObject->transaction_status ?? null;
            $orderId = $notifObject->order_id ?? null;
            $paymentType = $notifObject->payment_type ?? null;
            $fraudStatus = $notifObject->fraud_status ?? null;
            $grossAmount = $notifObject->gross_amount ?? null;

            Log::info('Parsed Notification:', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'fraud_status' => $fraudStatus,
                'gross_amount' => $grossAmount,
            ]);

            // Jika tidak ada order_id, balas sukses tapi log
            if (!$orderId) {
                Log::warning('⚠️ No order_id in notification payload');
                return response()->json(['message' => 'No order_id found'], 200);
            }

            // Cek transaksi di DB
            $transaction = \App\Models\Transaction::where('midtrans_order_id', $orderId)->first();
            if (!$transaction) {
                Log::warning("⚠️ Transaction not found for order_id: {$orderId}");
                return response()->json(['message' => 'Transaction not found'], 200);
            }

            $oldStatus = $transaction->status;
            $newStatus = $oldStatus;

            // Update status berdasarkan notifikasi
            switch ($transactionStatus) {
                case 'capture':
                    $newStatus = ($paymentType === 'credit_card' && $fraudStatus === 'challenge')
                        ? 'pending'
                        : 'paid';
                    break;

                case 'settlement':
                    $newStatus = 'paid';
                    break;

                case 'pending':
                    $newStatus = 'pending';
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $newStatus = 'failed';
                    break;
            }

            if ($oldStatus !== $newStatus) {
                $transaction->update(['status' => $newStatus]);
                Log::info("✅ Transaction status updated: {$oldStatus} → {$newStatus}");
            } else {
                Log::info("ℹ️ No status change (still {$oldStatus})");
            }

            Log::info('=== NOTIFICATION PROCESSED SUCCESSFULLY ===');
            return response()->json(['message' => 'Notification processed successfully'], 200);

        } catch (\Exception $e) {
            Log::error('💥 MIDTRANS NOTIFICATION ERROR: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'error' => 'Exception occurred',
                'message' => $e->getMessage(),
            ], 500);
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
