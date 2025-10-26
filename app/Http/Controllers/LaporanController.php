<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Zxing\QrReader;

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan transaksi dengan statistik dan filter
     */
    public function klik_Laporan(Request $request)
    {
        // Query dasar dengan eager loading
        $query = Transaction::with([
            'customer',
            'transactionDetail.ticket',
            'transactionDetail.promo'
        ]);

        // Filter berdasarkan periode
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('tanggal_kedatangan', Carbon::today());
                    break;
                case '7days':
                    $query->whereDate('tanggal_kedatangan', '>=', Carbon::today()->subDays(7));
                    break;
                case '30days':
                    $query->whereDate('tanggal_kedatangan', '>=', Carbon::today()->subDays(30));
                    break;
                case 'custom':
                    if ($request->filled('date_from')) {
                        $query->whereDate('tanggal_kedatangan', '>=', $request->date_from);
                    }
                    if ($request->filled('date_to')) {
                        $query->whereDate('tanggal_kedatangan', '<=', $request->date_to);
                    }
                    break;
            }
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality - hanya di kolom code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%{$search}%");
        }

        // Sorting - default urutkan dari yang terbaru
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $transactions = $query->paginate($perPage)->withQueryString();

        // Hitung statistik untuk dashboard cards
        $stats = [
            'total' => Transaction::count(),
            'paid' => Transaction::where('status', 'paid')->count(),
            'pending' => Transaction::where('status', 'pending')->count(),
            'expired' => Transaction::where('status', 'expired')->count(),
            'redeemed' => Transaction::where('status', 'redeemed')->count(),
        ];

        // Jika ada filter, hitung juga stats berdasarkan filter
        if ($request->hasAny(['period', 'status', 'search', 'date_from', 'date_to'])) {
            $filteredQuery = Transaction::query();
            
            // Terapkan filter yang sama
            if ($request->filled('period')) {
                switch ($request->period) {
                    case 'today':
                        $filteredQuery->whereDate('tanggal_kedatangan', Carbon::today());
                        break;
                    case '7days':
                        $filteredQuery->whereDate('tanggal_kedatangan', '>=', Carbon::today()->subDays(7));
                        break;
                    case '30days':
                        $filteredQuery->whereDate('tanggal_kedatangan', '>=', Carbon::today()->subDays(30));
                        break;
                    case 'custom':
                        if ($request->filled('date_from')) {
                            $filteredQuery->whereDate('tanggal_kedatangan', '>=', $request->date_from);
                        }
                        if ($request->filled('date_to')) {
                            $filteredQuery->whereDate('tanggal_kedatangan', '<=', $request->date_to);
                        }
                        break;
                }
            }

            $stats['filtered_total'] = $filteredQuery->count();
            $stats['filtered_paid'] = (clone $filteredQuery)->where('status', 'paid')->count();
            $stats['filtered_redeemed'] = (clone $filteredQuery)->where('status', 'redeemed')->count();
        }

        return view('admin.laporan_penjualan', compact('transactions', 'stats'));
    }

    /**
     * Halaman untuk scan QR
     */
    public function klik_scan()
    {
        return view('admin.scan');
    }

    /**
     * Decode dan decrypt hasil QR code
     */
    public function decodeQr(Request $request)
    {
        $transaction = null;

        try {
            $decodedText = null;

            // Cek apakah QR dari kamera atau upload
            if ($request->filled('code')) {
                $decodedText = $request->code;
                Log::info("QR diterima dari kamera", ['code' => $decodedText]);
            } elseif ($request->hasFile('qr_image')) {
                // Validasi file
                $request->validate([
                    'qr_image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
                ]);

                $imagePath = $request->file('qr_image')->getPathname();
                
                try {
                    $qrcode = new QrReader($imagePath);
                    $decodedText = $qrcode->text();
                    Log::info("QR hasil upload dibaca", ['code' => $decodedText]);
                } catch (\Exception $e) {
                    Log::error("Gagal membaca QR dari gambar: " . $e->getMessage());
                    return back()->with('error', 'Gagal membaca QR code dari gambar. Pastikan gambar jelas dan benar.');
                }
            } else {
                Log::warning("Tidak ada QR dikirim dari request");
                return back()->with('error', 'QR code tidak ditemukan. Silakan scan atau upload QR code.');
            }

            if (!$decodedText) {
                return back()->with('error', 'QR code kosong atau tidak valid.');
            }

            // Proses dekripsi QR code
            $transactionCode = $this->decryptQrCode($decodedText);

            if (!$transactionCode) {
                Log::warning("Gagal dekripsi QR code", ['raw' => $decodedText]);
                return back()->with('error', 'QR code tidak valid atau rusak.');
            }

            // Cari transaksi berdasarkan kode
            $transaction = Transaction::with([
                'customer',
                'transactionDetail.ticket',
                'transactionDetail.promo'
            ])
            ->where('code', $transactionCode)
            ->first();

            if (!$transaction) {
                Log::warning("Transaksi tidak ditemukan", ['code' => $transactionCode]);
                return back()->with('error', 'Transaksi tidak ditemukan. Kode: ' . $transactionCode);
            }

            Log::info("Transaksi ditemukan", [
                'id' => $transaction->id,
                'code' => $transaction->code,
                'status' => $transaction->status
            ]);

            // Cek status transaksi
            if ($transaction->status === 'expired') {
                return view('admin.scan', compact('transaction'))
                    ->with('error', 'Transaksi sudah expired dan tidak dapat digunakan.');
            }

            if ($transaction->status === 'pending') {
                return view('admin.scan', compact('transaction'))
                    ->with('warning', 'Transaksi belum dibayar. Status: Pending');
            }

            if ($transaction->status === 'redeemed') {
                return view('admin.scan', compact('transaction'))
                    ->with('info', 'Transaksi sudah pernah digunakan (Redeemed) pada: ' . $transaction->redeemed_at);
            }

            // Status paid - siap digunakan
            return view('admin.scan', compact('transaction'))
                ->with('success', 'QR code valid! Transaksi siap digunakan.');

        } catch (\Exception $e) {
            Log::error('Gagal decode QR: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Terjadi kesalahan saat memproses QR code.');
        }
    }

    /**
     * Helper function untuk dekripsi QR code
     */
    private function decryptQrCode($encodedText)
    {
        try {
            // Coba dekripsi dengan base64 decode dulu
            $decodedBase64 = base64_decode($encodedText, true);
            
            if ($decodedBase64 !== false) {
                try {
                    $decrypted = Crypt::decrypt($decodedBase64);
                    Log::info("QR berhasil didekripsi dengan base64", ['result' => $decrypted]);
                    return $decrypted;
                } catch (\Exception $e) {
                    // Jika gagal, coba tanpa base64
                    Log::info("Gagal dekripsi dengan base64, coba tanpa base64");
                }
            }

            // Coba dekripsi langsung tanpa base64
            try {
                $decrypted = Crypt::decrypt($encodedText);
                Log::info("QR berhasil didekripsi tanpa base64", ['result' => $decrypted]);
                return $decrypted;
            } catch (\Exception $e) {
                Log::info("Gagal dekripsi, gunakan plain text");
            }

            // Jika semua gagal, gunakan text asli
            Log::info("Menggunakan plain text sebagai kode transaksi", ['code' => $encodedText]);
            return $encodedText;

        } catch (\Exception $e) {
            Log::error("Error saat dekripsi QR: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update status transaksi menjadi redeemed
     */
    public function redeemTransaction(Request $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->status !== 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak dapat di-redeem. Status saat ini: ' . $transaction->status
                ], 400);
            }

            $transaction->status = 'redeemed';
            $transaction->redeemed_at = now();
            $transaction->save();

            Log::info("Transaksi berhasil di-redeem", [
                'transaction_id' => $transaction->id,
                'code' => $transaction->code
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil di-redeem!',
                'transaction' => $transaction
            ]);

        } catch (\Exception $e) {
            Log::error("Gagal redeem transaksi: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses transaksi'
            ], 500);
        }
    }
}