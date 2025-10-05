<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'total' => 'required|numeric|min:1',
            'date' => 'required|date',
            'promo' => 'nullable|string'
        ]);

        // Format WhatsApp number
        $wa = preg_replace('/[^0-9]/', '', $validated['whatsapp']);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        } elseif (!str_starts_with($wa, '62')) {
            $wa = '62' . $wa;
        }
        $validated['whatsapp'] = $wa;

        // Get cart from session
        $cartItems = session('cart', []);
        if (!$cartItems) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong.');
        }

        // SIMPAN KE SESSION
        session([
            'checkout_data' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'whatsapp' => $validated['whatsapp'],
                'total' => $validated['total'],
                'date' => $validated['date'],
                'promo' => $validated['promo'],
                'cart_items' => $cartItems
            ]
        ]);

        // ⭐⭐ YANG INI HARUS ADA ⭐⭐
        // REDIRECT KE HALAMAN PEMBAYARAN
        return redirect()->route('checkout.pembayaran');
    }

    public function pembayaran()
    {
        $checkout = session('checkout_data');

        if (!$checkout) {
            return redirect()->route('keranjang.index')->with('error', 'Data checkout belum lengkap.');
        }

        return view('customer.transaksi', [
            'checkout' => $checkout,
            'total' => $checkout['total'],
        ]);
    }
}
