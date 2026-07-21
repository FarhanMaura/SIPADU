<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstansiRequest;
use App\Models\Instansi;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstansiController extends Controller
{
    public function index(): View
    {
        $instansis = Instansi::withCount('pesertas')->paginate(15);

        return view('admin.instansi.index', compact('instansis'));
    }

    public function create(): View
    {
        return view('admin.instansi.create');
    }

    public function store(InstansiRequest $request): RedirectResponse
    {
        Instansi::create($request->validated());

        return redirect()->route('admin.instansi.index')
            ->with('success', 'Instansi berhasil ditambahkan.');
    }

    public function edit(Instansi $instansi): View
    {
        return view('admin.instansi.edit', compact('instansi'));
    }

    public function update(InstansiRequest $request, Instansi $instansi): RedirectResponse
    {
        $instansi->update($request->validated());

        return redirect()->route('admin.instansi.index')
            ->with('success', 'Instansi berhasil diperbarui.');
    }

    public function destroy(Instansi $instansi): RedirectResponse
    {
        if ($instansi->pesertas()->count() > 0 || $instansi->pengajuans()->count() > 0) {
            return redirect()->route('admin.instansi.index')
                ->with('error', 'Instansi tidak dapat dihapus karena masih memiliki relasi data.');
        }

        $instansi->delete();

        return redirect()->route('admin.instansi.index')
            ->with('success', 'Instansi berhasil dihapus.');
    }
}
