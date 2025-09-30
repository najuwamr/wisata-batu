<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Promo;

class LandingPageController extends Controller
{
    public function index(){
         $tiketAktif = Ticket::where('is_active', true)
                    ->where('category', 'tiket')
                    ->get();

         $review = [
    [
        'user'  => 'Dio12',
        'image' => asset('assets/review/profile.svg'),
        'komen' => 'Sukak bgt sama tempatnya,lengkapppppl ada pool ada park juga dan byk wahana juga disana,pokokknya ini salah satuu wisata terbaik di Batu',
    ],
    [
        'user'  => 'Tika',
        'image' => asset('assets/review/profile.svg'),
        'komen' => 'Sukak bgt sama tempatnya,lengkapppppl ada pool ada park juga dan byk wahana juga disana,pokokknya ini salah satuu wisata terbaik di Batu',
    ],
    [
        'user'  => 'Arini',
        'image' => asset('assets/review/profile.svg'),
        'komen' => 'Sukak bgt sama tempatnya,lengkapppppl ada pool ada park juga dan byk wahana juga disana,pokokknya ini salah satuu wisata terbaik di Batu',
    ],
    [
        'user'  => 'King Odi',
        'image' => asset('assets/review/profile.svg'),
        'komen' => 'Sukak bgt sama tempatnya,lengkapppppl ada pool ada park juga dan byk wahana juga disana,pokokknya ini salah satuu wisata terbaik di Batu',
    ],
    [
        'user'  => 'Nada',
        'image' => asset('assets/review/profile.svg'),
        'komen' => 'Sukak bgt sama tempatnya,lengkapppppl ada pool ada park juga dan byk wahana juga disana,pokokknya ini salah satuu wisata terbaik di Batu',
    ],
    [
        'user'  => 'Nadia',
        'image' => asset('assets/review/profile.svg'),
        'komen' => 'Sukak bgt sama tempatnya,lengkapppppl ada pool ada park juga dan byk wahana juga disana,pokokknya ini salah satuu wisata terbaik di Batu',
    ],
];

        $promo = Promo::where('is_active', true)->get();

        $mitra = [
            [
                'image' => asset('assets/customer/Logo-Pemkot.svg'),
            ],
            [
                'image' => asset('assets/customer/Logo-hotelselecta.webp'),
            ],
            [
                'image' => asset('assets/customer/Logo-PesonaInd.png'),
            ],
            [
                'image' => asset('assets/customer/Logo-PHRI.png'),
            ],

        ];

         return view('customer.landing', compact('tiketAktif', 'review', 'promo', 'mitra'));
    }


}

