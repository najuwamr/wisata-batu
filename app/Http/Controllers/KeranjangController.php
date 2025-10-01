<?php

namespace App\Http\Controllers;

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

        return redirect()->route('keranjang')
            ->with('success', 'Tiket berhasil ditambahkan ke keranjang!');
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
            return redirect()->route('keranjang')->with('success', 'Jumlah tiket berhasil diupdate!');
        }

        return redirect()->route('keranjang')->with('error', 'Tiket tidak ditemukan di keranjang.');
    }

    public function hapus($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('keranjang')->with('success', 'Tiket berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('keranjang')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
