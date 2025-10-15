<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Zxing\QrReader;

class LaporanController extends Controller
{
    // Menampilkan daftar laporan transaksi
    public function klik_Laporan()
    {
        $transactions = Transaction::with([
            'customer',
            'transactionDetail.ticket'
        ])->paginate(10);

        return view('admin.laporan_penjualan', compact('transactions'));
    }

    // Halaman untuk scan QR
    public function klik_scan()
    {
        return view('admin.scan');
    }

    // 🧩 Fungsi untuk decode + decrypt hasil QR code

    public function decodeQr(Request $request)
    {
        $transaction = null;

        try {
            if ($request->filled('code')) {
                $decodedText = $request->code;
                Log::info("QR diterima dari kamera: " . $decodedText);
            } elseif ($request->hasFile('qr_image')) {
                $imagePath = $request->file('qr_image')->getPathname();
                $qrcode = new \Zxing\QrReader($imagePath);
                $decodedText = $qrcode->text();
                Log::info("QR hasil upload dibaca: " . $decodedText);
            } else {
                Log::warning("Tidak ada QR dikirim dari request.");
                return back()->with('error', 'QR code tidak ditemukan.');
            }

            // 🔍 Coba dekripsi
            // 🔍 Coba dekripsi (dengan base64 decode dulu)
            try {
                $decodedBase64 = base64_decode($decodedText);
                $decrypted = \Illuminate\Support\Facades\Crypt::decrypt($decodedBase64);
                Log::info("QR berhasil didekripsi: " . $decrypted);
            } catch (\Exception $e) {
                $decrypted = $decodedText;
                Log::info("QR tidak bisa didekripsi (pakai mentah): " . $decrypted);
            }

            // 🔎 Cari transaksi
            $transaction = \App\Models\Transaction::with(['customer', 'transactionDetail.ticket'])
                ->where('code', $decrypted)
                ->first();

            if (!$transaction) {
                Log::warning("Transaksi tidak ditemukan untuk kode: " . $decrypted);
                return back()->with('error', 'Transaksi tidak ditemukan.');
            }

            Log::info("Transaksi ditemukan: " . $transaction->id);

        } catch (\Exception $e) {
            Log::error('Gagal decode QR: ' . $e->getMessage());
            return back()->with('error', 'QR tidak valid atau rusak.');
        }

        return view('admin.scan', compact('transaction'));
    }


}
