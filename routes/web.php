<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemesananController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes Based on Roles
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    });

    // Mitra Routes
    Route::middleware(['role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'mitra'])->name('dashboard');
    });

    // Penumpang Routes
    Route::middleware(['role:penumpang'])->prefix('penumpang')->name('penumpang.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'penumpang'])->name('dashboard');
        
        // Tahap 3: Pemesanan Tiket
        Route::get('/cari-jadwal', [PemesananController::class, 'index'])->name('cari');
        Route::get('/jadwal/{id}/kursi', [PemesananController::class, 'pilihKursi'])->name('pilih_kursi');
        Route::post('/jadwal/{id}/pesan', [PemesananController::class, 'pesan'])->name('pesan');
        Route::get('/pemesanan/{id}', [PemesananController::class, 'detailPemesanan'])->name('pemesanan.detail');
        Route::post('/pemesanan/{id}/bayar', [PemesananController::class, 'bayar'])->name('bayar');
    });
});
