<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TiketController extends Controller
{
    /**
     * Tampilkan daftar tiket aktif & nonaktif
     */
    public function get_tiket()
    {
        $tiketAktif = Ticket::select('id', 'name', 'description', 'price', 'category', 'image',)
            ->where('is_active', true)
            ->with(['aset:id,name'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $tiketNonAktif = Ticket::select('id', 'name', 'category', 'image',)
            ->where('is_active', false)
            ->get();

        return view('admin.tiket', compact('tiketAktif', 'tiketNonAktif'));
    }

    /**
     * Form tambah tiket
     */
    public function tambah_tiket()
    {
        $aset = Aset::select('id', 'name')->get();
        return view('admin.tiket-form', [
            'ticket' => null,
            'aset' => $aset,
            'isEdit' => false
        ]);
    }

    /**
     * Simpan tiket baru
     */
    public function insert_tiket(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|in:tiket,parkir,lainnya',
            'image'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'aset'        => 'nullable|array',
            'aset.*'      => 'exists:aset,id',
        ]);

        // Upload gambar
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $filename);
        $validated['image'] = $filename;

        // Simpan tiket baru
        $ticket = Ticket::create($validated);

        // Relasi aset (fasilitas)
        if (!empty($validated['aset'])) {
            $ticket->aset()->sync($validated['aset']);
        }

        return redirect()->route('admin.tiket.get')->with('success', 'Tiket berhasil ditambahkan.');
    }

    /**
     * Ambil data tiket untuk form edit
     */
    public function edit_tiket($id)
    {
        $ticket = Ticket::with('aset:id,name')->findOrFail($id);
        $aset = Aset::select('id', 'name')->get();

        return view('admin.tiket-form', [
            'ticket' => $ticket,
            'aset' => $aset,
            'isEdit' => true
        ]);
    }

    /**
     * Update tiket
     */
    public function update_tiket(Request $request, $id)
    {
        $tiket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|in:tiket,parkir,lainnya',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'aset'        => 'nullable|array',
            'aset.*'      => 'exists:aset,id',
        ]);

        // Hanya update gambar jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($tiket->image && File::exists(public_path('images/' . $tiket->image))) {
                File::delete(public_path('images/' . $tiket->image));
            }

            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        } else {
            // Gunakan gambar lama jika tidak ada upload baru
            unset($validated['image']);
        }

        // Update tiket
        $tiket->update($validated);

        // Sync aset (fasilitas)
        $tiket->aset()->sync($validated['aset'] ?? []);

        return redirect()->route('admin.tiket.get')->with('success', 'Tiket berhasil diperbarui.');
    }

    /**
     * Soft delete tiket (nonaktifkan)
     */
    public function delete($id)
    {
        Ticket::where('id', $id)->update(['is_active' => false]);
        return back()->with('success', 'Tiket berhasil dinonaktifkan.');
    }

    /**
     * Pulihkan tiket yang nonaktif
     */
    public function restore($id)
    {
        Ticket::where('id', $id)->update(['is_active' => true]);
        return back()->with('success', 'Tiket berhasil diaktifkan kembali.');
    }

    /**
     * Hapus permanen tiket
     */
    public function destroy($id)
    {
        $tiket = Ticket::findOrFail($id);

        if ($tiket->image && File::exists(public_path('images/' . $tiket->image))) {
            File::delete(public_path('images/' . $tiket->image));
        }

        $tiket->aset()->detach();
        $tiket->delete();

        return back()->with('success', 'Tiket berhasil dihapus permanen.');
    }

    /**
     * Halaman customer - daftar tiket aktif
     */
    public function index_tiket()
    {
        $tiket = Ticket::select('id', 'name', 'price', 'image')
            ->where('is_active', true)
            ->where('category', 'tiket')
            ->get();

        return view('customer.tiket.tiket', compact('tiket'));
    }

    /**
     * Halaman detail tiket customer
     */
    public function detail_tiket($id)
    {
        $ticket = Ticket::where('is_active', true)->findOrFail($id);

        $otherTickets = Ticket::where('is_active', true)
            ->where('category', 'tiket')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(3)
            ->get(['id', 'name', 'price', 'image']);

        return view('customer.tiket.detail-tiket', compact('ticket', 'otherTickets'));
    }
}
