<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    /** =========================
     * ADMIN AREA
     * ========================= */

    public function get_promo()
    {
        $promoAktif = Promo::where('is_active', true)->get();
        $promoNonAktif = Promo::where('is_active', false)->get();
        $tiketAktif = collect();
        $tiketNonAktif = collect();
        $tab = 'promo';

        return view('admin.promo', compact('promoAktif', 'promoNonAktif', 'tiketAktif', 'tiketNonAktif', 'tab'));
    }

    public function tambah_promo()
    {
        return view('admin.tambah-promo');
    }

    public function insert_promo(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'code'              => 'required|string|unique:promo,code',
            'discount_percent'  => 'required|integer|min:0|max:100',
            'max_disc_amount'   => 'required|integer|min:0',
            'category'          => 'required|in:periodik,nonperiodik',
            'total_qty'         => 'nullable|integer|min:1|required_if:category,nonperiodik',
            'daily_qty'         => 'nullable|integer|min:1|required_if:category,nonperiodik',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'code.unique' => 'Kode promo sudah digunakan.',
            'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        $validated['id'] = Str::uuid();
        $validated['is_active'] = true;

        Promo::create($validated);

        return redirect()->route('admin.promo.get')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit_promo($id)
    {
        $promo = Promo::findOrFail($id);
        return response()->json($promo);
    }

    public function update_promo(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'code'              => 'required|string|unique:promo,code,' . $id,
            'discount_percent'  => 'required|integer|min:0|max:100',
            'max_disc_amount'   => 'required|integer|min:0',
            'category'          => 'required|in:periodik,nonperiodik',
            'total_qty'         => 'nullable|integer|min:1|required_if:category,nonperiodik',
            'daily_qty'         => 'nullable|integer|min:1|required_if:category,nonperiodik',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('image')) {
            if ($promo->image && file_exists(public_path('images/' . $promo->image))) {
                unlink(public_path('images/' . $promo->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $promo->image;
        }

        $promo->update($validated);

        return redirect()->route('admin.promo.get')->with('success', 'Promo berhasil diperbarui.');
    }

    public function delete($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->update(['is_active' => false]);

        return redirect()->route('admin.promo.get')->with('success', 'Promo dinonaktifkan sementara.');
    }

    public function restore($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->update(['is_active' => true]);

        return redirect()->route('admin.promo.get')->with('success', 'Promo berhasil diaktifkan kembali.');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);

        if ($promo->image && file_exists(public_path('images/' . $promo->image))) {
            unlink(public_path('images/' . $promo->image));
        }

        $promo->delete();

        return redirect()->route('admin.promo.get')->with('success', 'Promo berhasil dihapus permanen.');
    }

    /** =========================
     * CUSTOMER AREA
     * ========================= */

    public function index()
    {
        $promoAktif = Promo::where('is_active', true)
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.promo.promo', compact('promoAktif'));
    }

    public function show($id)
    {
        $promo = Promo::find($id);

        if (!$promo) {
            return redirect()->route('customer.promo')->with('error', 'Promo tidak ditemukan.');
        }

        return view('customer.promo.detail', compact('promo'));
    }
}
