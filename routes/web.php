<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EtiketController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('Beranda');


// ----- PROMO -----
Route::prefix('promo')->group(function () {
  Route::get('/lihat-promo', [PromoController::class, 'index'])->name('guest.promo');
  Route::get('/lihat-promo/{id}', [PromoController::class, 'show'])->name('promo.show');
});

// ----- GUEST -----
// ----- TIKET -----
Route::get('tiket/', [TiketController::class, 'index_tiket'])->name('guest.tiket');
Route::get('tiket/{id}/detail', [TiketController::class, 'detail_tiket'])->name('guest.tiket.detail');




// ----- KERANJANG -----
Route::get('/keranjang', [KeranjangController::class, 'keranjang'])->name('keranjang');
Route::get('/keranjang/tiket', [KeranjangController::class, 'getTiket'])->name('keranjang.tiket'); // Tambahkan ini
Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
Route::delete('/keranjang/clear', [KeranjangController::class, 'clear'])->name('keranjang.clear');

// ----- CHECKOUT & TRANSAKSI -----
Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/pembayaran', [CheckoutController::class, 'pembayaran'])->name('checkout.pembayaran');
Route::post('/checkout/charge', [TransaksiController::class, 'charge'])->name('checkout.charge');
Route::get('/payment/finish/{order_id}', [TransaksiController::class, 'finish'])->name('checkout.finish');


// ----- PEMESANAN TIKET -----
Route::prefix('pesan-tiket')->group(function () {
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/{id}/qr', [CustomerController::class, 'showQr'])->name('customer.qr');
});

// ----- ADMIN -----
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    // ----- CRUD TIKET & PROMO -----
    Route::get('/tiket-promo/tiket', [TiketController::class, 'get_tiket'])->name('admin.tiket.get');
    Route::get('/tiket-promo/tiket/tambah', [TiketController::class, 'tambah_tiket'])->name('admin.tiket.tambah');
    Route::post('/tiket-promo/tiket/', [TiketController::class, 'insert_tiket'])->name('admin.tiket.insert');
    Route::get('/tiket-promo/tiket/{id}/edit', [TiketController::class, 'edit_tiket'])->name('admin.tiket.edit');
    Route::put('/tiket-promo/tiket/{id}', [TiketController::class, 'update_tiket'])->name('admin.tiket.update');
    Route::post('/tiket-promo/tiket/{id}/hapus', [TiketController::class, 'delete'])->name('admin.tiket.delete');
    Route::post('/tiket-promo/tiket/{id}/pulihkan', [TiketController::class, 'restore'])->name('admin.tiket.restore');
    Route::delete('/tiket-promo/tiket/{id}/hapus-permanen', [TiketController::class, 'destroy'])->name('admin.tiket.destroy');

    Route::get('/tiket-promo/promo', [PromoController::class, 'get_promo'])->name('admin.promo.get');

    // Route::get('/tiket-promo/tiket', [TiketController::class, 'get_Tiket'])->name('admin.get.tiket');
    // Route::get('/tiket-promo/tiket/tambah', [TiketController::class, 'tambah_tiket'])->name('admin.tambah.tiket');
    // Route::post('/tiket-promo/tiket/', [TiketController::class, 'insert_tiket'])->name('admin.tiket.insert');
    // Route::get('/tiket-promo/tiket/{id}/edit', [TiketController::class, 'edit_tiket'])->name('admin.edit.tiket');
    // Route::put('/tiket-promo/tiket/{id}', [TiketController::class, 'update_tiket'])->name('admin.update.tiket');
    // Route::post('/tiket-promo/tiket/{id}/delete', [TiketController::class, 'delete'])->name('admin.tiket.delete');
    // Route::post('/tiket-promo/tiket/{id}/restore', [TiketController::class, 'restore'])->name('admin.tiket.restore');

    // Route::get('/tiket-promo/promo', [PromoController::class, 'get_Promo'])->name('admin.get.promo');
    // Route::get('/tiket-promo/promo/tambah', [PromoController::class, 'tambah_Promo'])->name('admin.tambah.promo');
    // Route::post('/tiket-promo/promo/', [PromoController::class, 'insert_Promo'])->name('admin.insert.promo');
    // Route::get('/tiket-promo/promo/{id}/edit', [PromoController::class, 'edit_Promo'])->name('admin.edit.promo');
    // Route::put('/tiket-promo/promo/{id}', [PromoController::class, 'update_Promo'])->name('admin.update.promo');
    // Route::post('/tiket-promo/promo/{id}/delete', [PromoController::class, 'delete'])->name('admin.promo.delete');
    // Route::post('/tiket-promo/promo/{id}/restore', [PromoController::class, 'restore'])->name('admin.promo.restore');
    // ----- CRUD INFORMASI -----

    // ----- CRUD LAPORAN -----
    Route::get('/laporan', [LaporanController::class, 'klik_laporan'])->name('admin.laporan');
    // ----- CRUD RESTORAN -----

    // ----- CRUD SELECTA 360 -----

});

Route::prefix('loket')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('loket.dashboard');
    // ----- SCAN QR CODE -----
    Route::get('/scan', [LaporanController::class, 'klik_scan'])->name('loket.scan');
    Route::post('/scan/decode', [LaporanController::class, 'decodeQr'])->name('loket.scan.decode');
    // ----- CRUD LAPORAN -----
    Route::get('/laporan', [LaporanController::class, 'klik_laporan'])->name('loket.laporan');

// Route untuk decode hasil QR
// Route::post('/admin/laporan/decode-qr', [LaporanController::class, 'decodeQr'])->name('admin.laporan.decodeQr');

});

Route::get('/google/auth', [GoogleAuthController::class, 'redirect']);
Route::get('/google/callback', [GoogleAuthController::class, 'callback']);
