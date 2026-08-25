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
            'pic_nama'              => 'required|string|max:255',
            'nim_nisn'              => 'required|string|max:100',
            'jenis_peserta'         => 'required|string|max:100',
            'jurusan'               => 'required|string|max:255',
            'nama_instansi'         => 'required|string|max:255',
            'pic_email'             => 'required|email|max:255',
            'pic_telp'              => 'required|string|max:20',
            'tgl_mulai'             => 'required|date',
            'tgl_selesai'           => 'required|date|after:tgl_mulai',
            'file_surat'            => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_transkrip'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_surat_pernyataan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_peserta'          => 'nullable|file|mimes:xlsx,xls|max:5120',
            'keterangan'            => 'nullable|string|max:2000',
        ], [
            'pic_nama.required'              => 'Nama lengkap peserta wajib diisi.',
            'nim_nisn.required'              => 'NIM / NISN wajib diisi.',
            'jenis_peserta.required'         => 'Kategori / jenis peserta wajib dipilih.',
            'jurusan.required'               => 'Jurusan / program studi wajib diisi.',
            'nama_instansi.required'         => 'Nama sekolah / kampus asal wajib diisi.',
            'pic_email.required'             => 'Email peserta wajib diisi.',
            'pic_email.email'                => 'Format email peserta tidak valid.',
            'pic_telp.required'              => 'No. HP / WhatsApp wajib diisi.',
            'tgl_mulai.required'             => 'Tanggal mulai wajib diisi.',
            'tgl_selesai.required'           => 'Tanggal selesai wajib diisi.',
            'tgl_selesai.after'              => 'Tanggal selesai harus setelah tanggal mulai.',
            'file_surat.required'            => 'Surat pengantar wajib diupload.',
            'file_surat.mimes'               => 'Surat pengantar harus berformat PDF, JPG, atau PNG.',
            'file_surat.max'                 => 'Surat pengantar maksimal 5MB.',
            'file_transkrip.required'        => 'Transkrip nilai wajib diupload.',
            'file_transkrip.mimes'           => 'Transkrip nilai harus berformat PDF, JPG, atau PNG.',
            'file_transkrip.max'             => 'Transkrip nilai maksimal 5MB.',
            'file_surat_pernyataan.required' => 'Surat pernyataan wajib diupload.',
            'file_surat_pernyataan.mimes'    => 'Surat pernyataan harus berformat PDF, JPG, atau PNG.',
            'file_surat_pernyataan.max'      => 'Surat pernyataan maksimal 5MB.',
        ]);

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')->store('pengajuan/surat', 'local');
        }

        if ($request->hasFile('file_peserta')) {
            $validated['file_peserta'] = $request->file('file_peserta')->store('pengajuan/peserta', 'local');
        }

        if ($request->hasFile('file_transkrip')) {
            $validated['file_transkrip'] = $request->file('file_transkrip')->store('pengajuan/transkrip', 'local');
        }

        if ($request->hasFile('file_surat_pernyataan')) {
            $validated['file_surat_pernyataan'] = $request->file('file_surat_pernyataan')->store('pengajuan/surat_pernyataan', 'local');
        }

        $validated['pic_nama']      = strip_tags($validated['pic_nama']);
        $validated['nim_nisn']      = strip_tags($validated['nim_nisn']);
        $validated['jenis_peserta'] = strip_tags($validated['jenis_peserta']);
        $validated['jurusan']       = strip_tags($validated['jurusan']);
        $validated['nama_instansi'] = strip_tags($validated['nama_instansi']);
        if (!empty($validated['keterangan'])) {
            $validated['keterangan'] = strip_tags($validated['keterangan']);
        }

        $validated['jml_peserta'] = 1; // Pengajuan individu
        $validated['status']      = 'pending';

        Pengajuan::create($validated);

        return redirect()->route('pengajuan.form')
            ->with('success', 'Pengajuan magang berhasil dikirim! Tim kami akan memverifikasi dan mengkonfirmasi ke email ' . e($request->pic_email) . ' dalam 1–3 hari kerja.');
    }

    public function downloadSuratBalasan(Pengajuan $pengajuan)
    {
        if ($pengajuan->status === 'pending') {
            return redirect()->back()->with('error', 'Surat balasan belum tersedia untuk pengajuan yang masih dalam proses verifikasi.');
        }

        if ($pengajuan->status === 'rejected') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.loa_penolakan_pdf', compact('pengajuan'))
                ->setPaper('a4', 'portrait');

            return $pdf->download('Surat_Penolakan_Magang_' . str_replace(' ', '_', $pengajuan->nama_instansi) . '.pdf');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('emails.surat_balasan_pdf', compact('pengajuan'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Surat_Balasan_Magang_' . str_replace(' ', '_', $pengajuan->nama_instansi) . '.pdf');
    }
}
