<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function get_Promo()
    {
        $promoAktif = Promo::where('is_active', true)->get();
        $promoNonAktif = Promo::where('is_active', false)->get();
        $tiketAktif = collect();
        $tiketNonAktif = collect();
        $tab = 'promo';
        return view('admin.tiket-and-promo', compact('promoAktif', 'promoNonAktif', 'tiketAktif', 'tiketNonAktif', 'tab'));
    }

    public function tambah_Promo()
    {
        return view('admin.tambah-tiket');
    }

    public function insert_Promo(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'code' => 'required|string|unique:tickets,code',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama tiket wajib diisi.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
            'code.required' => 'Kode tiket wajib diisi.',
            'code.unique' => 'Kode tiket sudah digunakan.',
            'image.required' => 'Gambar tiket wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/images'), $filename);
            $validated['image'] = $filename;
        }

        Promo::create($validated);

        return redirect()->route('admin.get.promo')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit_Promo($id)
    {
        $data = Promo::findOrFail($id);
        return response()->json($data);
    }

    public function update_Promo(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'code' => 'required|string|unique:tickets,code',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama tiket wajib diisi.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
            'code.required' => 'Kode tiket wajib diisi.',
            'code.unique' => 'Kode tiket sudah digunakan.',
            'image.required' => 'Gambar tiket wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $promo = Promo::findOrFail($id);
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

        $promo->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'code' => $validated['code'],
            'image' => $validated['image'],
        ]);

        return back()->with('success', 'Tiket berhasil diperbarui.');
    }

    public function delete($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->is_active = false;
        $promo->save();

        return redirect()->route('admin.get.promo')->with('success', 'Promo berhasil dihapus, Anda dapat mengaktifkannya kembali.');
    }

    public function restore($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->is_active = true;
        $promo->save();

        return redirect()->route('admin.get.promo')->with('success', 'Promo berhasil diaktifkan kembali.');
    }
}
