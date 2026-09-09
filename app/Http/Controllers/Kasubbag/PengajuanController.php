<?php

namespace App\Http\Controllers\Kasubbag;

use App\Http\Controllers\Controller;
use App\Mail\PengajuanStatusMail;
use App\Models\Pengajuan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengajuan::query();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $searchSanitized = str_replace(['%', '_'], ['\%', '\_'], $search);
            $query->where(function ($q) use ($searchSanitized) {
                $q->where('nama_instansi', 'like', "%{$searchSanitized}%")
                  ->orWhere('pic_nama', 'like', "%{$searchSanitized}%")
                  ->orWhere('pic_email', 'like', "%{$searchSanitized}%")
                  ->orWhere('nim_nisn', 'like', "%{$searchSanitized}%");
            });
        }

        $pengajuans = $query->latest()->paginate(10)->appends($request->query());

        return view('kasubbag.pengajuan.index', compact('pengajuans'));
    }

    public function show(Pengajuan $pengajuan): View
    {
        $pengajuan->load(['instansi', 'pesertas', 'user']);

        $phone = preg_replace('/[^0-9]/', '', $pengajuan->pic_telp ?? '');
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        $waMessage = '';
        if ($pengajuan->status === 'approved') {
            $waMessage = "*PENGUMUMAN HASIL SELEKSI MAGANG*\n"
                . "*DINAS PENDIDIKAN PROVINSI SUMATERA SELATAN*\n"
                . "--------------------------------------------------\n"
                . "Yth. Sdr/i *{$pengajuan->pic_nama}*\n"
                . "NIM/NISN: " . ($pengajuan->nim_nisn ?? '-') . "\n"
                . "Asal: {$pengajuan->nama_instansi}\n\n"
                . "Selamat! Permohonan magang Anda dinyatakan:\n"
                . "✅ *DITERIMA (APPROVED)*\n\n"
                . "*Informasi Pelaksanaan Magang:*\n"
                . "• Periode: " . ($pengajuan->tgl_mulai?->translatedFormat('d F Y') ?? '-') . " s/d " . ($pengajuan->tgl_selesai?->translatedFormat('d F Y') ?? '-') . "\n"
                . "• Lokasi: Dinas Pendidikan Provinsi Sumatera Selatan (Jl. Kapten A. Rivai No.47, Palembang)\n\n"
                . "*Informasi Akun Portal Peserta:*\n"
                . "• Status Akun: *AKTIF* (Anda sudah dapat login)\n"
                . "• Email Login: {$pengajuan->pic_email}\n"
                . "• Link Login Portal: " . route('login') . "\n\n"
                . "*Surat Balasan / Letter of Acceptance (LoA) Resmi:*\n"
                . "Unduh dokumen LoA resmi Anda melalui tautan berikut:\n"
                . route('pengajuan.surat_balasan', $pengajuan) . "\n\n"
                . "*Pengumuman & Petunjuk Awal Magang:*\n"
                . "1. Hadir pada hari pertama magang pukul 07.30 WIB di Subbagian Umum & Kepegawaian Disdik Prov. Sumsel.\n"
                . "2. Mengenakan pakaian sopan rapi / almamater resmi instansi asal.\n"
                . "3. Membawa cetakan Surat Pengantar dan Surat Balasan (LoA) ini.\n\n"
                . "Terima kasih.\n"
                . "_Subbagian Umum dan Kepegawaian_\n"
                . "_Dinas Pendidikan Provinsi Sumatera Selatan_";
        } elseif ($pengajuan->status === 'rejected') {
            $waMessage = "*PEMBERITAHUAN HASIL SELEKSI MAGANG*\n"
                . "*DINAS PENDIDIKAN PROVINSI SUMATERA SELATAN*\n"
                . "--------------------------------------------------\n"
                . "Yth. Sdr/i *{$pengajuan->pic_nama}*\n"
                . "Asal: {$pengajuan->nama_instansi}\n\n"
                . "Sehubungan dengan permohonan magang yang Anda ajukan, kami sampaikan bahwa pengajuan Anda saat ini:\n"
                . "❌ *BELUM DAPAT DITERIMA (DITOLAK)*\n\n"
                . "*Alasan / Keterangan Penolakan:*\n"
                . "\"" . ($pengajuan->keterangan_reject ?? 'Kapasitas kuota penerimaan magang periode ini telah terpenuhi.') . "\"\n\n"
                . ($pengajuan->rekomendasi_instansi ? "*Rekomendasi Alternatif:*\n{$pengajuan->rekomendasi_instansi}\n\n" : "")
                . "*Surat Keterangan Resmi:*\n"
                . "Unduh surat penolakan resmi melalui tautan berikut:\n"
                . route('pengajuan.surat_balasan', $pengajuan) . "\n\n"
                . "Terima kasih atas partisipasi dan minat Anda.\n"
                . "_Subbagian Umum dan Kepegawaian_\n"
                . "_Dinas Pendidikan Provinsi Sumatera Selatan_";
        }

        $waUrl = "https://wa.me/{$phone}?text=" . rawurlencode($waMessage);

        return view('kasubbag.pengajuan.show', compact('pengajuan', 'waUrl', 'waMessage', 'phone'));
    }

    public function approve(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $request->validate([
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $pengajuan->update([
            'status'     => 'approved',
            'keterangan' => $request->keterangan ?? 'Pengajuan magang telah disetujui oleh Kasubbag.',
        ]);

        $pengajuan->syncPesertaOnApproval();

        if ($pengajuan->user_id) {
            User::where('id', $pengajuan->user_id)->update(['status' => User::STATUS_AKTIF]);
        }

        return redirect()->route('kasubbag.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan magang berhasil disetujui! Akun peserta telah diaktifkan dan LoA resmi siap dikirim via WhatsApp & Email.');
    }

    public function reject(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $request->validate([
            'keterangan_reject' => 'required|string|max:1000',
        ], [
            'keterangan_reject.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $pengajuan->update([
            'status'            => 'rejected',
            'keterangan_reject' => $request->keterangan_reject,
        ]);

        if ($pengajuan->user_id) {
            User::where('id', $pengajuan->user_id)->update(['status' => User::STATUS_DITOLAK]);
        }

        return redirect()->route('kasubbag.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan magang berhasil ditolak. Surat keterangan penolakan siap dikirim via WhatsApp & Email.');
    }

    public function sendEmail(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        if ($pengajuan->status === 'pending') {
            return redirect()->back()->with('error', 'Status pengajuan masih pending. Silakan setujui atau tolak terlebih dahulu sebelum mengirim notifikasi email.');
        }

        try {
            Mail::to($pengajuan->pic_email)->send(new PengajuanStatusMail($pengajuan));

            $statusText = $pengajuan->status === 'approved' ? 'Penerimaan & LoA' : 'Penolakan';

            return redirect()->route('kasubbag.pengajuan.show', $pengajuan)
                ->with('success', "Email notifikasi {$statusText} berhasil dikirim ke alamat email: {$pengajuan->pic_email}!");
        } catch (\Throwable $e) {
            return redirect()->route('kasubbag.pengajuan.show', $pengajuan)
                ->with('error', 'Terjadi kendala saat mengirim email: ' . $e->getMessage() . '. Pastikan konfigurasi SMTP pada file .env telah aktif.');
        }
    }

    public function downloadFile(Pengajuan $pengajuan, string $type)
    {
        $filePath = match ($type) {
            'surat'            => $pengajuan->file_surat,
            'peserta'          => $pengajuan->file_peserta,
            'transkrip'        => $pengajuan->file_transkrip,
            'surat_pernyataan' => $pengajuan->file_surat_pernyataan,
            default            => null,
        };

        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('local')->download($filePath);
    }

    public function downloadLoa(Pengajuan $pengajuan)
    {
        if ($pengajuan->status === 'pending') {
            return redirect()->back()->with('error', 'Surat balasan (LoA) belum tersedia untuk pengajuan yang masih berstatus pending.');
        }

        $pengajuan->load('pesertas');

        if ($pengajuan->status === 'rejected') {
            $pdf = Pdf::loadView('pdf.loa_penolakan_pdf', compact('pengajuan'))
                ->setPaper('a4', 'portrait');

            $filename = 'Surat_Penolakan_Magang_' . str_replace(' ', '_', $pengajuan->nama_instansi) . '.pdf';

            return $pdf->download($filename);
        }

        $pdf = Pdf::loadView('pdf.loa_pdf', compact('pengajuan'))
            ->setPaper('a4', 'portrait');

        $filename = 'LoA_Surat_Balasan_' . str_replace(' ', '_', $pengajuan->nama_instansi) . '.pdf';

        return $pdf->download($filename);
    }
}
