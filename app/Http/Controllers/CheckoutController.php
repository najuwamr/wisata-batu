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
        ]);

        $wa = preg_replace('/[^0-9]/', '', $validated['whatsapp']);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        } elseif (!str_starts_with($wa, '62')) {
            $wa = '62' . $wa;
        }

        $validated['whatsapp'] = $wa;

        $customer = Customer::where('email', $validated['email'])
            ->orWhere('telephone', $validated['whatsapp'])
            ->first();

        if (!$customer) {
            $customer = Customer::create([
                'id' => Str::uuid(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'telephone' => $validated['whatsapp'],
            ]);
        }

        $cartItems = session('cart');
        if (!$cartItems) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'id' => Str::uuid(),
                'code' => 'INV-' . strtoupper(uniqid()),
                'tanggal_kedatangan' => $validated['tanggal_kedatangan'], // ambil dari request
                'midtrans_order_id' => null, // nanti diisi setelah request ke Midtrans
                'midtrans_tr_id' => null, // nanti diisi setelah transaksi berhasil
                'total_price' => $validated['total'],
                'customer_id' => $customer->id,
                'payment_method_id' => $validated['payment_method_id'], // ambil dari request
                'status' => 'pending',
            ]);

            // Simpan detail transaksi
            foreach ($cartItems as $item) {
                TransactionDetail::create([
                    'id' => Str::uuid(),
                    'transaction_id' => $transaction->id,
                    'ticket_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            // Hapus cart
            session()->forget('cart');

            // Simpan data checkout ke session
            session([
                'checkout_data' => [
                    'transaction_id' => $transaction->id,
                    'customer_id' => $customer->id,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'whatsapp' => $validated['whatsapp'],
                    'total' => $validated['total'],
                ]
            ]);

            return redirect()->route('checkout.pembayaran');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses checkout: ' . $e->getMessage());
        }
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
