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
    public function klik_Laporan(Request $request)
    {
        $query = Transaction::with([
            'customer',
            'transactionDetail.ticket',
            'transactionDetail.promo'
        ]);

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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%{$search}%");
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 10);
        $transactions = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total' => Transaction::count(),
            'paid' => Transaction::where('status', 'paid')->count(),
            'pending' => Transaction::where('status', 'pending')->count(),
            'failed' => Transaction::where('status', 'failed')->count(),
            'redeemed' => Transaction::where('status', 'redeemed')->count(),
        ];

        if ($request->hasAny(['period', 'status', 'search', 'date_from', 'date_to'])) {
            $filteredQuery = Transaction::query();

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

    public function klik_scan()
    {
        return view('admin.scan');
    }

    public function decodeQr(Request $request)
{
    $decodedText = null;
    $message = null;
    $alertType = 'info';

    if ($request->filled('code')) {
        $decodedText = $request->code;
        Log::info("📷 QR diterima dari kamera", ['code' => $decodedText]);
    } elseif ($request->hasFile('qr_image')) {
        Log::info("📁 File upload diterima");

        $imagePath = $request->file('qr_image')->getPathname();
        $qrcode = new QrReader($imagePath);
        $decodedText = $qrcode->text();
        Log::info("✅ QR hasil upload dibaca", ['code' => $decodedText]);
    } else {
        Log::warning("🚫 Tidak ada QR dikirim");
        return back()->with('error', 'QR code tidak ditemukan.');
    }

    Log::info('➡️ Tahap dekripsi dimulai');
    $transactionCode = $this->decryptQrCode($decodedText);
    Log::info('🔓 Hasil dekripsi', ['decoded' => $transactionCode]);

    $transaction = Transaction::with(['customer', 'transactionDetail.ticket', 'transactionDetail.promo'])
        ->where('code', $transactionCode)
        ->first();

    if (!$transaction) {
        Log::warning("🚫 Transaksi tidak ditemukan", ['code' => $transactionCode]);
        return back()->with('error', 'Transaksi tidak ditemukan.');
    }

    Log::info('✅ Status transaksi ditemukan', [
        'code' => $transaction->code,
        'status' => $transaction->status,
        'tanggal_kedatangan' => $transaction->tanggal_kedatangan
    ]);

    Log::info('🔍 Sebelum parse tanggal');
    try {
        $tanggalKedatangan = Carbon::parse($transaction->tanggal_kedatangan);
    } catch (\Exception $e) {
        Log::error('💥 Gagal parse tanggal kedatangan', ['error' => $e->getMessage()]);
        return back()->with('error', 'Tanggal kedatangan tidak valid.');
    }

    Log::info('🕒 Setelah parse tanggal', ['tanggal' => $tanggalKedatangan]);
    $batasAkhir = $tanggalKedatangan->copy()->addDays(7);
    $sekarang = Carbon::now();

    Log::info('🧮 Hitung masa berlaku', [
        'batasAkhir' => $batasAkhir->toDateString(),
        'sekarang' => $sekarang->toDateString()
    ]);

    if ($sekarang->lt($tanggalKedatangan)) {
        $message = 'Transaksi belum dapat digunakan.';
        $alertType = 'error';
        Log::info('⏳ Belum waktunya datang');
    } elseif ($sekarang->gt($batasAkhir)) {
        $message = 'Transaksi sudah melewati masa berlaku.';
        $alertType = 'error';
        Log::info('⌛ Masa berlaku lewat');
    } else {
        Log::info('🚦 Masuk ke switch status', ['status' => $transaction->status]);
        switch ($transaction->status) {
            case 'failed':
                $message = 'Transaksi gagal.';
                $alertType = 'error';
                break;

            case 'pending':
                $message = 'Transaksi pending.';
                $alertType = 'warning';
                break;

            case 'redeemed':
                $message = 'Sudah digunakan.';
                $alertType = 'info';
                break;

            case 'paid':
                $message = 'Transaksi sudah dibayar. Silakan redeem.';
                $alertType = 'success';
                break;

            default:
                Log::warning('❓ Status tidak dikenali', ['status' => $transaction->status]);
                $message = 'Status tidak dikenali.';
                $alertType = 'warning';
                break;
        }
    }

    return view('admin.scan', compact('transaction'))->with($alertType, $message);
}

    private function decryptQrCode($encodedText)
    {
        $decodedBase64 = base64_decode($encodedText, true);

        if ($decodedBase64 !== false) {
            try {
                return Crypt::decrypt($decodedBase64);
            } catch (\Exception $e) {}
        }

        try {
            return Crypt::decrypt($encodedText);
        } catch (\Exception $e) {}

        return $encodedText;
    }

    public function redeemTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'paid') {
            return redirect()->back()->with('error', 'Hanya transaksi yang sudah dibayar yang dapat di-redeem.');
        }

        $transaction->update(['status' => 'redeemed']);

        Log::info('Transaksi berhasil di-redeem', [
            'transaction_id' => $transaction->id,
            'code' => $transaction->code,
        ]);

        return redirect()->route('loket.laporan')
            ->with('success', 'Transaksi berhasil di-redeem.');
    }
}
