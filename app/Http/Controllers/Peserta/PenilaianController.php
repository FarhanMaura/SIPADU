<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PenilaianController extends Controller
{
    public function index(): View
    {
        $peserta   = auth()->user()->peserta;
        $penilaian = $peserta?->penilaian;

        return view('peserta.penilaian', compact('penilaian'));
    }

    public function sertifikat(): View
    {
        $peserta   = auth()->user()->peserta?->load(['bidang', 'pembimbing', 'instansi', 'pengajuan']);
        $penilaian = $peserta?->penilaian;

        return view('peserta.sertifikat', compact('peserta', 'penilaian'));
    }

    public function downloadSertifikat()
    {
        $peserta   = auth()->user()->peserta?->load(['bidang', 'pembimbing', 'instansi', 'pengajuan']);
        $penilaian = $peserta?->penilaian;

        if (!$penilaian) {
            return redirect()->back()->with('error', 'Sertifikat belum tersedia.');
        }

        $pdf = Pdf::loadView('peserta.sertifikat_pdf', compact('peserta', 'penilaian'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat_Magang_'.$peserta->nama.'.pdf');
    }
}
