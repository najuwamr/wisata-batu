<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class LandingPageController extends Controller
{
    public function index_Tiket(){
         $tiketAktif = Ticket::where('is_active', true)
                    ->where('category', 'tiket')
                    ->get();

         return view('customer.landing', compact('tiketAktif'));
    }
}
