<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Ticket;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function keranjang()
    {
        $cart = session()->get('cart', []);
        $tiket = Ticket::orderByRaw("
            CASE category
                WHEN 'tiket' THEN 1
                WHEN 'parkir' THEN 2
                WHEN 'lainnya' THEN 3
            END
        ")->get();

        return view('customer.keranjang', compact('cart', 'tiket'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|uuid|exists:ticket,id',
            'qty'       => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);
        $cart   = session()->get('cart', []);

        if (isset($cart[$ticket->id])) {
            $cart[$ticket->id]['qty'] += $request->qty;
        } else {
            $cart[$ticket->id] = [
                'ticket_id' => $ticket->id,
                'name'      => $ticket->name,
                'price'     => $ticket->price,
                'qty'       => $request->qty,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('keranjang')->with('success', 'Tiket berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $request->qty;
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'message' => 'Jumlah tiket berhasil diupdate!']);
        }

        return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan.']);
    }

    public function hapus($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'message' => 'Tiket berhasil dihapus!']);
        }

        return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan.']);
    }

    public function clear()
    {
        session()->forget('cart');
        return response()->json(['success' => true, 'message' => 'Keranjang dikosongkan!']);
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $request->validate([
            'date'  => 'required|date',
            'promo' => 'nullable|string'
        ], [
            'date.required' => 'Harap memilih tanggal kunjungan Anda',
        ]);

        $date = $request->date;
        $promoCode = $request->promo;

        // Hitung total belanja
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        $discountPercent = 0;
        $discountAmount  = 0;

        if ($promoCode) {
            $promo = Promo::where('code', $promoCode)
                ->where('is_active', true)
                ->where(function ($q) {
                    $today = now()->toDateString();
                    $q->whereNull('valid_until')->orWhere('valid_until', '>=', $today);
                })
                ->first();

            if ($promo) {
                $discountPercent = $promo->discount_percent;
                $discountAmount  = ($discountPercent / 100) * $total;
                $total = $total - $discountAmount;
            } else {
                return back()->with('error', 'Kode promo tidak valid atau sudah kadaluarsa.');
            }
        }

        return view('customer.checkout', compact('cart', 'date', 'total', 'discountPercent', 'discountAmount'));
    }
}
