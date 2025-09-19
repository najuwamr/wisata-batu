<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use midtrans\CoreApi;

class PaymentController extends Controller
{
    // Mengatur konfigurasi Midtrans
    public function charge(Request $request)
    {
        $orderId = uniqid();
        $grossAmount = 100000;

        $customer = [
            'first_name' => 'Budi',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
        ];

        $paymentType = $request->input('payment_type');

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => $customer,
        ];

        switch ($paymentType) {
            case 'bni_va':
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => 'bni'];
                break;

            case 'bca_va':
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => 'bca'];
                break;

            case 'qris':
                $params['payment_type'] = 'qris';
                break;

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

            default:
                return response()->json(['error' => 'Metode pembayaran tidak valid'], 400);
        }

        $charge = CoreApi::charge($params);

        return response()->json($charge);
    }
}
