<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                'finish' => url('/payment/finish?order_id=' . $orderId),
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
                Log::error("Notifikasi Midtrans tidak memiliki order_id yang valid.");
                return response()->json(['message' => 'order_id tidak valid'], 400);
            }

            $transaction = Transaction::with(['customer', 'transactionDetail.ticket'])
                ->where('midtrans_order_id', $orderId)
                ->first();

            if (!$transaction) {
                Log::warning("Notifikasi Midtrans: Transaksi tidak ditemukan untuk order_id {$orderId}");
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            Log::info("Notifikasi Midtrans diterima untuk Order ID: {$orderId}, Status: {$transactionStatus}");

            $status = match ($transactionStatus) {
                'settlement', 'capture' => 'paid',
                'pending' => 'pending',
                'deny', 'cancel', 'expire' => 'failed',
                default => $transaction->status,
            };

            if ($transaction->status !== $status) {
                $transaction->status = $status;
                $transaction->saveOrFail(); // ✅ biar pasti tersimpan atau error

                Log::info("Transaksi {$orderId} diupdate ke status {$status}");

                // ✉️ Kirim e-ticket HANYA SEKALI saat pertama kali berubah jadi paid
                if ($status === 'paid') {
                    try {
                        session()->forget(['checkout_data']);

                        // --- QR Code terenkripsi ---
                        $payload = $transaction->code;
                        $encrypted = Crypt::encrypt($payload);
                        $qrCode = base64_encode($encrypted);

                        // --- Path file PDF sementara ---
                        $tempPath = storage_path('app/temp/etiket-' . $transaction->code . '.pdf');

                        // --- Ambil file CSS dari manifest ---
                        $manifestPath = public_path('build/manifest.json');
                        $manifest = file_exists($manifestPath)
                            ? json_decode(file_get_contents($manifestPath), true)
                            : null;

                        $cssFile = $manifest && isset($manifest['resources/css/app.css']['file'])
                            ? public_path('build/' . $manifest['resources/css/app.css']['file'])
                            : null;

                        // --- Generate PDF e-ticket ---
                        Pdf::view('customer.your-e-tiket', [
                            'transaction' => $transaction,
                            'qrCode' => $qrCode,
                        ])
                        ->format('A4')
                        ->withBrowsershot(function ($browsershot) use ($cssFile) {
                            if ($cssFile && file_exists($cssFile)) {
                                $browsershot->setOption('userStyleSheet', $cssFile);
                            }
                        })
                        ->save($tempPath);

                        // --- Kirim email dengan e-ticket ---
                        Mail::to($transaction->customer->email)
                            ->send(new EticketMail($transaction, $tempPath));

                        // --- Hapus file sementara ---
                        if (file_exists($tempPath)) {
                            unlink($tempPath);
                        }

                        Log::info("E-Ticket dikirim ke {$transaction->customer->email}");
                    } catch (\Exception $e) {
                        Log::error("Gagal mengirim E-Ticket untuk {$orderId}: " . $e->getMessage());
                    }
                } elseif ($status === 'failed') {
                    session()->forget(['checkout_data']);
                }
            } else {
                // 🚫 Status tidak berubah, jadi lewati semua proses
                Log::info("Transaksi {$orderId} sudah berstatus {$status}, lewati pengiriman ulang.");
            }

            return response()->json(['message' => 'Notifikasi berhasil diproses'], 200);
        } catch (\Exception $e) {
            Log::error("Gagal memproses notifikasi Midtrans: " . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan internal'], 500);
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
