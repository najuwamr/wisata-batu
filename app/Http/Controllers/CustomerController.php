<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Zxing\QrReader;

class CustomerController extends Controller
{
    public function create()
    {
        return view('admin.create-customer');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'wa_number' => 'required|string|max:20',
        ]);

        // Cari dulu berdasarkan email ATAU wa_number
        $customer = Customer::where('email', $request->email)
            ->orWhere('wa_number', $request->wa_number)
            ->first();

        if ($customer) {
            // Kalau ketemu, update data lama dengan yang terbaru
            $customer->update([
                'name'      => $request->name,
                'email'     => $request->email,     // overwrite dengan yang baru
                'wa_number' => $request->wa_number, // overwrite dengan yang baru
            ]);
        } else {
            // Kalau belum ada, buat customer baru
            $customer = Customer::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'wa_number' => $request->wa_number,
            ]);
        }

        return redirect()->route('customer.qr', $customer->id);
    }

    public function showQr($id)
    {
        $customer = Customer::findOrFail($id);

        // Data terenkripsi
        $encrypted = Crypt::encryptString(json_encode([
            'id'    => $customer->id,
            'name'  => $customer->name,
            'email' => $customer->email,
            'wa_number' => $customer->wa_number,
        ]));

        // QR string (encode biar aman)
        $qrString = base64_encode($encrypted);

        return view('admin.qr', compact('qrString', 'customer'));
    }

    public function decode(Request $request)
    {
        try {
            $encodedData = $request->input('qr_data'); // hasil scan kamera
            $decoded = base64_decode($encodedData);
            $customerData = Crypt::decryptString($decoded);
            $customer = json_decode($customerData, true);

            return response()->json([
                'status'   => 'success',
                'data'     => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid'
            ], 400);
        }
    }


    // public function decodeFromImage(Request $request)
    // {
    //     $request->validate([
    //         'qr_image' => 'required|image|mimes:png,jpg,jpeg'
    //     ]);

    //     $image = $request->file('qr_image');

    //     $qrcode = new \Zxing\QrReader($image->getPathname());
    //     $text = $qrcode->text();

    //     try {
    //         $decoded   = base64_decode($text);
    //         $decrypted = Crypt::decryptString($decoded);
    //         $customer  = json_decode($decrypted, true);

    //         return response()->json([
    //             'status' => 'success',
    //             'data'   => $customer
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'QR tidak valid: ' . $e->getMessage()
    //         ], 400);
    //     }
    // }

}
