<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Membuat laporan, scan, decode QR code, dan menampilkan data customer (sisi admin)
    public function klik_Laporan()
    {
        $transactions = Transaction::with([
            'customer',
            'status',
            'transactionDetail.ticket'
        ])->paginate(10);
        return view('admin.laporan_penjualan', compact('transactions'));
    }
}
