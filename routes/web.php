<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('customer.landing');
});

// ----- GUEST -----
// ----- PEMESANAN TIKET -----
Route::prefix('pesan-tiket')->group(function () {
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/{id}/qr', [CustomerController::class, 'showQr'])->name('customer.qr');
});
// ----- PAYMENT -----
Route::prefix('pembayaran')->group(function () {

});



// ----- ADMIN -----
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    // ----- CRUD TIKET & PROMO -----
    Route::get('/tiket-promo', [TiketController::class, 'get_Tiket'])->name('admin.get.tiket');
    Route::get('/tiket-promo', [PromoController::class, 'get_Promo'])->name('admin.get.promo');
    // ----- CRUD INFORMASI -----

    // ----- CRUD LAPORAN -----

    // ----- CRUD RESTORAN -----

    // ----- CRUD SELECTA 360 -----

    // ----- SCAN QR CODE -----
    Route::prefix('scan')->group(function () {
        Route::get('/', [QRController::class, 'index'])->name('scan.index');
        Route::post('/decode', [QRController::class, 'decode'])->name('scan.decode');
        Route::post('/decode-from-image', [QRController::class, 'decodeFromImage'])->name('scan.decode.from.image');
    });
});
// ----- SCAN QR CODE -----

