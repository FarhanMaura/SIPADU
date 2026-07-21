<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pembimbing\PenilaianRequest;
use App\Models\Penilaian;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PenilaianController extends Controller
{
    private function getPesertaBimbingan()
    {
        $pembimbing = auth()->user()->pembimbing;

        return $pembimbing ? $pembimbing->pesertas()->with('penilaian')->get() : collect();
    }

    public function index(): View
    {
        $pesertas = $this->getPesertaBimbingan();

        return view('pembimbing.penilaian.index', compact('pesertas'));
    }

    public function create(): View
    {
        $pesertas = $this->getPesertaBimbingan();

        return view('pembimbing.penilaian.create', compact('pesertas'));
    }

    public function store(PenilaianRequest $request): RedirectResponse
    {
        $pembimbing = auth()->user()->pembimbing;

        Penilaian::updateOrCreate(
            ['peserta_id' => $request->peserta_id],
            [
                'pembimbing_id' => $pembimbing?->id,
                'nilai_angka'   => $request->nilai_angka,
                'keterangan'    => $request->keterangan,
            ]
        );

        return redirect()->route('pembimbing.penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    private function authorizePenilaian(Penilaian $penilaian): void
    {
        $pembimbing = auth()->user()->pembimbing;

        if (! $pembimbing || $penilaian->pembimbing_id !== $pembimbing->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk penilaian ini.');
        }
    }

    public function edit(Penilaian $penilaian): View
    {
        $this->authorizePenilaian($penilaian);
        $pesertas = $this->getPesertaBimbingan();

        return view('pembimbing.penilaian.edit', compact('penilaian', 'pesertas'));
    }

    public function update(PenilaianRequest $request, Penilaian $penilaian): RedirectResponse
    {
        $this->authorizePenilaian($penilaian);
        $penilaian->update($request->validated());

        return redirect()->route('pembimbing.penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy(Penilaian $penilaian): RedirectResponse
    {
        $this->authorizePenilaian($penilaian);
        $penilaian->delete();

        return redirect()->route('pembimbing.penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}
