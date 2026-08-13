<?php

namespace App\Http\Controllers\Kasubbag;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengajuan::query();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $searchSanitized = str_replace(['%', '_'], ['\%', '\_'], $search);
            $query->where(function ($q) use ($searchSanitized) {
                $q->where('nama_instansi', 'like', "%{$searchSanitized}%")
                  ->orWhere('pic_nama', 'like', "%{$searchSanitized}%")
                  ->orWhere('pic_email', 'like', "%{$searchSanitized}%");
            });
        }

        $pengajuans = $query->latest()->paginate(10)->appends($request->query());

        return view('kasubbag.pengajuan.index', compact('pengajuans'));
    }

    public function show(Pengajuan $pengajuan): View
    {
        $pengajuan->load(['instansi', 'pesertas']);

        return view('kasubbag.pengajuan.show', compact('pengajuan'));
    }

    public function approve(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $request->validate([
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $pengajuan->update([
            'status'     => 'approved',
            'keterangan' => $request->keterangan ?? 'Pengajuan magang telah disetujui oleh Kasubbag.',
        ]);

        $pengajuan->syncPesertaOnApproval();

        return redirect()->route('kasubbag.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan magang berhasil disetujui dan data peserta otomatis terdaftar untuk penempatan lokasi.');
    }

    public function reject(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $request->validate([
            'keterangan_reject' => 'required|string|max:1000',
        ], [
            'keterangan_reject.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $pengajuan->update([
            'status'            => 'rejected',
            'keterangan_reject' => $request->keterangan_reject,
        ]);

        return redirect()->route('kasubbag.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan magang berhasil ditolak.');
    }

    public function downloadFile(Pengajuan $pengajuan, string $type)
    {
        $filePath = match ($type) {
            'surat'            => $pengajuan->file_surat,
            'peserta'          => $pengajuan->file_peserta,
            'transkrip'        => $pengajuan->file_transkrip,
            'surat_pernyataan' => $pengajuan->file_surat_pernyataan,
            default            => null,
        };

        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('local')->download($filePath);
    }

    public function downloadLoa(Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'approved') {
            return redirect()->back()->with('error', 'Surat balasan (LoA) hanya tersedia untuk pengajuan yang sudah disetujui.');
        }

        $pengajuan->load('pesertas');

        $pdf = Pdf::loadView('pdf.loa_pdf', compact('pengajuan'))
            ->setPaper('a4', 'portrait');

        $filename = 'LoA_Surat_Balasan_' . str_replace(' ', '_', $pengajuan->nama_instansi) . '.pdf';

        return $pdf->download($filename);
    }
}
