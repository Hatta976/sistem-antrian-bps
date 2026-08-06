<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KiosController;

// ==========================================
// 1. AKSES PUBLIK (Tanpa Login)
// ==========================================

// Monitor Antrean (Layar TV)
Route::get('/', [MonitorController::class, 'index'])->name('monitor.index');
Route::get('/monitor/data', [MonitorController::class, 'getData'])->name('monitor.data');

// Kios Tiket (Mesin Pengambil Antrean Pengunjung)
Route::get('/kios', [KiosController::class, 'index'])->name('kios.index');
Route::post('/kios/ambil', [KiosController::class, 'store'])->name('kios.store');
Route::get('/kios/sukses/{id}', [KiosController::class, 'sukses'])->name('kios.sukses');


// ==========================================
// 2. AUTHENTICATION (Login / Logout)
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Switcher Redirect
Route::get('/dashboard', function() {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('petugas.dashboard');
})->middleware('auth')->name('dashboard');


// ==========================================
// 3. GROUP ADMIN (Wajib Login & Role Admin)
// ==========================================
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
});


// ==========================================
// 4. GROUP PETUGAS (Wajib Login & Role Petugas)
// ==========================================
Route::middleware(['auth', 'role:Petugas'])->prefix('petugas')->name('petugas.')->group(function() {
    // Halaman Dashboard Utama Petugas
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('dashboard');
    
    // Fitur-fitur Petugas
    Route::post('/pengunjung', [PetugasController::class, 'storePengunjung'])->name('pengunjung.store');
    Route::post('/panggil', [PetugasController::class, 'panggil'])->name('panggil');
    Route::post('/panggil-next', [PetugasController::class, 'panggilBerikutnya'])->name('panggil.next');
    Route::post('/antrian/{id}/selesai', [PetugasController::class, 'selesaikanAntrian'])->name('antrian.selesai');
    Route::post('/petugas/antrian/selesai/{id}', [PetugasController::class, 'selesai'])->name('petugas.antrian.selesai');
});

    Route::get('/antrian/{id}/cetak', [KiosController::class, 'cetak'])->name('antrian.cetak');