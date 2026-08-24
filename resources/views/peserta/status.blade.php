@extends('layouts.adminlte')
@section('title', 'Melihat Penempatan')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-search-location"></i> Melihat Penempatan Magang</h1>
        <p>Detail bidang penempatan, pembimbing lapangan, dan periode pelaksanaan magang Anda.</p>
    </div>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-id-card"></i> Informasi Penempatan</h3>
        @if($peserta && $peserta->pengajuan?->status === 'approved')
            <a href="{{ route('peserta.loa.download') }}" class="action-button" style="background: #16a34a; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);">
                <i class="fas fa-file-pdf"></i> Unduh LoA (Surat Balasan)
            </a>
        @endif
    </div>
    <div style="padding: 1.5rem;">
        @if($peserta)
        
        @if($peserta->pengajuan?->status === 'approved')
        <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #86efac; border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: #16a34a; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div>
                    <h4 style="margin: 0 0 0.25rem 0; color: #166534; font-weight: 700; font-size: 1.05rem;">Surat Balasan / Letter of Acceptance (LoA) Resmi</h4>
                    <p style="margin: 0; color: #15803d; font-size: 0.875rem;">Permohonan magang Anda telah disetujui resmi oleh Dinas Pendidikan Provinsi Sumatera Selatan.</p>
                </div>
            </div>
            <a href="{{ route('peserta.loa.download') }}" class="action-button" style="background: #16a34a; padding: 0.6rem 1.25rem; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; color: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);">
                <i class="fas fa-download"></i> Unduh LoA PDF
            </a>
        </div>
        @endif

        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tbody>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; width: 250px; color: #64748b; font-weight: 600;">Nama Peserta</th>
                    <td style="padding: 1rem 0; font-weight: 700; color: #0f172a; font-size: 1.05rem;">{{ $peserta->nama }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">NIM / NISN</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $peserta->nim_nisn ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Instansi / Sekolah / Kampus</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $peserta->instansi?->nama ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Jurusan / Program Studi</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $peserta->jurusan ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Bidang Penempatan</th>
                    <td style="padding: 1rem 0;">
                        @if($peserta->bidang)
                            <strong style="color: #2563eb; font-size: 1rem;"><i class="fas fa-building mr-1"></i> Bidang {{ $peserta->bidang->nama }}</strong>
                        @else
                            <span class="badge-status pending">Belum Ditempatkan</span>
                        @endif
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Pembimbing Lapangan</th>
                    <td style="padding: 1rem 0;">
                        @if($peserta->pembimbing)
                            <strong style="color: #059669; font-size: 1rem;"><i class="fas fa-user-tie mr-1"></i> {{ $peserta->pembimbing->nama }}</strong>
                        @else
                            <span class="badge-status pending">Belum Ditentukan</span>
                        @endif
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Tanggal Mulai</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ ($peserta->tgl_mulai ?? $peserta->pengajuan?->tgl_mulai)?->format('d F Y') ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Tanggal Selesai</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ ($peserta->tgl_selesai ?? $peserta->pengajuan?->tgl_selesai)?->format('d F Y') ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Status Pengajuan</th>
                    <td style="padding: 1rem 0;">
                        @php $status = $peserta->pengajuan?->status @endphp
                        @if($status === 'approved') 
                            <span class="badge-status approved">Disetujui Kasubbag</span>
                            <div style="margin-top: 0.5rem;">
                                <a href="{{ route('peserta.loa.download') }}" class="action-button" style="background: #16a34a; padding: 0.35rem 0.75rem; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; color: white; border-radius: 6px;">
                                    <i class="fas fa-download"></i> Unduh LoA PDF
                                </a>
                            </div>
                        @elseif($status === 'rejected') 
                            <span class="badge-status rejected">Ditolak</span>
                        @else 
                            <span class="badge-status pending">Menunggu Verifikasi</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="alert-toast alert-toast-danger">
            <i class="fas fa-exclamation-triangle"></i> Data peserta tidak ditemukan. Hubungi Admin/Kasubbag untuk informasi lebih lanjut.
        </div>
        @endif
    </div>
</div>
@endsection
