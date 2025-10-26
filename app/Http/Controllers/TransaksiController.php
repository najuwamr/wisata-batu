<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\CoreApi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Mail\EticketMail;
use Midtrans\Notification;

class TransaksiController extends Controller
{
    protected $sheetsService;

    public function __construct(GoogleSheetsService $sheetsService)
    {
        $this->sheetsService = $sheetsService;
    }

    public function charge(Request $request)
    {
        // dd(session()->all());
        $checkout = session('checkout_data');

        if (!$checkout) {
            return response()->json(['error' => 'Checkout session tidak ditemukan'], 400);
        }

        $orderId = 'ORDER-' . strtoupper(uniqid());
        $grossAmount = $checkout['total'] ?? $request->gross_amount;

        session(['midtrans_order_id' => $orderId]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $checkout['name'],
                'email' => $checkout['email'],
                'phone' => $checkout['whatsapp'],
            ],
            'callbacks' => [
                'finish' => route('checkout.finish', ['order_id' => $orderId]),
            ],
        ];

        $paymentType = $request->input('payment_type');
        switch ($paymentType) {
            case 'bca_va':
            case 'bni_va':
            case 'bri_va':
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => explode('_', $paymentType)[0]];
                break;

            case 'mandiri_bill':
                $params['payment_type'] = 'echannel';
                $params['echannel'] = [
                    'bill_info1' => 'Payment',
                    'bill_info2' => 'Online Purchase',
                ];
                break;

            case 'qris':
                $params['payment_type'] = 'qris';
                break;

            case 'gopay':
            case 'shopeepay':
                $params['payment_type'] = $paymentType;
                $params[$paymentType] = [
                    'callback_url' => url('/payment/finish/' . $orderId),
                ];
                break;

            default:
                return response()->json(['error' => 'Metode pembayaran tidak valid'], 400);
        }

        try {
            DB::beginTransaction();

            // 1️⃣ Coba cari berdasarkan email
            $customer = Customer::where('email', $checkout['email'])->first();

            // 2️⃣ Kalau tidak ada, coba cari berdasarkan telepon
            if (!$customer) {
                $customer = Customer::where('telephone', $checkout['whatsapp'])->first();
            }

            // 3️⃣ Jika ada (entah dari email atau telepon), update data jika berbeda
            if ($customer) {
                $needsUpdate = false;

                if ($customer->name !== $checkout['name']) {
                    $customer->name = $checkout['name'];
                    $needsUpdate = true;
                }

                if ($customer->email !== $checkout['email']) {
                    $customer->email = $checkout['email'];
                    $needsUpdate = true;
                }

                if ($customer->telephone !== $checkout['whatsapp']) {
                    $customer->telephone = $checkout['whatsapp'];
                    $needsUpdate = true;
                }

                if ($needsUpdate) {
                    $customer->save();
                }
            }
            // 4️⃣ Jika belum ada sama sekali, buat baru
            else {
                $customer = Customer::create([
                    'name' => $checkout['name'],
                    'email' => $checkout['email'],
                    'telephone' => $checkout['whatsapp'],
                ]);
            }

            // 2️⃣ Simpan transaksi utama
            $today = now()->format('Y-m-d');

            do {
                $todayCount = Transaction::whereDate('created_at', $today)->count() + 1;
                $sequence = str_pad($todayCount % 1000, 3, '0', STR_PAD_LEFT); // reset tiap 1000
                $random = Str::upper(Str::random(6));
                $code = 'SLCT-' . $random . $sequence;
            } while (Transaction::where('code', $code)->exists());

            $transaction = Transaction::create([
                'code' => $code,
                'tanggal_kedatangan' => $checkout['date'],
                'midtrans_order_id' => $orderId,
                'total_price' => $grossAmount,
                'status' => 'pending',
                'customer_id' => $customer->id,
                'payment_methode_id' => $checkout['payment_methode_id'] ?? 1,
            ]);

            // 3️⃣ Simpan detail transaksi
           if (!empty($checkout['cart_items'])) {
                foreach ($checkout['cart_items'] as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'ticket_id' => $item['id'],
                        'quantity' => $item['qty'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }
            }

            // 4️⃣ Kirim ke Midtrans
            $charge = CoreApi::charge($params);

            // Update transaksi dengan data Midtrans
            $transaction->update([
                'midtrans_tr_id' => $charge->transaction_id ?? null,
                'status' => $charge->transaction_status ?? 'pending',
            ]);

            DB::commit();

            // 5️⃣ Response hasil pembayaran
            if (isset($charge->va_numbers)) {
                $va = $charge->va_numbers[0];

                session()->forget(['cart']);

                return response()->json([
                    'status' => 'success',
                    'type' => 'va',
                    'bank' => strtoupper($va->bank),
                    'va_number' => $va->va_number,
                    'amount' => $charge->gross_amount,
                    'order_id' => $orderId,
                ]);
            }

            if (isset($charge->bill_key)) {

                session()->forget(['cart']);

                return response()->json([
                    'status' => 'success',
                    'type' => 'mandiri',
                    'bill_key' => $charge->bill_key,
                    'biller_code' => $charge->biller_code,
                    'amount' => $charge->gross_amount,
                    'order_id' => $orderId,
                ]);
            }

            if (isset($charge->actions)) {

                session()->forget(['cart']);

                return response()->json([
                    'status' => 'redirect',
                    'url' => $charge->actions[0]->url,
                    'order_id' => $orderId,
                ]);
            }

            return response()->json(['status' => 'unknown', 'data' => $charge]);

        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    // 📌 Webhook dari Midtrans
    public function notification(Request $request)
    {
        try {
            $notif = new Notification();
            $orderId = $notif->order_id ?? $request->input('order_id');
            $transactionStatus = $notif->transaction_status ?? $request->input('transaction_status');

            if (!$orderId) {
                Log::error("❌ Notifikasi Midtrans tidak memiliki order_id yang valid.");
                return response()->json(['message' => 'order_id tidak valid'], 400);
            }

            $transaction = Transaction::with(['customer', 'transactionDetail.ticket'])
                ->where('midtrans_order_id', $orderId)
                ->first();

            if (!$transaction) {
                Log::warning("⚠️ Transaksi tidak ditemukan untuk order_id {$orderId}");
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            Log::info("📩 Notifikasi Midtrans diterima untuk {$orderId}, status: {$transactionStatus}");

            // Tentukan status baru
            $newStatus = match ($transactionStatus) {
                'settlement', 'capture' => 'paid',
                'pending' => 'pending',
                'deny', 'cancel', 'expire' => 'failed',
                default => $transaction->status,
            };

            $oldStatus = $transaction->status;

            // Update status jika berubah
            if ($oldStatus !== $newStatus) {
                $transaction->update(['status' => $newStatus]);
                Log::info("🔁 Status transaksi {$orderId} diupdate dari {$oldStatus} ke {$newStatus}");
            }

            // 🚀 Jalankan hanya saat pertama kali berubah ke "paid"
            if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                session()->forget(['checkout_data']);

                /**
                 * === SYNC KE GOOGLE SHEETS ===
                 */
                if (!$transaction->synced_to_sheets) {
                    try {
                        $this->syncToGoogleSheets($transaction);
                        Log::info("✅ Transaksi {$transaction->code} berhasil di-sync ke Google Sheets");
                    } catch (\Throwable $e) {
                        Log::error("❌ Gagal sync ke Google Sheets untuk {$transaction->code}: {$e->getMessage()}");
                    }
                } else {
                    Log::info("⏩ Transaksi {$transaction->code} sudah di-sync ke Google Sheets, dilewati.");
                }

                /**
                 * === KIRIM EMAIL E-TICKET ===
                 */
                try {
                    $payload = $transaction->code;
                    $encrypted = Crypt::encrypt($payload);
                    $qrCode = base64_encode($encrypted);
                    $tempPath = storage_path('app/temp/etiket-' . $transaction->code . '.pdf');

                    // Path ke CSS (kalau kamu pakai vite atau laravel mix)
                    $manifestPath = public_path('build/manifest.json');
                    $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : null;
                    $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
                    $cssPath = $cssFile ? public_path('build/' . $cssFile) : null;

                    Pdf::view('customer.your-e-tiket', [
                        'transaction' => $transaction,
                        'qrCode' => $qrCode,
                    ])
                        ->format('A4')
                        ->withBrowsershot(function ($browsershot) use ($cssPath) {
                            if ($cssPath && file_exists($cssPath)) {
                                $browsershot->setOption('userStyleSheet', $cssPath);
                            }
                        })
                        ->save($tempPath);

                    Mail::to($transaction->customer->email)
                        ->send(new EticketMail($transaction, $tempPath));

                    if (file_exists($tempPath)) unlink($tempPath);

                    Log::info("📧 E-ticket {$transaction->code} dikirim ke {$transaction->customer->email}");
                } catch (\Throwable $e) {
                    Log::error("❌ Gagal mengirim e-ticket {$transaction->code}: {$e->getMessage()}");
                }
            } elseif (in_array($newStatus, ['failed', 'cancel', 'expire'])) {
                session()->forget(['checkout_data']);
                Log::info("🚫 Transaksi {$transaction->code} gagal atau dibatalkan.");
            } else {
                Log::info("ℹ️ Transaksi {$transaction->code} status {$newStatus}, tidak ada tindakan lanjut.");
            }

            return response()->json(['message' => 'Notifikasi berhasil diproses'], 200);

        } catch (\Throwable $e) {
            Log::error("🔥 Gagal memproses notifikasi Midtrans: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan internal'], 500);
        }
    }


    /**
     * 🔥 Sync transaction ke Google Sheets
     */
    protected function syncToGoogleSheets(Transaction $transaction)
    {
        // Cek apakah sudah pernah di-sync
        if ($transaction->synced_to_sheets) {
            Log::info("Transaction {$transaction->code} sudah pernah di-sync, skip.");
            return;
        }

        try {
            Log::info("Syncing transaction {$transaction->code} to Google Sheets");

            $result = $this->sheetsService->addPaidTransaction($transaction);

            // Update flag synced
            $transaction->update([
                'synced_to_sheets' => true,
                'spreadsheet_id' => $result['spreadsheet_id'],
            ]);

            Log::info("Transaction {$transaction->code} synced successfully", [
                'spreadsheet_id' => $result['spreadsheet_id'],
                'sheet_name' => $result['sheet_name'],
                'rows_added' => $result['rows_added']
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to sync transaction {$transaction->code} to Google Sheets", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Jangan throw error supaya payment tetap tercatat
            // Bisa retry manual nanti dengan command
        }
    }

    // 📌 Callback redirect ke user
    public function finish($orderId)
    {
        $transaction = Transaction::with(['customer', 'transactionDetail.ticket'])
            ->where('midtrans_order_id', $orderId)
            ->firstOrFail();

        $qrCode = null;

        // Jika sudah paid, buat payload QR
        if ($transaction->status === 'paid') {
            $ticketItems = $transaction->transactionDetail->map(function ($detail) {
                return [
                    'ticket_name' => $detail->ticket->name ?? '-',
                    'qty' => $detail->quantity ?? 0,
                ];
            })->toArray();

            $payload = $transaction->code;

            $encrypted = Crypt::encrypt($payload);
            $qrCode = base64_encode($encrypted);
        }

        return view('customer.finish', compact('transaction', 'qrCode'));
    }
}
