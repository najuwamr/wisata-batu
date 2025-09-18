<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// middleware

// ----- PEMESANAN TIKET -----
Route::prefix('pesan-tiket')->group(function () {
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/{id}/qr', [CustomerController::class, 'showQr'])->name('customer.qr');
    Route::view('/scan', 'admin.scan')->name('customer.scan.page');
    Route::post('/decode-scan', [CustomerController::class, 'decode'])->name('customer.decode.scan');
    Route::post('/decode-from-image', [CustomerController::class, 'decodeFromImage'])->name('customer.decode.from.image');
});

// ----- SCAN QR CODE -----
Route::prefix('scan')->group(function () {
    Route::get('/', [CustomerController::class, 'scanIndex'])->name('scan.index');
    Route::post('/decode', [CustomerController::class, 'decode'])->name('scan.decode');
});

// ----- LAPORAN -----
Route::prefix('laporan')->group(function () {

});
