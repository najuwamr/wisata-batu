<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\CoreApi;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

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

            $transaction = Transaction::create([
                'code' => 'TRX-' . now()->format('Ymd-His'),
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
                        'quantity' => $item['qty'], // bukan quantity
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
            Log::info('Request Content: ' . $request->getContent());

            // ✅ CARA 1: Manual parsing (lebih reliable)
            $notificationPayload = $request->getContent();
            Log::info('Raw Notification Payload: ' . $notificationPayload);

            if (empty($notificationPayload)) {
                Log::error('Empty notification payload');
                return response()->json(['error' => 'Empty payload'], 400);
            }

            $notif = json_decode($notificationPayload);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error: ' . json_last_error_msg());
                return response()->json(['error' => 'Invalid JSON'], 400);
            }

            // ✅ Extract data dari payload
            $transactionStatus = $notif->transaction_status ?? null;
            $orderId = $notif->order_id ?? null;
            $paymentType = $notif->payment_type ?? null;
            $fraudStatus = $notif->fraud_status ?? null;

            Log::info('Parsed Notification:', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'fraud_status' => $fraudStatus
            ]);

            // ✅ Validasi data penting
            if (!$orderId || !$transactionStatus) {
                Log::error('Missing required fields in notification');
                return response()->json(['error' => 'Missing required fields'], 400);
            }

            // ✅ Cari transaksi
            $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

            if (!$transaction) {
                Log::error("Transaction not found for order_id: " . $orderId);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            Log::info("Transaction found - ID: {$transaction->id}, Current Status: {$transaction->status}");

            // ✅ Update status transaksi
            $newStatus = $transaction->status; // default ke status lama

            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    $newStatus = ($fraudStatus == 'challenge') ? 'pending' : 'paid';
                } else {
                    $newStatus = 'paid';
                }
            } elseif ($transactionStatus == 'settlement') {
                $newStatus = 'paid';
            } elseif ($transactionStatus == 'pending') {
                $newStatus = 'pending';
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $newStatus = 'failed';
            }

            // ✅ Update hanya jika status berubah
            if ($transaction->status !== $newStatus) {
                $transaction->update(['status' => $newStatus]);
                Log::info("Transaction status updated: {$transaction->status} -> {$newStatus}");

                // ✅ Kirim email notifikasi atau proses lain di sini
                // $this->sendPaymentNotification($transaction);
            } else {
                Log::info("No status change needed. Current: {$transaction->status}");
            }

            Log::info('=== NOTIFICATION PROCESSED SUCCESSFULLY ===');

            return response()->json([
                'status' => 'success',
                'message' => 'Notification processed',
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus
            ]);

        } catch (\Exception $e) {
            Log::error('NOTIFICATION ERROR: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile());
            Log::error('Line: ' . $e->getLine());
            Log::error('Trace: ' . $e->getTraceAsString());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process notification: ' . $e->getMessage()
            ], 500);
        }
    }

    // 📌 Callback redirect ke user
    public function finish(Request $request)
    {
        return view('customer.finish', [
            'message' => 'Pembayaran berhasil! Terima kasih 🎉'
        ]);
    }

    public function unfinish(Request $request)
    {
        return view('customer.finish', [
            'message' => 'Pembayaran belum selesai. Silakan lanjutkan pembayaran.'
        ]);
    }

    public function error(Request $request)
    {
        return view('customer.finish', [
            'message' => 'Terjadi kesalahan saat pembayaran. Coba lagi.'
        ]);
    }
}
