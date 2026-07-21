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

        return view('peserta.absensi', compact('absensis'));
    }

    public function selfAbsen(Request $request): RedirectResponse
    {
        $peserta = auth()->user()->peserta;

        if (!$peserta) {
            return redirect()->route('dashboard')
                ->with('error', 'Data peserta tidak ditemukan. Hubungi admin.');
        }

        // Cek sudah absen hari ini
        $sudahAbsen = Absensi::where('peserta_id', $peserta->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return redirect()->route('dashboard')
                ->with('info', 'Anda sudah melakukan absensi hari ini.');
        }

        $request->validate([
            'status'     => 'required|in:hadir,izin,sakit',
            'keterangan' => 'nullable|string|max:500',
        ]);

        Absensi::create([
            'peserta_id' => $peserta->id,
            'tanggal'    => today(),
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        $label = match($request->status) {
            'hadir' => 'Hadir',
            'izin'  => 'Izin',
            'sakit' => 'Sakit',
            default => $request->status,
        };

        return redirect()->route('dashboard')
            ->with('success', "Absensi hari ini berhasil dicatat: {$label}.");
    }
}
