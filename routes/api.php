<?php

use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::post('/payment/notification', [TransaksiController::class, 'notification']);
