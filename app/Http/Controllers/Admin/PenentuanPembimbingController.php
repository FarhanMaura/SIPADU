<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenentuanPembimbingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Peserta::with(['instansi', 'bidang', 'pembimbing']);

        if ($search = $request->input('search')) {
            $searchSanitized = str_replace(['%', '_'], ['\%', '\_'], $search);
            $query->where(function ($q) use ($searchSanitized) {
                $q->where('nama', 'like', "%{$searchSanitized}%")
                  ->orWhere('nim_nisn', 'like', "%{$searchSanitized}%")
                  ->orWhereHas('instansi', fn ($iq) => $iq->where('nama', 'like', "%{$searchSanitized}%"));
            });
        }

        $pesertas    = $query->paginate(15)->appends($request->query());
        $bidangs     = Bidang::all();
        $pembimbings = Pembimbing::with('bidang')->get();

        return view('admin.penentuan_pembimbing.index', compact('pesertas', 'bidangs', 'pembimbings'));
    }

    public function update(Request $request, Peserta $peserta): RedirectResponse
    {
        $request->validate([
            'bidang_id'     => 'required|exists:bidangs,id',
            'pembimbing_id' => 'required|exists:pembimbings,id',
        ], [
            'bidang_id.required'     => 'Pilih bidang penempatan.',
            'pembimbing_id.required' => 'Pilih pembimbing magang.',
        ]);

        $peserta->update([
            'bidang_id'     => $request->bidang_id,
            'pembimbing_id' => $request->pembimbing_id,
        ]);

        return redirect()->back()
            ->with('success', 'Pembimbing dan Bidang berhasil ditentukan untuk ' . e($peserta->nama) . '.');
    }
}
