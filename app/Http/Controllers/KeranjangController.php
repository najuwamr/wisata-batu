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
            'ticket_id' => 'required|uuid|exists:ticket,id', // Ganti ke 'ticket'
            'qty'       => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);
        $cart = session()->get('cart', []);

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

        return redirect()->route('keranjang')->with('success', 'Tiket berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:0',
        ], [
            'qty.required' => 'Data tidak berubah'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($request->qty == 0) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect()->route('keranjang')->with('success', 'Tiket berhasil dihapus!');
            } else {
                $cart[$id]['qty'] = $request->qty;
                session()->put('cart', $cart);
                return redirect()->route('keranjang')->with('success', 'Jumlah tiket berhasil diupdate!');
            }
        }

        return redirect()->route('keranjang')->with('error', 'Tiket tidak ditemukan.');
    }

    public function hapus($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return redirect()->route('keranjang')->with('success', 'Tiket berhasil dihapus!');
        }

        return redirect()->route('keranjang')->with('error', 'Tiket tidak ditemukan.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $request->validate([
            'date'  => 'required|date',
            'promo' => 'nullable|string'
        ]);

        $date = $request->date;
        $promoCode = $request->promo;

        $promo = null;
        $promoTickets = collect();

        if ($promoCode) {
            $promo = Promo::where('code', $promoCode)
                ->where('is_active', true)
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->with('tickets:id')
                ->first();

            if ($promo) {
                $promoTickets = $promo->tickets->pluck('id')->toArray();
            } else {
                return back()->with('error', 'Kode promo tidak valid atau sudah kadaluarsa.');
            }
        }

        $cartWithDiscount = [];
        $total = 0;
        $totalDiscount = 0;

        foreach ($cart as $item) {
            $itemSubtotal = $item['price'] * $item['qty'];
            $discountAmount = 0;

            // Cek apakah tiket ini kena promo
            if ($promo && in_array($item['ticket_id'], $promoTickets)) {
                $discountAmount = ($promo->discount_percent / 100) * $itemSubtotal;
                $itemSubtotal -= $discountAmount;
            }

            $cartWithDiscount[] = [
                'id' => $item['ticket_id'],
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'], // Harga asli
                'discount' => $discountAmount, // Jumlah diskon
                'subtotal' => $itemSubtotal, // Subtotal setelah diskon
            ];

            $total += $itemSubtotal;
            $totalDiscount += $discountAmount;
        }

        // SIMPAN KE SESSION - pakai $cartWithDiscount yang sudah ada perhitungan promo
        session([
            'checkout_data' => [
                'date' => $date,
                'promo' => $promoCode,
                'promo_name' => $promo->name ?? null,
                'discount_percent' => $promo->discount_percent ?? 0,
                'total_discount' => $totalDiscount,
                'total' => $total,
                'cart_items' => $cartWithDiscount // INI YANG SUDAH ADA PERHITUNGAN PROMO
            ]
        ]);

        return view('customer.checkout', [
            'cart' => $cartWithDiscount,
            'total' => $total,
            'totalDiscount' => $totalDiscount,
            'promoCode' => $promoCode,
            'promoName' => $promo->name ?? null,
            'discountPercent' => $promo->discount_percent ?? 0,
            'date' => $date,
        ]);
    }
}
