@extends('layouts.adminlte')
@section('title', 'Detail Pengajuan')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-file-alt"></i> Detail Pengajuan</h1>
        <p>Lihat detail informasi pengajuan magang dari instansi.</p>
    </div>
    <a href="{{ route('admin.pengajuan.index') }}" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-info-circle"></i> Informasi Pengajuan</h3>
    </div>
    <div style="padding: 1.5rem;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tbody>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; width: 250px; color: #64748b; font-weight: 600;">Nama Instansi</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $pengajuan->nama_instansi }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Nama PIC</th>
                    <td style="padding: 1rem 0;">{{ $pengajuan->pic_nama }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Email PIC</th>
                    <td style="padding: 1rem 0;"><code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px; color: #334155;">{{ $pengajuan->pic_email }}</code></td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">No. HP PIC</th>
                    <td style="padding: 1rem 0;">{{ $pengajuan->pic_telp }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Jumlah Peserta</th>
                    <td style="padding: 1rem 0; font-weight: 600;">{{ $pengajuan->jml_peserta }} <span style="font-weight: 400; color: #64748b;">orang</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Tanggal Mulai</th>
                    <td style="padding: 1rem 0;">{{ $pengajuan->tgl_mulai?->format('d F Y') }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Tanggal Selesai</th>
                    <td style="padding: 1rem 0;">{{ $pengajuan->tgl_selesai?->format('d F Y') }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Keterangan</th>
                    <td style="padding: 1rem 0;">{{ $pengajuan->keterangan ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Status</th>
                    <td style="padding: 1rem 0;">
                        @if($pengajuan->status === 'pending') <span class="badge-status pending" style="background:#fef3c7; color:#d97706;">Pending</span>
                        @elseif($pengajuan->status === 'approved') <span class="badge-status approved" style="background:#dcfce7; color:#15803d;">Disetujui</span>
                        @else <span class="badge-status rejected" style="background:#fee2e2; color:#b91c1c;">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @if($pengajuan->keterangan_reject)
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Alasan Penolakan</th>
                    <td style="padding: 1rem 0; color: #dc2626; font-weight: 500;">{{ $pengajuan->keterangan_reject }}</td>
                </tr>
                @endif
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Surat Permohonan</th>
                    <td style="padding: 1rem 0;">
                        @if($pengajuan->file_surat)
                        <a href="{{ Storage::url($pengajuan->file_surat) }}" target="_blank" class="action-button" style="background: #0ea5e9; padding: 0.4rem 0.8rem; font-size: 0.85rem; box-shadow: none;">
                            <i class="fas fa-file-pdf"></i> Lihat File
                        </a>
                        @else <span style="color: #94a3b8;">-</span> @endif
                    </td>
                </tr>
                <tr>
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">File Peserta (Excel)</th>
                    <td style="padding: 1rem 0;">
                        @if($pengajuan->file_peserta)
                        <a href="{{ Storage::url($pengajuan->file_peserta) }}" class="action-button" style="background: #10b981; padding: 0.4rem 0.8rem; font-size: 0.85rem; box-shadow: none;">
                            <i class="fas fa-file-excel"></i> Download
                        </a>
                        @else <span style="color: #94a3b8;">-</span> @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
