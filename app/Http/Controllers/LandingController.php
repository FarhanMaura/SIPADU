<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        return view('landing.index');
    }

    public function form(): View
    {
        return view('landing.pengajuan');
    }

    public function cekStatusForm(): View
    {
        return view('landing.cek-status');
    }

    public function cekStatus(Request $request): View
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $pengajuans = \App\Models\Pengajuan::where('pic_email', $email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('landing.cek-status', compact('pengajuans', 'email'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'pic_nama'      => 'required|string|max:255',
            'pic_email'     => 'required|email|max:255',
            'pic_telp'      => 'required|string|max:20',
            'jml_peserta'   => 'required|integer|min:1|max:500',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after:tgl_mulai',
            'file_surat'    => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_peserta'  => 'required|file|mimes:xlsx,xls|max:5120',
            'keterangan'    => 'nullable|string|max:2000',
        ], [
            'nama_instansi.required' => 'Nama instansi wajib diisi.',
            'pic_nama.required'      => 'Nama PIC wajib diisi.',
            'pic_email.required'     => 'Email PIC wajib diisi.',
            'pic_email.email'        => 'Format email PIC tidak valid.',
            'pic_telp.required'      => 'No. HP PIC wajib diisi.',
            'jml_peserta.required'   => 'Jumlah peserta wajib diisi.',
            'jml_peserta.min'        => 'Jumlah peserta minimal 1.',
            'jml_peserta.max'        => 'Jumlah peserta maksimal 500.',
            'tgl_mulai.required'     => 'Tanggal mulai wajib diisi.',
            'tgl_selesai.required'   => 'Tanggal selesai wajib diisi.',
            'tgl_selesai.after'      => 'Tanggal selesai harus setelah tanggal mulai.',
            'file_surat.required'    => 'Surat permohonan wajib diupload.',
            'file_surat.mimes'       => 'Surat harus berformat PDF, JPG, atau PNG.',
            'file_surat.max'         => 'Surat maksimal 5MB.',
            'file_peserta.required'  => 'File daftar peserta wajib diupload.',
            'file_peserta.mimes'     => 'Daftar peserta harus berformat Excel (.xlsx atau .xls).',
            'file_peserta.max'       => 'File peserta maksimal 5MB.',
        ]);

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')->store('pengajuan/surat', 'local');
        }

        if ($request->hasFile('file_peserta')) {
            $validated['file_peserta'] = $request->file('file_peserta')->store('pengajuan/peserta', 'local');
        }

        $validated['nama_instansi'] = strip_tags($validated['nama_instansi']);
        $validated['pic_nama']      = strip_tags($validated['pic_nama']);
        if (!empty($validated['keterangan'])) {
            $validated['keterangan'] = strip_tags($validated['keterangan']);
        }

        $validated['status'] = 'pending';

        Pengajuan::create($validated);

        return redirect()->route('pengajuan.form')
            ->with('success', 'Pengajuan berhasil dikirim! Tim kami akan menghubungi ' . e($request->pic_nama) . ' dalam 3–5 hari kerja.');
    }
}
