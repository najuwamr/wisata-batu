<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function get_Promo()
    {
        return view('admin.tiket-and-promo');
    }
}
