<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\owner\DashboardController;
use App\Http\Controllers\owner\SapiController;
use App\Http\Controllers\owner\KesehatanController;
use App\Http\Controllers\owner\PenjualanController;
use App\Http\Controllers\owner\ProduksiController;
use App\Http\Controllers\owner\LaporanController;
use App\Http\Controllers\karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\karyawan\KesehatanController as KaryawanKesehatanController;
use App\Http\Controllers\karyawan\ProduksiController as KaryawanProduksiController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Parman Farm Monitoring System
|
*/

// Halaman utama landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Public API: real-time production stats for landing page (no auth needed)
Route::get('/api/landing-stats', [LandingController::class, 'stats'])->name('landing.stats');

// Fallback dashboard Breeze (redirect ke owner atau karyawan dashboard berdasarkan role)
Route::get('/dashboard', function () {
    if (auth()->user()->isKaryawan()) {
        return redirect()->route('karyawan.dashboard');
    }
    return redirect()->route('owner.dashboard');
})->middleware(['auth'])->name('dashboard');

// ============================================================
// OWNER ROUTES
// ============================================================
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Data Sapi & Kesehatan
        Route::get('sapi', function () {
            return redirect()->route('owner.kesehatan.index');
        })->name('sapi.index');
        Route::get('/observasi', [KesehatanController::class, 'observasi'])
            ->name('kesehatan.observasi');
        Route::resource('kesehatan', KesehatanController::class);

        // Penjualan Susu
        Route::resource('penjualan', PenjualanController::class);

        // Mitra
        Route::resource('mitra', \App\Http\Controllers\owner\MitraController::class);

        // Produksi Susu
        Route::resource('produksi', ProduksiController::class);

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'export'])
            ->name('laporan.export');

        // Kelola Karyawan
        Route::resource('karyawan', \App\Http\Controllers\owner\KaryawanController::class);
    });

// ============================================================
// KARYAWAN ROUTES
// ============================================================
Route::middleware(['auth', 'role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])
            ->name('dashboard');

        // Kesehatan Sapi & Observasi
        Route::resource('kesehatan', KaryawanKesehatanController::class);

        // Sapi CRUD
        Route::resource('sapi', \App\Http\Controllers\karyawan\SapiController::class)->only(['store', 'update', 'destroy']);

        // Produksi Susu (Pemerahan)
        Route::resource('produksi', KaryawanProduksiController::class);
    });

// Profile Laravel Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes
require __DIR__.'/auth.php';