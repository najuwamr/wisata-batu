<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function get_Tiket()
    {
        $data = Ticket::all();
        return view('admin.tiket-and-promo)', [
            'type' => 'tiket',
            'tickets' => $data
        ]);
    }

    public function get_Promo()
    {
        return view('admin.tiket-and-promo');
    }
}
