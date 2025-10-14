<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class EtiketController extends Controller
{
    public function preview($transaction)
    {
        $transaction = Transaction::with('customer')->findOrFail($transaction);
        $qrCode = request('qr');

        return view('customer.tiket.e-tiket', compact('transaction', 'qrCode'));
    }

}
