<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BidangRequest;
use App\Models\Bidang;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BidangController extends Controller
{
    public function index(): View
    {
        $bidangs = Bidang::withCount('pesertas')->paginate(15);

        return view('admin.bidang.index', compact('bidangs'));
    }

    public function create(): View
    {
        return view('admin.bidang.create');
    }

    public function store(BidangRequest $request): RedirectResponse
    {
        Bidang::create($request->validated());

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function edit(Bidang $bidang): View
    {
        return view('admin.bidang.edit', compact('bidang'));
    }

    public function update(BidangRequest $request, Bidang $bidang): RedirectResponse
    {
        $bidang->update($request->validated());

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil diperbarui.');
    }

    public function destroy(Bidang $bidang): RedirectResponse
    {
        if ($bidang->pesertas()->count() > 0 || $bidang->pembimbings()->count() > 0) {
            return redirect()->route('admin.bidang.index')
                ->with('error', 'Bidang tidak dapat dihapus karena masih memiliki relasi data.');
        }

        $bidang->delete();

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil dihapus.');
    }
}
