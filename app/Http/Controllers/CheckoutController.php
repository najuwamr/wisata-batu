<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // dd(session()->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        // Format WhatsApp number
        $wa = preg_replace('/[^0-9]/', '', $validated['whatsapp']);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        } elseif (!str_starts_with($wa, '62')) {
            $wa = '62' . $wa;
        }
        $validated['whatsapp'] = $wa;

        // AMBIL DATA DARI SESSION CHECKOUT (yang sudah ada perhitungan promo)
        $checkoutSession = session('checkout_data');

        if (!$checkoutSession) {
            return redirect()->route('keranjang')->with('error', 'Data checkout tidak ditemukan.');
        }

        // UPDATE SESSION dengan data customer + data checkout yang sudah ada
        session([
            'checkout_data' => array_merge($checkoutSession, [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'whatsapp' => $validated['whatsapp'],
            ])
        ]);

        // Redirect ke halaman pembayaran
        return redirect()->route('checkout.pembayaran');
    }

    public function pembayaran()
    {
        $checkout = session('checkout_data');
        // dd(session()->all());

        if (!$checkout) {
            return redirect()->route('keranjang')->with('error', 'Data checkout belum lengkap.');
        }

        return view('customer.transaksi', [
            'checkout' => $checkout,
            'total' => $checkout['total'], // Total yang sudah include promo
        ]);
    }
}
