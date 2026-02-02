<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PengaduanController as SiswaPengaduanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\PengaduanController;

/*
|--------------------------------------------------------------------------
| Redirect homepage ke login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect('/login'),
        };
    }
    return redirect('/login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Auth routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| SISWA ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        // Dashboard Siswa
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
            ->name('dashboard');

        // Pengaduan Management
        Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
            Route::get('/', [SiswaPengaduanController::class, 'index'])->name('index');
            Route::get('/create', [SiswaPengaduanController::class, 'create'])->name('create');
            Route::post('/', [SiswaPengaduanController::class, 'store'])->name('store');
            Route::get('/{pengaduan}', [SiswaPengaduanController::class, 'show'])->name('show');
            
            // Jika butuh edit untuk siswa (opsional)
            // Route::get('/{pengaduan}/edit', [SiswaPengaduanController::class, 'edit'])->name('edit');
            // Route::put('/{pengaduan}', [SiswaPengaduanController::class, 'update'])->name('update');
        });

        // Profile Siswa (opsional)
        Route::get('/profile', function () {
            return view('siswa.profile');
        })->name('profile');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Pengaduan Management
        Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
            Route::get('/', [AdminPengaduanController::class, 'index'])->name('index');
            Route::get('/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('show');
            Route::get('/{pengaduan}/edit', [AdminPengaduanController::class, 'edit'])->name('edit');
            Route::post('/{pengaduan}/status', [AdminPengaduanController::class, 'updateStatus'])->name('update-status');
            
            // Jika butuh delete pengaduan (opsional)
            // Route::delete('/{pengaduan}', [AdminPengaduanController::class, 'destroy'])->name('destroy');
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

        // Laporan Management
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::get('/export', [LaporanController::class, 'export'])->name('export');
            Route::get('/preview', [LaporanController::class, 'preview'])->name('preview');
        });

        // Profile Admin (opsional)
        Route::get('/profile', function () {
            return view('admin.profile');
        })->name('profile');

        // Users Management (opsional - jika perlu manage users)
        // Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| COMMON ROUTES (untuk kedua role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Profile update
    Route::get('/profile', function () {
        return match(auth()->user()->role) {
            'admin' => redirect()->route('admin.profile'),
            'siswa' => redirect()->route('siswa.profile'),
            default => abort(404),
        };
    })->name('profile');
    
    // Notifications (opsional)
    Route::get('/notifications', function () {
        // Implement notifications
        return view('notifications.index');
    })->name('notifications');
});

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::resource('pengaduan', PengaduanController::class);
});
