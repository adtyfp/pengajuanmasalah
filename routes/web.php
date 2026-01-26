<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PengaduanController as SiswaPengaduanController;

// HOMEPAGE - Redirect langsung ke login
Route::get('/', function () {
    return redirect('/login'); // Gunakan URL langsung, bukan route name
});

// ========================
// AUTH ROUTES (Laravel Breeze)
// ========================
require __DIR__.'/auth.php';

// ========================
// SISWA ROUTES
// ========================
Route::middleware(['auth', 'siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    // Dashboard Siswa
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    
    // Pengaduan Siswa (hanya untuk siswa sendiri)
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [SiswaPengaduanController::class, 'index'])->name('index');
        Route::get('/create', [SiswaPengaduanController::class, 'create'])->name('create');
        Route::post('/', [SiswaPengaduanController::class, 'store'])->name('store');
        Route::get('/{pengaduan}', [SiswaPengaduanController::class, 'show'])->name('show');
    });
});

// ========================
// ADMIN ROUTES
// ========================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Pengaduan Management (untuk semua pengaduan)
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [AdminPengaduanController::class, 'index'])->name('index');
        Route::get('/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('show');
        Route::post('/{pengaduan}/status', [AdminPengaduanController::class, 'updateStatus'])->name('update-status');
    });
    
    // Kategori Management
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{kategori}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });
    
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/export', [LaporanController::class, 'export'])->name('export');
    });
});

// ========================
// FALLBACK ROUTE (untuk 404)
// ========================
Route::fallback(function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }
    }
    return redirect('/login');
});