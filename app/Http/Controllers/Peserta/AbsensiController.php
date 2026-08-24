<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(): View
    {
        $peserta  = auth()->user()->peserta;
        $absensis = $peserta ? $peserta->absensis()->latest('tanggal')->paginate(30) : collect();

        $sudahAbsenHariIni = $peserta
            ? Absensi::where('peserta_id', $peserta->id)->whereDate('tanggal', today())->first()
            : null;

        return view('peserta.absensi', compact('absensis', 'sudahAbsenHariIni'));
    }

    public function selfAbsen(Request $request): RedirectResponse
    {
        $peserta = auth()->user()->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.absensi')
                ->with('error', 'Data peserta tidak ditemukan. Hubungi admin.');
        }

        // Cek sudah absen hari ini
        $sudahAbsen = Absensi::where('peserta_id', $peserta->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return redirect()->route('peserta.absensi')
                ->with('info', 'Anda sudah melakukan absensi hari ini.');
        }

        $request->validate([
            'status'        => 'required|in:hadir,izin,sakit',
            'keterangan'    => 'nullable|string|max:500',
            'logbook'       => 'nullable|string|max:3000',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $fotoPath = $request->file('foto_kegiatan')->store('absensi_foto', 'public');
        }

        Absensi::create([
            'peserta_id'    => $peserta->id,
            'tanggal'       => today(),
            'status'        => $request->status,
            'keterangan'    => $request->keterangan,
            'logbook'       => $request->logbook,
            'foto_kegiatan' => $fotoPath,
        ]);

        $label = match($request->status) {
            'hadir' => 'Hadir',
            'izin'  => 'Izin',
            'sakit' => 'Sakit',
            default => $request->status,
        };

        return redirect()->route('peserta.absensi')
            ->with('success', "Absensi hari ini berhasil dicatat: {$label}.");
    }

    public function updateTodayLogbook(Request $request): RedirectResponse
    {
        $peserta = auth()->user()->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.absensi')
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        $absensi = Absensi::where('peserta_id', $peserta->id)
            ->whereDate('tanggal', today())
            ->first();

        if (!$absensi) {
            return redirect()->route('peserta.absensi')
                ->with('error', 'Belum ada data presensi hari ini untuk diperbarui.');
        }

        $request->validate([
            'logbook'       => 'nullable|string|max:3000',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        if ($request->hasFile('foto_kegiatan')) {
            $fotoPath = $request->file('foto_kegiatan')->store('absensi_foto', 'public');
            $absensi->foto_kegiatan = $fotoPath;
        }

        if ($request->filled('logbook')) {
            $absensi->logbook = $request->logbook;
        }

        $absensi->save();

        return redirect()->route('peserta.absensi')
            ->with('success', 'Logbook kegiatan harian berhasil diperbarui.');
    }
}
