<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\Peserta;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PesertaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Peserta::with(['instansi', 'bidang', 'pembimbing']);

        if ($search = $request->input('search')) {
            $searchSanitized = str_replace(['%', '_'], ['\%', '\_'], $search);
            $query->where(function ($q) use ($searchSanitized) {
                $q->where('nama', 'like', "%{$searchSanitized}%")
                  ->orWhere('nim_nisn', 'like', "%{$searchSanitized}%")
                  ->orWhere('jurusan', 'like', "%{$searchSanitized}%")
                  ->orWhereHas('instansi', fn ($iq) => $iq->where('nama', 'like', "%{$searchSanitized}%"));
            });
        }

        $pesertas   = $query->paginate(15)->appends($request->query());
        $pengajuans = Pengajuan::where('status', 'approved')->get();

        return view('admin.peserta.index', compact('pesertas', 'pengajuans'));
    }

    public function show(Peserta $peserta): View
    {
        $peserta->load(['instansi', 'bidang', 'pembimbing', 'pengajuan', 'absensis', 'penilaian']);

        return view('admin.peserta.show', compact('peserta'));
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file_peserta' => 'required|file|mimes:xlsx,xls|max:5120',
            'pengajuan_id' => 'required|exists:pengajuans,id',
        ]);

        // Baca file Excel manual (baris sederhana tanpa package)
        // Saat ini stub - implementasi import Excel akan ditambah setelah package tersedia
        return redirect()->route('admin.peserta.index')
            ->with('info', 'Fitur import Excel akan segera tersedia. Silakan tambah peserta manual.');
    }

    public function penempatan(Peserta $peserta): View
    {
        $bidangs     = Bidang::all();
        $pembimbings = Pembimbing::with('bidang')->get();

        return view('admin.peserta.penempatan', compact('peserta', 'bidangs', 'pembimbings'));
    }

    public function savePenempatan(Request $request, Peserta $peserta): RedirectResponse
    {
        $request->validate([
            'bidang_id'     => 'required|exists:bidangs,id',
            'pembimbing_id' => 'required|exists:pembimbings,id',
        ]);

        $peserta->update([
            'bidang_id'     => $request->bidang_id,
            'pembimbing_id' => $request->pembimbing_id,
        ]);

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Penempatan peserta berhasil disimpan.');
    }

    public function create(): View
    {
        $pengajuans = Pengajuan::where('status', 'approved')->get();
        $bidangs    = Bidang::all();
        $pembimbings = Pembimbing::with('bidang')->get();

        return view('admin.peserta.create', compact('pengajuans', 'bidangs', 'pembimbings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pengajuan_id'  => 'required|exists:pengajuans,id',
            'nim_nisn'      => 'nullable|string|max:50',
            'nama'          => 'required|string|max:255',
            'jurusan'       => 'nullable|string|max:255',
            'jenis_peserta' => 'nullable|in:Mahasiswa,Peserta Didik',
            'tgl_mulai'     => 'nullable|date',
            'tgl_selesai'   => 'nullable|date|after_or_equal:tgl_mulai',
            'status'        => 'nullable|in:aktif,selesai',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($request) {
            $pengajuan = Pengajuan::find($request->pengajuan_id);

            $user = User::create([
                'name'     => $request->nama,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => User::ROLE_PESERTA,
            ]);

            Peserta::create([
                'user_id'       => $user->id,
                'pengajuan_id'  => $request->pengajuan_id,
                'instansi_id'   => $pengajuan->instansi_id,
                'nim_nisn'      => $request->nim_nisn,
                'nama'          => $request->nama,
                'jurusan'       => $request->jurusan,
                'jenis_peserta' => $request->jenis_peserta,
                'tgl_mulai'     => $request->tgl_mulai,
                'tgl_selesai'   => $request->tgl_selesai,
                'status'        => $request->status ?? 'aktif',
            ]);
        });

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function edit(Peserta $peserta): View
    {
        $pengajuans = Pengajuan::where('status', 'approved')->get();
        return view('admin.peserta.edit', compact('peserta', 'pengajuans'));
    }

    public function update(Request $request, Peserta $peserta): RedirectResponse
    {
        $request->validate([
            'pengajuan_id'  => 'required|exists:pengajuans,id',
            'nim_nisn'      => 'nullable|string|max:50',
            'nama'          => 'required|string|max:255',
            'jurusan'       => 'nullable|string|max:255',
            'jenis_peserta' => 'nullable|in:Mahasiswa,Peserta Didik',
            'tgl_mulai'     => 'nullable|date',
            'tgl_selesai'   => 'nullable|date|after_or_equal:tgl_mulai',
            'status'        => 'nullable|in:aktif,selesai',
        ]);

        $pengajuan = Pengajuan::find($request->pengajuan_id);

        $peserta->update([
            'pengajuan_id'  => $pengajuan->id,
            'instansi_id'   => $pengajuan->instansi_id,
            'nim_nisn'      => $request->nim_nisn,
            'nama'          => $request->nama,
            'jurusan'       => $request->jurusan,
            'jenis_peserta' => $request->jenis_peserta,
            'tgl_mulai'     => $request->tgl_mulai,
            'tgl_selesai'   => $request->tgl_selesai,
            'status'        => $request->status ?? $peserta->status,
        ]);

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(Peserta $peserta): RedirectResponse
    {
        DB::transaction(function () use ($peserta) {
            $user = $peserta->user;
            $peserta->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil dihapus.');
    }
}
