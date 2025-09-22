<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jenisTiket = Ticket::select('id', 'name')->get();
        $tahun = now()->year;
        $data = DB::table('transaction')
            ->join('transaction_detail', 'transaction.id', '=', 'transaction_detail.transaction_id')
            ->join('ticket', 'transaction_detail.ticket_id', '=', 'ticket.id')
            ->selectRaw('
                MONTH(transaction.created_at) as bulan,
                ticket.name,
                SUM(transaction_detail.quantity) as total
            ')
            ->whereYear('transaction.created_at', $tahun)
            // ->where('transactions.status', 'paid')
            ->groupBy('bulan', 'ticket.name')
            ->get();

        $labels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        $paket = array_fill(0, 12, 0);
        $reguler = array_fill(0, 12, 0);

        foreach ($data as $row) {
            $index = $row->bulan - 1;
            if ($row->name === 'Tiket Paket Wahana') {
                $paket[$index] = $row->total;
            } elseif ($row->name === 'Tiket Reguler') {
                $reguler[$index] = $row->total;
            }
        }

        return view('admin.dashboard', compact('jenisTiket', 'labels', 'paket', 'reguler'));
    }
}
