@extends('layouts.adminlte')
@section('title', 'Status Pengajuan')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-info-circle"></i> Status Pengajuan</h1>
        <p>Status pendaftaran magang dan penempatan Anda.</p>
    </div>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-clipboard-list"></i> Detail Pengajuan</h3>
    </div>
    <div style="padding: 1.5rem;">
        @if($peserta)
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tbody>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; width: 250px; color: #64748b; font-weight: 600;">Nama</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $peserta->nama }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Instansi</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $peserta->instansi?->nama ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Jurusan</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $peserta->jurusan ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Bidang Penempatan</th>
                    <td style="padding: 1rem 0;">{!! $peserta->bidang?->nama ?? '<span class="badge-status pending">Belum ditempatkan</span>' !!}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Pembimbing</th>
                    <td style="padding: 1rem 0;">{!! $peserta->pembimbing?->nama ?? '<span class="badge-status pending">Belum ditentukan</span>' !!}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Tanggal Mulai</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ ($peserta->tgl_mulai ?? $peserta->pengajuan?->tgl_mulai)?->format('d F Y') ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Tanggal Selesai</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ ($peserta->tgl_selesai ?? $peserta->pengajuan?->tgl_selesai)?->format('d F Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Status Pengajuan</th>
                    <td style="padding: 1rem 0;">
                        @php $status = $peserta->pengajuan?->status @endphp
                        @if($status === 'approved') <span class="badge-status approved">Disetujui</span>
                        @elseif($status === 'rejected') <span class="badge-status rejected">Ditolak</span>
                        @else <span class="badge-status pending">Menunggu</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="alert-toast alert-toast-danger">
            <i class="fas fa-exclamation-triangle"></i> Data peserta tidak ditemukan. Hubungi Admin untuk informasi lebih lanjut.
        </div>
        @endif
    </div>
</div>
@endsection
