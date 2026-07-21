<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\Peserta;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === User::ROLE_ADMIN) {
            $stats = [
                'pengajuan_pending'  => Pengajuan::where('status', 'pending')->count(),
                'pengajuan_approved' => Pengajuan::where('status', 'approved')->count(),
                'total_peserta'      => Peserta::count(),
                'total_pembimbing'   => \App\Models\Pembimbing::count(),
                'total_bidang'       => Bidang::count(),
                'total_user'         => User::count(),
            ];
            $pengajuan_terbaru = Pengajuan::latest()->take(5)->get();
            $peserta_terbaru   = Peserta::with(['instansi', 'bidang'])->latest()->take(5)->get();

            return view('admin.dashboard', compact('stats', 'pengajuan_terbaru', 'peserta_terbaru'));

        } elseif ($user->role === User::ROLE_PEMBIMBING) {
            $pembimbing  = $user->pembimbing;
            $pesertas    = $pembimbing ? $pembimbing->pesertas()->with(['instansi', 'absensis'])->get() : collect();

            $absensiHariIni = Absensi::whereHas('peserta', fn($q) => $q->where('pembimbing_id', $pembimbing?->id))
                ->whereDate('tanggal', today())
                ->count();

            $stats = [
                'total_peserta'    => $pesertas->count(),
                'hadir_hari_ini'   => Absensi::whereHas('peserta', fn($q) => $q->where('pembimbing_id', $pembimbing?->id))
                    ->whereDate('tanggal', today())->where('status', 'hadir')->count(),
                'sudah_dinilai'    => \App\Models\Penilaian::where('pembimbing_id', $pembimbing?->id)->count(),
                'belum_dinilai'    => $pesertas->count() - \App\Models\Penilaian::where('pembimbing_id', $pembimbing?->id)->count(),
            ];

            $absensi_terbaru = Absensi::whereHas('peserta', fn($q) => $q->where('pembimbing_id', $pembimbing?->id))
                ->with('peserta')->latest('tanggal')->take(7)->get();

            return view('pembimbing.dashboard', compact('stats', 'pesertas', 'absensi_terbaru', 'pembimbing'));

        } else {
            $peserta   = $user->peserta?->load(['pengajuan', 'bidang', 'pembimbing', 'instansi', 'penilaian']);

            $totalHadir  = $peserta ? $peserta->absensis()->where('status', 'hadir')->count() : 0;
            $totalIzin   = $peserta ? $peserta->absensis()->where('status', 'izin')->count() : 0;
            $totalSakit  = $peserta ? $peserta->absensis()->where('status', 'sakit')->count() : 0;
            $nilai       = $peserta ? $peserta->penilaian : null;

            $recentAbsensi = $peserta ? $peserta->absensis()->latest('tanggal')->take(5)->get() : collect();

            // Cek apakah sudah absen hari ini
            $sudahAbsenHariIni = $peserta
                ? Absensi::where('peserta_id', $peserta->id)->whereDate('tanggal', today())->first()
                : null;

            return view('peserta.dashboard', compact(
                'peserta', 'totalHadir', 'totalIzin', 'totalSakit', 'nilai',
                'recentAbsensi', 'sudahAbsenHariIni'
            ));
        }
    }
}
