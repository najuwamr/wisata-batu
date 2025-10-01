<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\CoreApi;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function charge(Request $request)
    {
        $orderId = uniqid();
        $grossAmount = 100000; 

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => 'Budi',
                'email' => 'budi@example.com',
                'phone' => '08123456789',
            ],
        ];

        $paymentType = $request->input('payment_type');

        switch ($paymentType) {
            // ==== Virtual Account ====
            case 'bca_va':
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => 'bca'];
                break;

            case 'bni_va':
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => 'bni'];
                break;

            case 'bri_va':
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => 'bri'];
                break;

            case 'mandiri_bill':
                $params['payment_type'] = 'echannel';
                $params['echannel'] = [
                    'bill_info1' => 'Payment',
                    'bill_info2' => 'Online purchase'
                ];
                break;

            case 'permata_va':
                $params['payment_type'] = 'permata';
                break;

            case 'cimb_va':
                $params['payment_type'] = 'cimb';
                break;

            // ==== QRIS ====
            case 'qris':
                $params['payment_type'] = 'qris';
                break;

            // ==== E-Wallet ====
            case 'gopay':
                $params['payment_type'] = 'gopay';
                $params['gopay'] = [
                    'enable_callback' => true,
                    'callback_url' => url('/payment/finish')
                ];
                break;

            case 'shopeepay':
                $params['payment_type'] = 'shopeepay';
                $params['shopeepay'] = [
                    'callback_url' => url('/payment/finish')
                ];
                break;

            case 'dana':
                $params['payment_type'] = 'dana';
                $params['dana'] = [
                    'callback_url' => url('/payment/finish')
                ];
                break;

            default:
                return response()->json(['error' => 'Metode pembayaran tidak valid'], 400);
        }

        // === Charge ke Midtrans ===
        $charge = CoreApi::charge($params);

        // === Handle response sesuai tipe ===
        if (isset($charge->va_numbers)) {
            // Untuk VA
            return view('payment.va', [
                'bank' => $charge->va_numbers[0]->bank,
                'va_number' => $charge->va_numbers[0]->va_number,
                'amount' => $charge->gross_amount
            ]);
        } elseif (isset($charge->actions)) {
            // Untuk e-wallet / QRIS
            return redirect()->away($charge->actions[0]->url);
        }

        return response()->json($charge);
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
