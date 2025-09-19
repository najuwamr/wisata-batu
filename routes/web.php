<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
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
    // ----- CRUD TIKET & PROMO -----
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/tiket', [TiketController::class, 'get_Tiket'])->name('admin.get.tiket');
    Route::get('/promo', [TiketController::class, 'get_Promo'])->name('admin.get.promo');

});
// ----- SCAN QR CODE -----
Route::prefix('scan')->group(function () {
    Route::get('/', [QRController::class, 'index'])->name('scan.index');
    Route::post('/decode', [QRController::class, 'decode'])->name('scan.decode');
    Route::post('/decode-from-image', [QRController::class, 'decodeFromImage'])->name('scan.decode.from.image');
});

// ----- LAPORAN -----
Route::prefix('laporan')->group(function () {

});
