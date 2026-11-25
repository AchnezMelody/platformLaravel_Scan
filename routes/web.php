<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BotolController;
use App\Http\Middleware\CekLogin;
use Illuminate\Support\Facades\Route;

// ---- Layar Mulai (sebelum login) ----
Route::get('/', [AuthController::class, 'beranda']);

// ---- Login ----
Route::get('/login', [AuthController::class, 'form'])->name('login');
Route::post('/login', [AuthController::class, 'masuk']);

// ---- Dipanggil Python / sensor (tanpa login) ----
Route::get('/status', [BotolController::class, 'status']);
Route::post('/tambah', [BotolController::class, 'tambah']);

// ---- Harus login ----
Route::middleware(CekLogin::class)->group(function () {
    Route::get('/mesin', [BotolController::class, 'index']);
    Route::get('/data', [BotolController::class, 'data']);
    Route::post('/mulai', [BotolController::class, 'mulai']);
    Route::post('/ambil', [BotolController::class, 'ambil']);
    Route::post('/batal', [BotolController::class, 'batal']);
    Route::post('/logout', [AuthController::class, 'keluar']);
});