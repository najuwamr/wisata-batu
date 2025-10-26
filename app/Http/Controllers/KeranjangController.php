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

        $layanan = 3000;

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        $total = $subtotal + $layanan;

        return view('customer.keranjang', compact('cart', 'tiket', 'layanan', 'subtotal', 'total'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|uuid|exists:ticket,id',
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

        // 🔹 1. Cek validitas promo
        if ($promoCode) {
            $promo = Promo::where('code', $promoCode)
                ->where('is_active', true)
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->with('tickets:id')
                ->first();

            // ❌ Promo tidak valid / kadaluarsa
            if (!$promo) {
                return redirect()
                    ->route('keranjang')
                    ->with('error', 'Kode promo tidak valid atau sudah kadaluarsa.');
            }

            $promoTickets = $promo->tickets->pluck('id')->toArray();
        }

        // 🔹 2. Proses keranjang
        $cartWithDiscount = [];
        $total = 0;
        $totalDiscount = 0;
        $layanan = 3000;
        $validPromoUsed = false;

        foreach ($cart as $item) {
            $itemSubtotal = $item['price'] * $item['qty'];
            $discountAmount = 0;

            // Cek apakah tiket ini kena promo
            if ($promo && in_array($item['ticket_id'], $promoTickets)) {
                $discountAmount = ($promo->discount_percent / 100) * $itemSubtotal;
                $itemSubtotal -= $discountAmount;
                $validPromoUsed = true;
            }

            $cartWithDiscount[] = [
                'id' => $item['ticket_id'],
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'discount' => $discountAmount,
                'subtotal' => $itemSubtotal,
            ];

            $total += $itemSubtotal;
            $totalDiscount += $discountAmount;
        }

        $totalWithLayanan = $total + $layanan;

        // ❌ Promo valid tapi tidak berlaku untuk tiket apa pun
        if ($promoCode && $promo && !$validPromoUsed) {
            return redirect()
                ->route('keranjang')
                ->with('error', 'Kode promo tidak berlaku untuk tiket mana pun di keranjang ini.');
        }

        // 🔹 3. Simpan ke session
        session([
            'checkout_data' => [
                'date' => $date,
                'promo' => $promoCode,
                'promo_name' => $promo->name ?? null,
                'discount_percent' => $promo->discount_percent ?? 0,
                'total_discount' => $totalDiscount,
                'subtotal' => $total,
                'layanan' => $layanan,
                'total' => $totalWithLayanan,
                'cart_items' => $cartWithDiscount,
            ]
        ]);

        // 🔹 4. Kirim ke view checkout
        return view('customer.checkout', [
            'cart' => $cartWithDiscount,
            'subtotal' => $total,
            'layanan' => $layanan,
            'total' => $totalWithLayanan,
            'totalDiscount' => $totalDiscount,
            'promoCode' => $promoCode,
            'promoName' => $promo->name ?? null,
            'discountPercent' => $promo->discount_percent ?? 0,
            'date' => $date,
        ]);
    }
}
