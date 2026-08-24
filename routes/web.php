<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\InstansiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PenentuanPembimbingController;
use App\Http\Controllers\Admin\RekapNilaiController;
use App\Http\Controllers\Kasubbag\PengajuanController as KasubbagPengajuanController;
use App\Http\Controllers\Kasubbag\PesertaController as KasubbagPesertaController;
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
Route::get('/pengajuan/{pengajuan}/surat-balasan', [LandingController::class, 'downloadSuratBalasan'])->name('pengajuan.surat_balasan');

// ===================================================
// AUTHENTICATED - Dashboard (redirect by role)
// ===================================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// ===================================================
// KASUBBAG ROUTES (Role 4)
// ===================================================
Route::middleware(['auth', 'role:kasubbag'])->prefix('kasubbag')->name('kasubbag.')->group(function () {
    // Pengajuan
    Route::resource('pengajuan', KasubbagPengajuanController::class)->only(['index', 'show']);
    Route::patch('pengajuan/{pengajuan}/approve', [KasubbagPengajuanController::class, 'approve'])->name('pengajuan.approve');
    Route::patch('pengajuan/{pengajuan}/reject', [KasubbagPengajuanController::class, 'reject'])->name('pengajuan.reject');
    Route::get('pengajuan/{pengajuan}/file/{type}', [KasubbagPengajuanController::class, 'downloadFile'])->name('pengajuan.file');
    Route::get('pengajuan/{pengajuan}/loa', [KasubbagPengajuanController::class, 'downloadLoa'])->name('pengajuan.loa');

    // Peserta (Kelola & Tambah Peserta)
    Route::resource('peserta', KasubbagPesertaController::class)->parameters(['peserta' => 'peserta']);
    Route::post('peserta/import', [KasubbagPesertaController::class, 'import'])->name('peserta.import');
});

// ===================================================
// ADMIN ROUTES (Role 1)
// ===================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Master Data
    Route::resource('bidang', BidangController::class);
    Route::resource('pembimbing', PembimbingController::class);
    Route::resource('instansi', InstansiController::class);
    Route::resource('user', UserController::class)->except(['show']);

    // Penentuan Pembimbing
    Route::get('penentuan-pembimbing', [PenentuanPembimbingController::class, 'index'])->name('penentuan_pembimbing.index');
    Route::patch('penentuan-pembimbing/{peserta}', [PenentuanPembimbingController::class, 'update'])->name('penentuan_pembimbing.update');

    // Rekap Nilai & Cetak Sertifikat
    Route::get('rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap_nilai.index');
    Route::get('rekap-nilai/{peserta}/pdf', [RekapNilaiController::class, 'downloadNilaiPdf'])->name('rekap_nilai.pdf');
    Route::get('rekap-nilai/{peserta}/sertifikat', [RekapNilaiController::class, 'downloadSertifikatPdf'])->name('rekap_nilai.sertifikat');
    Route::get('rekap-nilai/{peserta}/loa', [RekapNilaiController::class, 'downloadLoaPdf'])->name('rekap_nilai.loa');
});

// ===================================================
// PEMBIMBING ROUTES (Role 2)
// ===================================================
Route::middleware(['auth', 'role:pembimbing'])->prefix('pembimbing')->name('pembimbing.')->group(function () {
    Route::get('peserta', [AbsensiController::class, 'pesertaList'])->name('peserta.index');
    Route::get('peserta/{peserta}/loa', [AbsensiController::class, 'downloadLoa'])->name('peserta.loa');
    Route::resource('absensi', AbsensiController::class);
    Route::resource('penilaian', PenilaianController::class);
});

// ===================================================
// PESERTA ROUTES (Role 3)
// ===================================================
Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('status', [\App\Http\Controllers\Peserta\StatusController::class, 'index'])->name('status');
    Route::get('loa/download', [\App\Http\Controllers\Peserta\StatusController::class, 'downloadLoa'])->name('loa.download');
    Route::get('absensi', [\App\Http\Controllers\Peserta\AbsensiController::class, 'index'])->name('absensi');
    Route::post('absensi/self', [\App\Http\Controllers\Peserta\AbsensiController::class, 'selfAbsen'])->name('absensi.self');
    Route::put('absensi/logbook', [\App\Http\Controllers\Peserta\AbsensiController::class, 'updateTodayLogbook'])->name('absensi.logbook');
    Route::get('penilaian', [\App\Http\Controllers\Peserta\PenilaianController::class, 'index'])->name('penilaian');
    Route::get('sertifikat', [\App\Http\Controllers\Peserta\PenilaianController::class, 'sertifikat'])->name('sertifikat');
    Route::get('sertifikat/download', [\App\Http\Controllers\Peserta\PenilaianController::class, 'downloadSertifikat'])->name('sertifikat.download');
});

require __DIR__.'/auth.php';
