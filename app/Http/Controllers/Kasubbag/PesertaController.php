<?php

namespace App\Http\Controllers\Kasubbag;

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
        $bidangs    = Bidang::all();

        return view('kasubbag.peserta.index', compact('pesertas', 'pengajuans', 'bidangs'));
    }

    public function show(Peserta $peserta): View
    {
        $peserta->load(['instansi', 'bidang', 'pembimbing', 'pengajuan', 'absensis', 'penilaian']);

        return view('kasubbag.peserta.show', compact('peserta'));
    }

    public function create(): View
    {
        $pengajuans = Pengajuan::where('status', 'approved')->get();
        $bidangs    = Bidang::all();

        return view('kasubbag.peserta.create', compact('pengajuans', 'bidangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pengajuan_id'  => 'required|exists:pengajuans,id',
            'bidang_id'     => 'nullable|exists:bidangs,id',
            'nim_nisn'      => 'nullable|string|max:50',
            'nama'          => 'required|string|max:255',
            'jurusan'       => 'nullable|string|max:255',
            'jenis_peserta' => 'nullable|string|max:100',
            'tgl_mulai'     => 'nullable|date',
            'tgl_selesai'   => 'nullable|date|after_or_equal:tgl_mulai',
            'status'        => 'nullable|in:aktif,selesai',
            'email'         => 'nullable|email|unique:users,email',
            'password'      => 'nullable|string|min:8',
        ]);

        DB::transaction(function () use ($request) {
            $pengajuan = Pengajuan::find($request->pengajuan_id);

            $userId = null;
            if ($request->filled('email') && $request->filled('password')) {
                $user = User::create([
                    'name'     => $request->nama,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => User::ROLE_PESERTA,
                ]);
                $userId = $user->id;
            }

            Peserta::create([
                'user_id'       => $userId,
                'pengajuan_id'  => $request->pengajuan_id,
                'instansi_id'   => $pengajuan->instansi_id,
                'bidang_id'     => $request->bidang_id,
                'pembimbing_id' => null, // Pembimbing ditentukan oleh Administrator
                'nim_nisn'      => $request->nim_nisn,
                'nama'          => $request->nama,
                'jurusan'       => $request->jurusan,
                'jenis_peserta' => $request->jenis_peserta,
                'tgl_mulai'     => $request->tgl_mulai,
                'tgl_selesai'   => $request->tgl_selesai,
                'status'        => $request->status ?? 'aktif',
            ]);
        });

        return redirect()->route('kasubbag.peserta.index')
            ->with('success', 'Peserta magang berhasil ditambahkan dan ditempatkan ke bidang.');
    }

    public function edit(Peserta $peserta): View
    {
        $pengajuans = Pengajuan::where('status', 'approved')->get();
        $bidangs    = Bidang::all();

        return view('kasubbag.peserta.edit', compact('peserta', 'pengajuans', 'bidangs'));
    }

    public function update(Request $request, Peserta $peserta): RedirectResponse
    {
        $request->validate([
            'pengajuan_id'  => 'required|exists:pengajuans,id',
            'bidang_id'     => 'nullable|exists:bidangs,id',
            'nim_nisn'      => 'nullable|string|max:50',
            'nama'          => 'required|string|max:255',
            'jurusan'       => 'nullable|string|max:255',
            'jenis_peserta' => 'nullable|string|max:100',
            'tgl_mulai'     => 'nullable|date',
            'tgl_selesai'   => 'nullable|date|after_or_equal:tgl_mulai',
            'status'        => 'nullable|in:aktif,selesai',
        ]);

        $pengajuan = Pengajuan::find($request->pengajuan_id);

        $peserta->update([
            'pengajuan_id'  => $pengajuan->id,
            'instansi_id'   => $pengajuan->instansi_id,
            'bidang_id'     => $request->bidang_id,
            'nim_nisn'      => $request->nim_nisn,
            'nama'          => $request->nama,
            'jurusan'       => $request->jurusan,
            'jenis_peserta' => $request->jenis_peserta,
            'tgl_mulai'     => $request->tgl_mulai,
            'tgl_selesai'   => $request->tgl_selesai,
            'status'        => $request->status ?? $peserta->status,
        ]);

        return redirect()->route('kasubbag.peserta.index')
            ->with('success', 'Data & bidang penempatan peserta berhasil diperbarui.');
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

        return redirect()->route('kasubbag.peserta.index')
            ->with('success', 'Peserta berhasil dihapus.');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file_peserta' => 'required|file|mimes:xlsx,xls|max:5120',
            'pengajuan_id' => 'required|exists:pengajuans,id',
        ]);

        return redirect()->route('kasubbag.peserta.index')
            ->with('info', 'File berhasil diunggah. Data peserta siap dikonfirmasi.');
    }
}
