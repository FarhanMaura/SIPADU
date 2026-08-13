<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapNilaiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Peserta::with(['instansi', 'bidang', 'pembimbing', 'penilaian']);

        if ($search = $request->input('search')) {
            $searchSanitized = str_replace(['%', '_'], ['\%', '\_'], $search);
            $query->where(function ($q) use ($searchSanitized) {
                $q->where('nama', 'like', "%{$searchSanitized}%")
                  ->orWhere('nim_nisn', 'like', "%{$searchSanitized}%")
                  ->orWhereHas('instansi', fn ($iq) => $iq->where('nama', 'like', "%{$searchSanitized}%"));
            });
        }

        $pesertas = $query->paginate(15)->appends($request->query());

        return view('admin.rekap_nilai.index', compact('pesertas'));
    }

    public function downloadNilaiPdf(Peserta $peserta)
    {
        $peserta->load(['bidang', 'pembimbing', 'instansi', 'penilaian']);
        $penilaian = $peserta->penilaian;

        if (!$penilaian) {
            return redirect()->back()->with('error', 'Penilaian untuk peserta ini belum diisi oleh pembimbing.');
        }

        $pdf = Pdf::loadView('pdf.daftar_nilai_pdf', compact('peserta', 'penilaian'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Daftar_Nilai_PKL_' . str_replace(' ', '_', $peserta->nama) . '.pdf');
    }

    public function downloadSertifikatPdf(Peserta $peserta)
    {
        $peserta->load(['bidang', 'pembimbing', 'instansi', 'penilaian']);
        $penilaian = $peserta->penilaian;

        if (!$penilaian) {
            return redirect()->back()->with('error', 'Sertifikat belum dapat dicetak karena penilaian belum diisi.');
        }

        $pdf = Pdf::loadView('peserta.sertifikat_pdf', compact('peserta', 'penilaian'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Sertifikat_Dan_Nilai_Magang_' . str_replace(' ', '_', $peserta->nama) . '.pdf');
    }
}
