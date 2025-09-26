<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function get_Tiket()
    {
        $data = Ticket::all();
        $promos = collect(); 
        $tab = 'tiket'; 
        return view('admin.tiket-and-promo', compact('data', 'promos', 'tab'));
    }
}
