<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $jenisTiket = Ticket::select('id', 'name')->get();
    return view('admin.dashboard', compact('jenisTiket'));
}
}
