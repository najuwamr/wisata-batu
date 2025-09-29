<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index_Tiket'])->name('landing');



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
    Route::get('/tiket-promo/tiket/tambah', [TiketController::class, 'tambah_tiket'])->name('admin.tambah.tiket');
    Route::post('/tiket-promo/tiket/', [TiketController::class, 'insert_tiket'])->name('admin.insert.tiket');
    Route::get('/tiket-promo/tiket/{id}/edit', [TiketController::class, 'edit_tiket'])->name('admin.edit.tiket');
    Route::put('/tiket-promo/tiket/{id}', [TiketController::class, 'update_tiket'])->name('admin.update.tiket');
    Route::post('/tiket-promo/tiket/{id}/delete', [TiketController::class, 'delete'])->name('admin.tiket.delete');
    Route::post('/tiket-promo/tiket/{id}/restore', [TiketController::class, 'restore'])->name('admin.tiket.restore');

    Route::get('/tiket-promo/promo', [PromoController::class, 'get_Promo'])->name('admin.get.promo');
    Route::get('/tiket-promo/promo/tambah', [PromoController::class, 'tambah_Promo'])->name('admin.tambah.promo');
    Route::post('/tiket-promo/promo/', [PromoController::class, 'insert_Promo'])->name('admin.insert.promo');
    Route::get('/tiket-promo/promo/{id}/edit', [PromoController::class, 'edit_Promo'])->name('admin.edit.promo');
    Route::put('/tiket-promo/promo/{id}', [PromoController::class, 'update_Promo'])->name('admin.update.promo');
    Route::post('/tiket-promo/promo/{id}/delete', [PromoController::class, 'delete'])->name('admin.promo.delete');
    Route::post('/tiket-promo/promo/{id}/restore', [PromoController::class, 'restore'])->name('admin.promo.restore');
    // ----- CRUD INFORMASI -----

    // ----- CRUD LAPORAN -----
    Route::get('/laporan', [LaporanController::class, 'klik_laporan'])->name('admin.laporan');
    // ----- CRUD RESTORAN -----

    // ----- CRUD SELECTA 360 -----

});

Route::prefix('loket')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('loket.dashboard');
    // ----- SCAN QR CODE -----
    Route::get('/scan', [QRController::class, 'index'])->name('loket.scan');
    Route::post('/scan/decode', [QRController::class, 'decode'])->name('loket.scan.decode');
    // ----- CRUD LAPORAN -----
    Route::get('/laporan', [LaporanController::class, 'klik_laporan'])->name('loket.laporan');
});
