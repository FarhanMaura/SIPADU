@extends('layouts.adminlte')
@section('title', 'Detail Pengajuan & LoA')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-file-alt"></i> Detail Pengajuan & Penerbitan LoA</h1>
        <p>Tinjau kelengkapan pengajuan magang dan cetak Surat Balasan (LoA).</p>
    </div>
    <a href="{{ route('kasubbag.pengajuan.index') }}" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-info-circle"></i> Informasi Permohonan Magang</h3>
        @if($pengajuan->status === 'approved')
            <a href="{{ route('kasubbag.pengajuan.loa', $pengajuan) }}" class="action-button" style="background: #16a34a; box-shadow: none;">
                <i class="fas fa-file-pdf"></i> Download Surat Balasan (LoA PDF)
            </a>
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
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Email Peserta</th>
                    <td style="padding: 1rem 0;"><code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px; color: #334155;">{{ $pengajuan->pic_email }}</code></td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">No. Telepon / WhatsApp</th>
                    <td style="padding: 1rem 0;">{{ $pengajuan->pic_telp }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Periode Pelaksanaan</th>
                    <td style="padding: 1rem 0; font-weight: 600; color: #1e293b;">
                        {{ $pengajuan->tgl_mulai?->format('d F Y') }} s/d {{ $pengajuan->tgl_selesai?->format('d F Y') }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Status Verifikasi</th>
                    <td style="padding: 1rem 0;">
                        @if($pengajuan->status === 'pending')
                            <span class="badge-status pending" style="background:#fef3c7; color:#d97706;">Pending (Menunggu Persetujuan)</span>
                        @elseif($pengajuan->status === 'approved')
                            <span class="badge-status approved" style="background:#dcfce7; color:#15803d;">Disetujui Kasubbag</span>
                        @else
                            <span class="badge-status rejected" style="background:#fee2e2; color:#b91c1c;">Ditolak</span>
                        @endif
                    </td>
                </tr>
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
                @if($pengajuan->file_peserta)
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">File Daftar Peserta (Excel)</th>
                    <td style="padding: 1rem 0;">
                        <a href="{{ route('kasubbag.pengajuan.file', ['pengajuan' => $pengajuan->id, 'type' => 'peserta']) }}" class="action-button" style="background: #10b981; padding: 0.4rem 0.8rem; font-size: 0.85rem; box-shadow: none;">
                            <i class="fas fa-file-excel"></i> Unduh File Excel Peserta
                        </a>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Form Aksi Persetujuan / Penolakan -->
        @if($pengajuan->status === 'pending')
        <div style="margin-top: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
            <h4 style="margin-bottom: 1rem; color: #0f172a;"><i class="fas fa-gavel"></i> Keputusan Kasubbag Umum & Kepegawaian</h4>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <form action="{{ route('kasubbag.pengajuan.approve', $pengajuan) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="action-button" style="background: #16a34a; padding: 0.75rem 1.5rem;" onclick="return confirm('Setujui pengajuan ini dan terbitkan LoA?')">
                        <i class="fas fa-check-circle"></i> Setujui Pengajuan & Terbitkan LoA
                    </button>
                </form>

                <form action="{{ route('kasubbag.pengajuan.reject', $pengajuan) }}" method="POST" id="form-reject-kasubbag" style="display: flex; gap: 0.5rem; flex: 1;">
                    @csrf @method('PATCH')
                    <input type="text" name="keterangan_reject" placeholder="Alasan penolakan pengajuan..." required class="form-control" style="border-radius: 8px; flex: 1;">
                    <button type="submit" class="action-button" style="background: #dc2626; padding: 0.75rem 1.25rem;">
                        <i class="fas fa-times-circle"></i> Tolak Permohonan
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
