@extends('layouts.adminlte')
@section('title', 'Kasubbag Dashboard')

@section('content')
<!-- Header Greeting -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-shield"></i> Selamat datang, {{ auth()->user()->name }}!</h1>
        <p><i class="fas fa-building"></i> Kasubbag Umum dan Kepegawaian — Dinas Pendidikan Provinsi Sumatera Selatan.</p>
    </div>
</div>

<!-- Info Alert -->
<div class="alert alert-info border-0 shadow-sm mb-4" style="background: #e0f2fe; color: #0369a1; border-radius: 12px; padding: 1rem 1.25rem;">
    <i class="fas fa-info-circle mr-2"></i> <strong>Peran Kasubbag Umum & Kepegawaian:</strong> Meninjau kesesuaian jurusan permohonan magang, memberikan pembinaan hari pertama, dan menyetujui rekapitulasi penilaian untuk penerbitan sertifikat magang.
</div>

<!-- Stats -->
<div class="stats-grid">
    <a href="{{ route('admin.pengajuan.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-label">Pengajuan Menunggu Review</div>
        <div class="stat-value">{{ $stats['pengajuan_pending'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Review Sekarang</div>
    </a>
    <a href="{{ route('admin.pengajuan.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-label">Permohonan Disetujui</div>
        <div class="stat-value">{{ $stats['pengajuan_approved'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Lihat Detail</div>
    </a>
    <a href="{{ route('admin.peserta.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-label">Peserta Magang Aktif</div>
        <div class="stat-value">{{ $stats['total_peserta'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Lihat Detail</div>
    </a>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-award"></i></div>
        <div class="stat-label">Penilaian Selesai</div>
        <div class="stat-value">{{ $stats['penilaian_selesai'] }}</div>
    </div>
</div>

<!-- Tables -->
<div class="table-container mb-4">
    <div class="table-toolbar">
        <h3><i class="fas fa-file-signature"></i> Pengajuan Magang Terbaru</h3>
        <div class="filter-tabs">
            <a href="{{ route('admin.pengajuan.index') }}" style="text-decoration: none;"><span class="active">Kelola</span></a>
        </div>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Instansi / Kampus</th>
                    <th>PIC & Kontak</th>
                    <th>Status Verifikasi Jurusan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan_terbaru as $p)
                <tr>
                    <td><strong>{{ $p->nama_instansi }}</strong></td>
                    <td>{{ $p->pic_nama }} ({{ $p->pic_telp }})</td>
                    <td>
                        @if($p->status === 'pending') <span class="badge-status pending">Menunggu Pertimbangan Jurusan</span>
                        @elseif($p->status === 'approved') <span class="badge-status approved">Disetujui (Jurusan Sesuai)</span>
                        @else <span class="badge-status rejected">Ditolak / Dialihkan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4" style="color: #94a3b8;">Belum ada pengajuan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
