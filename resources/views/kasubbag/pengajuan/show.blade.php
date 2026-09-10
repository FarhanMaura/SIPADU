@extends('layouts.adminlte')
@section('title', 'Detail Pengajuan & LoA')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-file-alt"></i> Detail Pengajuan & Penerbitan LoA</h1>
        <p>Tinjau kelengkapan pengajuan magang, verifikasi status, dan kirimkan notifikasi resmi (WhatsApp & Email).</p>
    </div>
    <a href="{{ route('kasubbag.pengajuan.index') }}" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Alert Notifikasi Flash -->
@if(session('success'))
<div class="alert alert-success" style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
    <i class="fas fa-check-circle" style="font-size: 1.25rem; color: #16a34a;"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
    <i class="fas fa-exclamation-triangle" style="font-size: 1.25rem; color: #dc2626;"></i>
    <div>{{ session('error') }}</div>
</div>
@endif

<!-- KARTU UTAMA: PUSAT NOTIFIKASI OTOMATIS (WHATSAPP & EMAIL) -->
@if($pengajuan->status !== 'pending')
<div class="table-container" style="margin-bottom: 2rem; border: 2px solid {{ $pengajuan->status === 'approved' ? '#86efac' : '#fca5a5' }}; border-radius: 18px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">
    <div style="background: {{ $pengajuan->status === 'approved' ? 'linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%)' : 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)' }}; padding: 1.25rem 1.75rem; border-bottom: 1px solid {{ $pengajuan->status === 'approved' ? '#bbf7d0' : '#fecaca' }};">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="badge" style="background: {{ $pengajuan->status === 'approved' ? '#16a34a' : '#dc2626' }}; color: white; padding: 0.35rem 0.8rem; border-radius: 20px; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fas {{ $pengajuan->status === 'approved' ? 'fa-check-circle' : 'fa-times-circle' }}"></i> Status: {{ $pengajuan->status === 'approved' ? 'Diterima (Approved)' : 'Ditolak (Rejected)' }}
                </span>
                <h3 style="margin: 0.5rem 0 0.2rem 0; color: {{ $pengajuan->status === 'approved' ? '#14532d' : '#7f1d1d' }}; font-weight: 800; font-size: 1.25rem;">
                    Kirim Notifikasi Email & WhatsApp ke Peserta
                </h3>
                <p style="margin: 0; color: {{ $pengajuan->status === 'approved' ? '#166534' : '#991b1b' }}; font-size: 0.9rem;">
                    Kirimkan pengumuman hasil seleksi, rincian akun, pengarahan magang, dan link Surat Balasan (LoA) ke kontak peserta.
                </p>
            </div>
            <div>
                <a href="{{ route('kasubbag.pengajuan.loa', $pengajuan) }}" class="action-button" style="background: #0f172a; color: white; padding: 0.65rem 1.2rem; font-weight: 600; font-size: 0.88rem; box-shadow: none;">
                    <i class="fas fa-file-pdf"></i> Unduh {{ $pengajuan->status === 'approved' ? 'LoA PDF' : 'Surat Penolakan PDF' }}
                </a>
            </div>
        </div>
    </div>

    <div style="padding: 1.5rem 1.75rem; background: white;">
        <div style="margin-bottom: 1.25rem; padding: 0.85rem 1.1rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; font-size: 0.86rem; color: #166534; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-lightbulb" style="font-size: 1.2rem; color: #16a34a; flex-shrink: 0;"></i>
            <div>
                <strong>Sistem Direct Link Praktis (One-Click):</strong> Klik tombol <strong>Kirim via WhatsApp</strong> atau <strong>Kirim via Gmail</strong> di bawah untuk langsung membuka tab dengan nomor/email tujuan, surat balasan, link LoA resmi, dan info akun yang sudah otomatis terisi lengkap tanpa konfigurasi server!
            </div>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 0.85rem; align-items: center;">
            <!-- Tombol Kirim WhatsApp (Direct Link) -->
            <a href="{{ $waUrl }}" target="_blank" class="action-button" style="background: #25D366; color: white; padding: 0.85rem 1.45rem; font-weight: 700; font-size: 0.95rem; border-radius: 12px; display: inline-flex; align-items: center; gap: 0.6rem; text-decoration: none; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35);">
                <i class="fab fa-whatsapp" style="font-size: 1.35rem;"></i> Kirim via WhatsApp
            </a>

            <!-- Tombol Kirim via Gmail Web (Direct Link seperti WA) -->
            <a href="{{ $gmailUrl }}" target="_blank" class="action-button" style="background: #EA4335; color: white; padding: 0.85rem 1.45rem; font-weight: 700; font-size: 0.95rem; border-radius: 12px; display: inline-flex; align-items: center; gap: 0.6rem; text-decoration: none; box-shadow: 0 4px 14px rgba(234, 67, 53, 0.35);">
                <i class="fab fa-google" style="font-size: 1.2rem;"></i> Kirim via Gmail (Buka Tab)
            </a>

            <!-- Status Tautan LoA Publik (Membuka langsung di browser) -->
            <a href="{{ route('pengajuan.surat_balasan', $pengajuan) }}" target="_blank" class="action-button" style="background: #f8fafc; color: #1e293b; border: 1.5px solid #cbd5e1; padding: 0.85rem 1.25rem; font-weight: 600; font-size: 0.9rem; border-radius: 12px; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; box-shadow: none;">
                <i class="fas fa-file-pdf" style="color: #ef4444; font-size: 1.1rem;"></i> Buka Surat Balasan (LoA)
            </a>
        </div>

        <div style="margin-top: 1.25rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <!-- Accordion Preview Teks WhatsApp -->
            <div style="padding: 1rem 1.25rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                <div style="font-size: 0.82rem; font-weight: 700; color: #166534; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="fab fa-whatsapp" style="color: #25D366; font-size: 1rem;"></i> Template Pesan WhatsApp:
                </div>
                <pre style="white-space: pre-wrap; font-family: 'Segoe UI', Tahoma, sans-serif; font-size: 0.8rem; color: #1e293b; background: white; padding: 0.85rem; border-radius: 8px; border: 1px solid #e2e8f0; margin: 0; max-height: 180px; overflow-y: auto;">{{ $waMessage }}</pre>
            </div>

            <!-- Accordion Preview Teks Email -->
            <div style="padding: 1rem 1.25rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                <div style="font-size: 0.82rem; font-weight: 700; color: #991b1b; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="fab fa-google" style="color: #EA4335; font-size: 1rem;"></i> Template Pesan Email (Gmail):
                </div>
                <pre style="white-space: pre-wrap; font-family: 'Segoe UI', Tahoma, sans-serif; font-size: 0.8rem; color: #1e293b; background: white; padding: 0.85rem; border-radius: 8px; border: 1px solid #e2e8f0; margin: 0; max-height: 180px; overflow-y: auto;"><strong>Subjek:</strong> {{ $emailSubject }}

{{ $emailBody }}</pre>
            </div>
        </div>
    </div>
</div>
@endif

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-info-circle"></i> Informasi Permohonan Magang</h3>
        @if($pengajuan->status === 'approved')
            <span class="badge-status approved" style="background:#dcfce7; color:#15803d; font-size:0.9rem; padding:0.4rem 0.8rem;">
                <i class="fas fa-check-circle"></i> Disetujui Kasubbag
            </span>
        @elseif($pengajuan->status === 'rejected')
            <span class="badge-status rejected" style="background:#fee2e2; color:#b91c1c; font-size:0.9rem; padding:0.4rem 0.8rem;">
                <i class="fas fa-times-circle"></i> Ditolak
            </span>
        @else
            <span class="badge-status pending" style="background:#fef3c7; color:#d97706; font-size:0.9rem; padding:0.4rem 0.8rem;">
                <i class="fas fa-clock"></i> Pending (Menunggu Keputusan)
            </span>
        @endif
    </div>

    <div style="padding: 1.5rem;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tbody>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; width: 250px; color: #64748b; font-weight: 600;">Nama Lengkap Peserta</th>
                    <td style="padding: 1rem 0; font-weight: 700; color: #0f172a; font-size: 1.05rem;">{{ $pengajuan->pic_nama }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">NIM / NIS / NISN</th>
                    <td style="padding: 1rem 0; font-weight: 600; color: #1e293b;">{{ $pengajuan->nim_nisn ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Kategori Peserta</th>
                    <td style="padding: 1rem 0;">{{ $pengajuan->jenis_peserta ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Jurusan / Program Studi</th>
                    <td style="padding: 1rem 0; font-weight: 500;">{{ $pengajuan->jurusan ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Asal Sekolah / Kampus</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $pengajuan->nama_instansi }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Email Peserta Magang</th>
                    <td style="padding: 1rem 0;"><code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px; color: #334155; font-weight:600;">{{ $pengajuan->pic_email }}</code></td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">No. WhatsApp / HP</th>
                    <td style="padding: 1rem 0; font-weight:600; color:#0f172a;">
                        <i class="fab fa-whatsapp" style="color:#25D366; margin-right: 4px;"></i> {{ $pengajuan->pic_telp }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Periode Pelaksanaan</th>
                    <td style="padding: 1rem 0; font-weight: 600; color: #1e293b;">
                        {{ $pengajuan->tgl_mulai?->translatedFormat('d F Y') }} s/d {{ $pengajuan->tgl_selesai?->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Status Akun Portal</th>
                    <td style="padding: 1rem 0;">
                        @if($pengajuan->user)
                            @if($pengajuan->user->isActive())
                                <span class="badge" style="background:#dcfce7; color:#15803d; padding:0.3rem 0.6rem; border-radius:6px; font-size:0.8rem; font-weight:700;">AKTIF (Dapat Login)</span>
                            @elseif($pengajuan->user->isPending())
                                <span class="badge" style="background:#fef3c7; color:#d97706; padding:0.3rem 0.6rem; border-radius:6px; font-size:0.8rem; font-weight:700;">PENDING (Menunggu Validasi)</span>
                            @else
                                <span class="badge" style="background:#fee2e2; color:#b91c1c; padding:0.3rem 0.6rem; border-radius:6px; font-size:0.8rem; font-weight:700;">DITOLAK</span>
                            @endif
                        @else
                            <span style="color:#94a3b8; font-size:0.85rem;">Belum membuat akun login</span>
                        @endif
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Catatan Pemohon</th>
                    <td style="padding: 1rem 0;">{{ $pengajuan->keterangan ?? '-' }}</td>
                </tr>

                @if($pengajuan->status === 'rejected' && $pengajuan->keterangan_reject)
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #dc2626; font-weight: 600;">Alasan Penolakan</th>
                    <td style="padding: 1rem 0; color: #dc2626; font-weight: 500;">{{ $pengajuan->keterangan_reject }}</td>
                </tr>
                @endif
                @if($pengajuan->rekomendasi_instansi)
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #0284c7; font-weight: 600;">Rekomendasi Pengalihan Instansi</th>
                    <td style="padding: 1rem 0; color: #0284c7; font-weight: 500;">{{ $pengajuan->rekomendasi_instansi }}</td>
                </tr>
                @endif

                <!-- Berkas Persyaratan -->
                @if($pengajuan->file_surat)
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Surat Permohonan Instansi</th>
                    <td style="padding: 1rem 0;">
                        <a href="{{ route('kasubbag.pengajuan.file', ['pengajuan' => $pengajuan->id, 'type' => 'surat']) }}" target="_blank" class="action-button" style="background: #0ea5e9; padding: 0.4rem 0.8rem; font-size: 0.85rem; box-shadow: none;">
                            <i class="fas fa-file-pdf"></i> Unduh Surat Permohonan
                        </a>
                    </td>
                </tr>
                @endif
                @if($pengajuan->file_transkrip)
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Transkrip Nilai</th>
                    <td style="padding: 1rem 0;">
                        <a href="{{ route('kasubbag.pengajuan.file', ['pengajuan' => $pengajuan->id, 'type' => 'transkrip']) }}" target="_blank" class="action-button" style="background: #8b5cf6; padding: 0.4rem 0.8rem; font-size: 0.85rem; box-shadow: none;">
                            <i class="fas fa-file-alt"></i> Unduh Transkrip Nilai
                        </a>
                    </td>
                </tr>
                @endif
                @if($pengajuan->file_surat_pernyataan)
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Surat Pernyataan Magang Berdampak</th>
                    <td style="padding: 1rem 0;">
                        <a href="{{ route('kasubbag.pengajuan.file', ['pengajuan' => $pengajuan->id, 'type' => 'surat_pernyataan']) }}" target="_blank" class="action-button" style="background: #ec4899; padding: 0.4rem 0.8rem; font-size: 0.85rem; box-shadow: none;">
                            <i class="fas fa-file-signature"></i> Unduh Surat Pernyataan
                        </a>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Form Aksi Persetujuan / Penolakan (Hanya jika status masih pending) -->
        @if($pengajuan->status === 'pending')
        <div style="margin-top: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
            <h4 style="margin-bottom: 1rem; color: #0f172a;"><i class="fas fa-gavel"></i> Keputusan Kasubbag Umum & Kepegawaian</h4>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <form action="{{ route('kasubbag.pengajuan.approve', $pengajuan) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="action-button" style="background: #16a34a; padding: 0.75rem 1.5rem;" onclick="return confirm('Setujui pengajuan ini, aktifkan akun peserta, dan terbitkan LoA?')">
                        <i class="fas fa-check-circle"></i> Setujui Pengajuan & Terbitkan LoA
                    </button>
                </form>

                <form action="{{ route('kasubbag.pengajuan.reject', $pengajuan) }}" method="POST" id="form-reject-kasubbag" style="display: flex; gap: 0.5rem; flex: 1;">
                    @csrf @method('PATCH')
                    <input type="text" name="keterangan_reject" placeholder="Alasan penolakan pengajuan..." required class="form-control" style="border-radius: 8px; flex: 1;">
                    <button type="submit" class="action-button" style="background: #dc2626; padding: 0.75rem 1.25rem;" onclick="return confirm('Tolak permohonan magang ini?')">
                        <i class="fas fa-times-circle"></i> Tolak Permohonan
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
