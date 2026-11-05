<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\MutasiStokController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem GudangSmart
|--------------------------------------------------------------------------
*/

// Rute Pengalihan Awal (Root Redirect)
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// ==========================================
// RUTE AUTENTIKASI (GUEST ONLY)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

// Logout Rute (Dilindungi Auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// =========================================================================
// ROUTE GROUP DENGAN PREFIX 'admin' & NAMED ROUTES (Soal 1.3 & Soal 5.3)
// Dilindungi Middleware: 'auth' dan 'role:manager,staff'
// =========================================================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:manager,staff'])
    ->group(function () {

        // 1. Rute Konvensional untuk DashboardController (/admin/dashboard)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 2. Rute Khusus Soft Deletes Barang (Harus didefinisikan sebelum Resource Route)
        Route::prefix('barang')->name('barang.')->group(function () {
            Route::get('/trash', [BarangController::class, 'trash'])->name('trash');
            Route::post('/{id}/restore', [BarangController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [BarangController::class, 'forceDelete'])->name('force-delete');
        });

        // 3. Resource Route untuk Pengelolaan Data Barang (/admin/barang)
        Route::resource('barang', BarangController::class);

        // 4. Resource Route untuk Pengelolaan Data Supplier (/admin/suppliers)
        Route::resource('suppliers', SupplierController::class);

        // 5. Rute Klasifikasi Kategori Barang (/admin/kategori)
        Route::get('/kategori', [KategoriBarangController::class, 'index'])->name('kategori.index');

        // 6. Rute Transaksi Mutasi Penerimaan & Pengeluaran Stok (/admin/mutasi)
        Route::prefix('mutasi')->name('mutasi.')->group(function () {
            Route::get('/', [MutasiStokController::class, 'index'])->name('index');
            Route::get('/create', [MutasiStokController::class, 'create'])->name('create');
            Route::post('/', [MutasiStokController::class, 'store'])->name('store');
        });
    });
