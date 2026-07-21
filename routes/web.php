<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\InstansiController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Pembimbing\AbsensiController;
use App\Http\Controllers\Pembimbing\PenilaianController;
use Illuminate\Support\Facades\Route;

// ===================================================
// GUEST - Landing Page
// ===================================================
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/pengajuan', [LandingController::class, 'form'])->name('pengajuan.form');
Route::post('/pengajuan', [LandingController::class, 'store'])->middleware('throttle:10,1')->name('pengajuan.submit');
Route::get('/cek-status', [LandingController::class, 'cekStatusForm'])->name('status.form');
Route::post('/cek-status', [LandingController::class, 'cekStatus'])->middleware('throttle:15,1')->name('status.cek');

// ===================================================
// AUTHENTICATED - Dashboard (redirect by role)
// ===================================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// ===================================================
// ADMIN ROUTES
// ===================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Master Data
    Route::resource('bidang', BidangController::class);
    Route::resource('pembimbing', PembimbingController::class);
    Route::resource('instansi', InstansiController::class);

    // Pengajuan
    Route::resource('pengajuan', PengajuanController::class)->only(['index', 'show']);
    Route::patch('pengajuan/{pengajuan}/approve', [PengajuanController::class, 'approve'])->name('pengajuan.approve');
    Route::patch('pengajuan/{pengajuan}/reject', [PengajuanController::class, 'reject'])->name('pengajuan.reject');
    Route::get('pengajuan/{pengajuan}/file/{type}', [PengajuanController::class, 'downloadFile'])->name('pengajuan.file');

    // Peserta
    Route::resource('peserta', PesertaController::class)->parameters(['peserta' => 'peserta']);
    Route::post('peserta/import', [PesertaController::class, 'import'])->name('peserta.import');
    Route::get('peserta/{peserta}/penempatan', [PesertaController::class, 'penempatan'])->name('peserta.penempatan');
    Route::patch('peserta/{peserta}/penempatan', [PesertaController::class, 'savePenempatan'])->name('peserta.penempatan.save');

    // User Management
    Route::resource('user', UserController::class)->except(['show']);
});

// ===================================================
// PEMBIMBING ROUTES
// ===================================================
Route::middleware(['auth', 'role:pembimbing'])->prefix('pembimbing')->name('pembimbing.')->group(function () {
    Route::get('peserta', [AbsensiController::class, 'pesertaList'])->name('peserta.index');
    Route::resource('absensi', AbsensiController::class);
    Route::resource('penilaian', PenilaianController::class);
});

// ===================================================
// PESERTA ROUTES
// ===================================================
Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('status', [\App\Http\Controllers\Peserta\StatusController::class, 'index'])->name('status');
    Route::get('absensi', [\App\Http\Controllers\Peserta\AbsensiController::class, 'index'])->name('absensi');
    Route::post('absensi/self', [\App\Http\Controllers\Peserta\AbsensiController::class, 'selfAbsen'])->name('absensi.self');
    Route::get('penilaian', [\App\Http\Controllers\Peserta\PenilaianController::class, 'index'])->name('penilaian');
    Route::get('sertifikat', [\App\Http\Controllers\Peserta\PenilaianController::class, 'sertifikat'])->name('sertifikat');
    Route::get('sertifikat/download', [\App\Http\Controllers\Peserta\PenilaianController::class, 'downloadSertifikat'])->name('sertifikat.download');
});

// ===================================================
// PROFILE (semua role)
// ===================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
