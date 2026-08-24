<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pembimbing\AbsensiRequest;
use App\Models\Absensi;
use App\Models\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    private function getPesertaBimbingan()
    {
        $pembimbing = auth()->user()->pembimbing;

        if (! $pembimbing) {
            return collect();
        }

        return Peserta::where(function ($q) use ($pembimbing) {
            $q->where('pembimbing_id', $pembimbing->id);
            if ($pembimbing->bidang_id) {
                $q->orWhere('bidang_id', $pembimbing->bidang_id);
            }
        })
        ->with(['instansi', 'bidang', 'pengajuan'])
        ->get();
    }

    public function pesertaList(): View
    {
        $pesertas = $this->getPesertaBimbingan();

        return view('pembimbing.peserta.index', compact('pesertas'));
    }

    public function index(): View
    {
        $pembimbing = auth()->user()->pembimbing;
        $absensis   = Absensi::whereHas('peserta', function ($q) use ($pembimbing) {
            $q->where('pembimbing_id', $pembimbing?->id);
        })->with('peserta')->latest('tanggal')->paginate(20);

        $pesertas = $this->getPesertaBimbingan();

        return view('pembimbing.absensi.index', compact('absensis', 'pesertas'));
    }

    public function create(): View
    {
        $pesertas = $this->getPesertaBimbingan();

        return view('pembimbing.absensi.create', compact('pesertas'));
    }

    public function store(AbsensiRequest $request): RedirectResponse
    {
        Absensi::create($request->validated());

        return redirect()->route('pembimbing.absensi.index')
            ->with('success', 'Data absensi berhasil disimpan.');
    }

    private function authorizeAbsensi(Absensi $absensi): void
    {
        $pembimbing = auth()->user()->pembimbing;

        if (! $pembimbing || $absensi->peserta?->pembimbing_id !== $pembimbing->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk data absensi ini.');
        }
    }

    public function edit(Absensi $absensi): View
    {
        $this->authorizeAbsensi($absensi);
        $pesertas = $this->getPesertaBimbingan();

        return view('pembimbing.absensi.edit', compact('absensi', 'pesertas'));
    }

    public function update(AbsensiRequest $request, Absensi $absensi): RedirectResponse
    {
        $this->authorizeAbsensi($absensi);
        $absensi->update($request->validated());

        return redirect()->route('pembimbing.absensi.index')
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi): RedirectResponse
    {
        $this->authorizeAbsensi($absensi);
        $absensi->delete();

        return redirect()->route('pembimbing.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }

    public function downloadLoa(Peserta $peserta)
    {
        $pembimbing = auth()->user()->pembimbing;
        if (! $pembimbing || ($peserta->pembimbing_id !== $pembimbing->id && $peserta->bidang_id !== $pembimbing->bidang_id)) {
            abort(403, 'Anda tidak memiliki hak akses untuk data peserta ini.');
        }

        $pengajuan = $peserta->pengajuan;
        if (! $pengajuan || $pengajuan->status !== 'approved') {
            return redirect()->back()->with('error', 'Surat balasan (LoA) belum tersedia untuk peserta ini.');
        }

        $pengajuan->load('pesertas');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.loa_pdf', compact('pengajuan'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('LoA_Surat_Balasan_' . str_replace(' ', '_', $peserta->nama) . '.pdf');
    }
}
