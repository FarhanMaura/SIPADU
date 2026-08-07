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
        $data       = $request->validated();

        $indicators = array_filter([
            $request->kedisiplinan, $request->kerapian, $request->kebersihan,
            $request->tanggung_jawab, $request->kerjasama, $request->kreativitas, $request->kejujuran
        ], fn($v) => !is_null($v));

        if (count($indicators) > 0) {
            $data['nilai_angka'] = round(array_sum($indicators) / count($indicators), 2);
        }

        $data['pembimbing_id'] = $pembimbing?->id;
        $data['status_administrasi'] = 'dinilai_pembimbing';

        Penilaian::updateOrCreate(
            ['peserta_id' => $request->peserta_id],
            $data
        );

        return redirect()->route('pembimbing.penilaian.index')
            ->with('success', 'Penilaian kinerja peserta berhasil disimpan.');
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
        $data = $request->validated();

        $indicators = array_filter([
            $request->kedisiplinan, $request->kerapian, $request->kebersihan,
            $request->tanggung_jawab, $request->kerjasama, $request->kreativitas, $request->kejujuran
        ], fn($v) => !is_null($v));

        if (count($indicators) > 0) {
            $data['nilai_angka'] = round(array_sum($indicators) / count($indicators), 2);
        }

        $penilaian->update($data);

        return redirect()->route('pembimbing.penilaian.index')
            ->with('success', 'Penilaian kinerja peserta berhasil diperbarui.');
    }

    public function destroy(Penilaian $penilaian): RedirectResponse
    {
        $this->authorizePenilaian($penilaian);
        $penilaian->delete();

        return redirect()->route('pembimbing.penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}
