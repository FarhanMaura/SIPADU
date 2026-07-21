@extends('layouts.adminlte')
@section('title', 'Detail Peserta')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-graduate"></i> Detail Peserta</h1>
        <p>Lihat detail profil dan penempatan peserta.</p>
    </div>
    <a href="{{ route('admin.peserta.index') }}" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-info-circle"></i> Informasi Peserta</h3>
    </div>
    <div style="padding: 1.5rem;">
        <table style="width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 1.5rem;">
            <tbody>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; width: 250px; color: #64748b; font-weight: 600;">Nama</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $peserta->nama }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">NIM / NISN</th>
                    <td style="padding: 1rem 0;">{{ $peserta->nim_nisn ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Jenis Peserta</th>
                    <td style="padding: 1rem 0;">
                        @if($peserta->jenis_peserta)
                            <span class="badge-status {{ $peserta->jenis_peserta === 'Mahasiswa' ? 'approved' : 'pending' }}">
                                {{ $peserta->jenis_peserta }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Jurusan / Prodi</th>
                    <td style="padding: 1rem 0;">{{ $peserta->jurusan ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Email</th>
                    <td style="padding: 1rem 0;"><code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px; color: #334155;">{{ $peserta->user?->email ?? '-' }}</code></td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Instansi</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #0f172a;">{{ $peserta->instansi?->nama ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Bidang / Seksi</th>
                    <td style="padding: 1rem 0;">{!! $peserta->bidang?->nama ?? '<span class="badge-status pending">Belum ditempatkan</span>' !!}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Pembimbing</th>
                    <td style="padding: 1rem 0;">{!! $peserta->pembimbing?->nama ?? '<span class="badge-status pending">Belum ditempatkan</span>' !!}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Tgl Mulai</th>
                    <td style="padding: 1rem 0;">{{ $peserta->tgl_mulai?->format('d F Y') ?? $peserta->pengajuan?->tgl_mulai?->format('d F Y') ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Tgl Selesai</th>
                    <td style="padding: 1rem 0;">{{ $peserta->tgl_selesai?->format('d F Y') ?? $peserta->pengajuan?->tgl_selesai?->format('d F Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Status</th>
                    <td style="padding: 1rem 0;">
                        <span class="badge-status {{ $peserta->status === 'aktif' ? 'approved' : ($peserta->status === 'selesai' ? 'pending' : 'rejected') }}">
                            {{ ucfirst($peserta->status ?? 'aktif') }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <a href="{{ route('admin.peserta.penempatan', $peserta) }}" class="action-button" style="background: #f59e0b; color: white;">
            <i class="fas fa-map-marker-alt"></i> Atur Penempatan
        </a>
    </div>
</div>
@endsection
