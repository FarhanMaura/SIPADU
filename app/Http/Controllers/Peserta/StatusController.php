<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class StatusController extends Controller
{
    public function index(): View
    {
        $peserta = auth()->user()->peserta?->load(['pengajuan', 'bidang', 'pembimbing', 'instansi']);

        return view('peserta.status', compact('peserta'));
    }

    public function downloadLoa()
    {
        $peserta = auth()->user()->peserta?->load(['pengajuan.pesertas', 'instansi']);
        $pengajuan = $peserta?->pengajuan;

        if (!$pengajuan || $pengajuan->status !== 'approved') {
            return redirect()->back()->with('error', 'Surat balasan (LoA) belum tersedia atau permohonan magang belum disetujui.');
        }

        $pengajuan->load('pesertas');

        $pdf = Pdf::loadView('pdf.loa_pdf', compact('pengajuan'))
            ->setPaper('a4', 'portrait');

        $filename = 'LoA_Surat_Balasan_' . str_replace(' ', '_', $peserta->nama) . '.pdf';

        return $pdf->download($filename);
    }
}
