<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function get_Promo()
    {
        $promos = Promo::all(); 
        $data = collect(); // kosongkan biar gak error
        $tab = 'promo'; // tandai tab aktif
        return view('admin.tiket-and-promo', compact('data', 'promos', 'tab'));
    }
}
