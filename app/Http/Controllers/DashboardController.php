<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // === Filter Periode ===
        $period = $request->get('period', 'today');
        $today = Carbon::today();

        if ($period === 'today') {
            $start = $today;
            $end = $today;
        } elseif ($period === '7days') {
            $start = Carbon::now()->subDays(6)->startOfDay();
            $end = Carbon::now()->endOfDay();
        } elseif ($period === '30days') {
            $start = Carbon::now()->subDays(29)->startOfDay();
            $end = Carbon::now()->endOfDay();
        } elseif ($period === 'custom' && $request->date_from && $request->date_to) {
            $start = Carbon::parse($request->date_from)->startOfDay();
            $end = Carbon::parse($request->date_to)->endOfDay();
        } else {
            $start = $today;
            $end = $today;
        }

        // === 1️⃣ Total Transaksi ===
        $totalTransaksi = Transaction::whereBetween('created_at', [$start, $end])->count();

        // === 2️⃣ Total Pengunjung ===
        $totalPengunjung = TransactionDetail::whereBetween('transaction_detail.created_at', [$start, $end])
            ->sum('quantity');

        // === 3️⃣ Total Pendapatan ===
        $pendapatan = TransactionDetail::join('ticket', 'transaction_detail.ticket_id', '=', 'ticket.id')
            ->whereBetween('transaction_detail.created_at', [$start, $end])
            ->select(DB::raw('SUM(transaction_detail.subtotal) as total'))
            ->value('total');

        // === 4️⃣ Total Tiket Terjual ===
        $tiketTerjual = TransactionDetail::whereBetween('transaction_detail.created_at', [$start, $end])->sum('quantity');

        // === 5️⃣ Statistik Penjualan per Tiket ===
        $tiketStatsRaw = TransactionDetail::select('ticket_id', DB::raw('SUM(quantity) as qty'))
            ->whereBetween('transaction_detail.created_at', [$start, $end])
            ->groupBy('ticket_id')
            ->get();

        $tickets = Ticket::all();

        $tiket_stats = $tickets->map(function ($ticket) use ($tiketStatsRaw) {
            $stat = $tiketStatsRaw->firstWhere('ticket_id', $ticket->id);
            $qty = $stat ? $stat->qty : 0;

            $colors = ['blue', 'green', 'purple', 'yellow', 'red'];
            $color = $ticket->color ?? $colors[array_rand($colors)];

            return [
                'name' => $ticket->name,
                'qty' => $qty,
                'color' => $color,
            ];
        });

        return view('admin.dashboard', [
            'period'           => $period,
            'totalTransaksi'   => $totalTransaksi,
            'totalPengunjung'  => $totalPengunjung,
            'pendapatan'       => $pendapatan ?? 0,
            'tiketTerjual'     => $tiketTerjual,
            'tiket_stats'      => $tiket_stats,
            'start'            => $start->toDateString(),
            'end'              => $end->toDateString(),
        ]);
    }
}
