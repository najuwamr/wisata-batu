<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// middleware

// ----- GENERATE QR -----
Route::prefix('pesan-tiket')->group(function () {
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/{id}/qr', [CustomerController::class, 'showQr'])->name('customer.qr');
    Route::view('/scan', 'admin.scan')->name('customer.scan.page');
// Route::get('/test-post', function () {
//     return view('admin.scan');
// });
    Route::post('/decode-scan', [CustomerController::class, 'decode'])->name('customer.decode.scan');
    Route::post('/decode-from-image', [CustomerController::class, 'decodeFromImage'])->name('customer.decode.from.image');

});
