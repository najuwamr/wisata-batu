<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function get_Tiket()
    {
        $tiketAktif = Ticket::where('is_active', true)->get();
        $tiketNonAktif = Ticket::where('is_active', false)->get();
        return view('admin.tiket', compact('tiketAktif', 'tiketNonAktif',));
    }

    public function tambah_Tiket()
    {
        // Ambil semua aset untuk ditampilkan sebagai fasilitas
        $assets = Aset::all();
        return view('admin.tambah-tiket', compact('assets'));
    }

    public function insert_Tiket(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:tiket,parkir',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'aset' => 'nullable|array',
            'aset.*' => 'exists:aset,id',
        ], [
            'name.required' => 'Nama tiket wajib diisi.',
            'price.required' => 'Harga tiket wajib diisi.',
            'price.numeric' => 'Harga tiket harus berupa angka.',
            'price.min' => 'Harga tiket tidak boleh negatif.',
            'image.required' => 'Gambar tiket wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
            'aset.*.exists' => 'Fasilitas yang dipilih tidak valid.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        // Simpan tiket baru
        $ticket = Ticket::create($validated);

        // Simpan relasi fasilitas jika ada
        if ($request->has('aset')) {
            $ticket->aset()->sync($request->aset);
        }

        return redirect()->route('admin.tiket.get')->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function edit_tiket($id)
    {
        $data = Ticket::with('assets')->findOrFail($id);
        $assets = Aset::all();

        return response()->json([
            'ticket' => $data,
            'assets' => $assets
        ]);
    }

    public function update_tiket(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:tiket,parkir',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'assets' => 'nullable|array',
            'assets.*' => 'exists:asets,id'
        ], [
            'name.required' => 'Nama tiket wajib diisi.',
            'price.required' => 'Harga tiket wajib diisi.',
            'price.numeric' => 'Harga tiket harus berupa angka.',
            'price.min' => 'Harga tiket tidak boleh negatif.',
            'category.required' => 'Kategori wajib diisi.',
            'category.in' => 'Kategori harus tiket atau parkir.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
            'assets.array' => 'Aset harus berupa array.',
            'assets.*.exists' => 'Aset yang dipilih tidak valid.',
        ]);

        $tiket = Ticket::findOrFail($id);

        // Handle image upload
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

        // Update ticket
        $tiket->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'image' => $validated['image'],
        ]);

        // Sync assets (many-to-many relationship)
        if ($request->has('assets')) {
            $tiket->assets()->sync($request->assets);
        } else {
            $tiket->assets()->detach(); // Remove all assets if none selected
        }

        return back()->with('success', 'Tiket berhasil diperbarui.');
    }

    public function delete($id)
    {
        $tiket = Ticket::findOrFail($id);
        $tiket->is_active = false;
        $tiket->save();

        return redirect()->route('admin.tiket.get')->with('success', 'Tiket berhasil dihapus, Anda dapat mengaktifkannya kembali.');
    }

    public function restore($id)
    {
        $tiket = Ticket::findOrFail($id);
        $tiket->is_active = true;
        $tiket->save();

        return redirect()->route('admin.tiket.get')->with('success', 'Tiket berhasil diaktifkan kembali.');
    }

    public function index_tiket()
    {
        $tiket = Ticket::where('is_active', true)->where('category', 'tiket')->get();
        return view('customer.tiket.tiket', compact('tiket'));
    }

    public function detail_tiket($id)
    {
        // Ambil tiket yang aktif berdasarkan ID
        $ticket = Ticket::where('is_active', true)->findOrFail($id);

        // Ambil tiket lainnya (exclude current ticket, random order, limit 3)
        $otherTickets = Ticket::where('is_active', true)
            ->where('category', 'tiket')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('customer.tiket.detail-tiket', compact('ticket', 'otherTickets'));
    }
}
