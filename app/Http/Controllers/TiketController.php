<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function get_Tiket()
    {
        $tiketAktif = Ticket::where('is_active', true)->get();
        $tiketNonAktif = Ticket::where('is_active', false)->get();
        $promoAktif = collect();
        $promoNonAktif = collect();
        $tab = 'tiket';
        return view('admin.tiket-and-promo', compact('tiketAktif', 'tiketNonAktif', 'promoNonAktif', 'promoAktif', 'tab'));
    }

    public function tambah_Tiket()
    {
        return view('admin.tambah-tiket');
    }

    public function insert_Tiket(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:tiket,parkir',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ],
        [
            'name.required' => 'Nama tiket wajib diisi.',
            'price.required' => 'Harga tiket wajib diisi.',
            'price.numeric' => 'Harga tiket harus berupa angka.',
            'price.min' => 'Harga tiket tidak boleh negatif.',
            'image.required' => 'Gambar tiket wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        Ticket::create($validated);

        return redirect()->route('admin.get.tiket')->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function edit_tiket($id)
    {
        $data = Ticket::findOrFail($id);
        return response()->json($data);
    }

    public function update_tiket(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama tiket wajib diisi.',
            'price.required' => 'Harga tiket wajib diisi.',
            'price.numeric' => 'Harga tiket harus berupa angka.',
            'price.min' => 'Harga tiket tidak boleh negatif.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
        ]);

        $tiket = Ticket::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($tiket->image && file_exists(public_path('images/' . $tiket->image))) {
                unlink(public_path('images/' . $tiket->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $validated['image'] = $filename;
        } else {
            $validated['image'] = $tiket->image;
        }

        $tiket->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image' => $validated['image'],
        ]);

        return back()->with('success', 'Tiket berhasil diperbarui.');
    }

    public function delete($id)
    {
        $tiket = Ticket::findOrFail($id);
        $tiket->is_active = false;
        $tiket->save();

        return redirect()->route('admin.get.tiket')->with('success', 'Tiket berhasil dihapus, Anda dapat mengaktifkannya kembali.');
    }

    public function restore($id)
    {
        $tiket = Ticket::findOrFail($id);
        $tiket->is_active = true;
        $tiket->save();

        return redirect()->route('admin.get.tiket')->with('success', 'Tiket berhasil diaktifkan kembali.');
    }

    public function index_tiket()
    {
        $tiket = Ticket::where('is_active', true)->where('category', 'tiket')->get();
        return view('customer.tiket', compact('tiket'));
    }

    public function detail_tiket($id)
    {
        $tiket = Ticket::findOrFail($id);
        return view('customer.detail-tiket', compact('tiket'));
    }
}
