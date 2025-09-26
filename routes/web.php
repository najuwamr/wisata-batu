<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
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
    Route::get('/tiket-promo/tiket', [TiketController::class, 'get_Tiket'])->name('admin.get.tiket');
    Route::get('/tiket-promo/promo', [PromoController::class, 'get_Promo'])->name('admin.get.promo');
    // ----- CRUD INFORMASI -----

    // ----- CRUD LAPORAN -----
    Route::get('/laporan', [LaporanController::class, 'klik_laporan'])->name('admin.laporan');
    // ----- CRUD RESTORAN -----

    // ----- CRUD SELECTA 360 -----

});

Route::prefix('loket')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('loket.dashboard');
    // ----- SCAN QR CODE -----
    Route::get('/scan', [QRController::class, 'index'])->name('loket.scan.index');
    Route::post('/scan/decode', [QRController::class, 'decode'])->name('loket.scan.decode');
    // ----- CRUD LAPORAN -----
});
