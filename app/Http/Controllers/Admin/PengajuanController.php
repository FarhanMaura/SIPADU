<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    public function index(): View
    {
        $pengajuans = Pengajuan::latest()->paginate(15);

        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function show(Pengajuan $pengajuan): View
    {
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function approve(Pengajuan $pengajuan): RedirectResponse
    {
        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuan->update([
            'status' => 'approved',
        ]);

        return redirect()->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan disetujui (Hasil koordinasi dengan Kasubbag Umum dan Kepegawaian). Surat balasan diterbitkan.');
    }

    public function reject(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $request->validate([
            'keterangan_reject'    => 'required|string|max:500',
            'rekomendasi_instansi' => 'nullable|string|max:255',
        ], [
            'keterangan_reject.required' => 'Alasan penolakan/pengalihan wajib diisi.',
            'keterangan_reject.max'      => 'Alasan penolakan maksimal 500 karakter.',
            'rekomendasi_instansi.max'   => 'Rekomendasi instansi maksimal 255 karakter.',
        ]);

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuan->update([
            'status'               => 'rejected',
            'keterangan_reject'    => strip_tags($request->keterangan_reject),
            'rekomendasi_instansi' => $request->filled('rekomendasi_instansi') ? strip_tags($request->rekomendasi_instansi) : null,
        ]);

        return redirect()->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan diproses ditolak / dialihkan ke instansi lain sesuai kesesuaian jurusan.');
    }

    public function downloadFile(Pengajuan $pengajuan, string $type)
    {
        $filePath = match ($type) {
            'surat'   => $pengajuan->file_surat,
            'peserta' => $pengajuan->file_peserta,
            default   => null,
        };

        if (! $filePath) {
            abort(404, 'File tidak ditemukan.');
        }

        // Cek di storage disk 'local' (private) terlebih dahulu, lalu fallback ke 'public'
        if (\Illuminate\Support\Facades\Storage::disk('local')->exists($filePath)) {
            return \Illuminate\Support\Facades\Storage::disk('local')->response($filePath);
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->response($filePath);
        }

        abort(404, 'File tidak ditemukan pada server.');
    }
}
