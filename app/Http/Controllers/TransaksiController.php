<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\CoreApi;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function charge(Request $request)
    {
        $orderId = 'ORDER-' . strtoupper(uniqid());
        $grossAmount = $request->gross_amount;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
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
            $charge = CoreApi::charge($params);

            // Virtual Account (BCA, BNI, BRI)
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

            // Mandiri Bill Payment
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

            // QRIS / E-Wallet
            if (isset($charge->actions)) {
                return response()->json([
                    'status' => 'redirect',
                    'url' => $charge->actions[0]->url,
                ]);
            }

            return response()->json(['status' => 'unknown', 'data' => $charge]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // 📌 Webhook dari Midtrans
    public function notification(Request $request)
    {
        $notif = new Notification();

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;

        // di sini update database transaksi sesuai $orderId
        // contoh sederhana:
        Log::info("Notifikasi Midtrans: Order $orderId status $transactionStatus");

        return response()->json(['message' => 'Notifikasi diterima']);
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
