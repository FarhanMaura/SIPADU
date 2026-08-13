@extends('layouts.adminlte')
@section('title', 'Admin Dashboard')

@section('content')
<!-- Header Greeting -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-chart-simple"></i> Selamat datang, {{ auth()->user()->name }}!</h1>
        <p><i class="fas fa-user-cog"></i> Administrator Sistem — Mengelola master data, penentuan pembimbing, rekapitulasi nilai, dan pengguna.</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <a href="{{ route('admin.penentuan_pembimbing.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-user-check"></i></div>
        <div class="stat-label">Total Peserta Magang</div>
        <div class="stat-value">{{ $stats['total_peserta'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Penentuan Pembimbing</div>
    </a>
    <a href="{{ route('admin.rekap_nilai.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
        <div class="stat-label">Rekap Nilai & Sertifikat</div>
        <div class="stat-value">{{ $stats['total_peserta'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Lihat & Cetak</div>
    </a>
    <a href="{{ route('admin.pembimbing.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-chalkboard-user"></i></div>
        <div class="stat-label">Total Pembimbing</div>
        <div class="stat-value">{{ $stats['total_pembimbing'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Kelola Pembimbing</div>
    </a>
    <a href="{{ route('admin.bidang.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
        <div class="stat-label">Total Bidang</div>
        <div class="stat-value">{{ $stats['total_bidang'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Kelola Bidang</div>
    </a>
</div>

<!-- Tables -->
<div class="table-container mb-4">
    <div class="table-toolbar">
        <h3><i class="fas fa-user-graduate"></i> Peserta Terbaru & Penempatan</h3>
        <div class="filter-tabs">
            <a href="{{ route('admin.penentuan_pembimbing.index') }}" style="text-decoration: none;"><span class="active">Kelola Penempatan</span></a>
        </div>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Nama Peserta</th>
                    <th>Instansi</th>
                    <th>Bidang</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peserta_terbaru as $p)
                <tr>
                    <td><strong>{{ $p->nama }}</strong></td>
                    <td>{{ $p->instansi?->nama ?? '-' }}</td>
                    <td>{{ $p->bidang?->nama ?? 'Belum Diatur' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4" style="color: #94a3b8;">Belum ada peserta.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Aksi Cepat -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-bolt"></i> Aksi Cepat Admin</h3>
    </div>
    <div class="stats-grid" style="padding: 1.5rem; margin-bottom: 0;">
        <a href="{{ route('admin.pembimbing.create') }}" class="stat-card" style="text-align: center; text-decoration: none;">
            <i class="fas fa-user-plus" style="font-size: 2rem; color: #2563eb; margin-bottom: 1rem;"></i>
            <div style="font-weight: 600; color: #1e293b;">Tambah Pembimbing</div>
        </a>
        <a href="{{ route('admin.penentuan_pembimbing.index') }}" class="stat-card" style="text-align: center; text-decoration: none;">
            <i class="fas fa-user-check" style="font-size: 2rem; color: #16a34a; margin-bottom: 1rem;"></i>
            <div style="font-weight: 600; color: #1e293b;">Penentuan Pembimbing</div>
        </a>
        <a href="{{ route('admin.bidang.create') }}" class="stat-card" style="text-align: center; text-decoration: none;">
            <i class="fas fa-layer-group" style="font-size: 2rem; color: #7c3aed; margin-bottom: 1rem;"></i>
            <div style="font-weight: 600; color: #1e293b;">Tambah Bidang</div>
        </a>
        <a href="{{ route('admin.instansi.create') }}" class="stat-card" style="text-align: center; text-decoration: none;">
            <i class="fas fa-building" style="font-size: 2rem; color: #d97706; margin-bottom: 1rem;"></i>
            <div style="font-weight: 600; color: #1e293b;">Tambah Instansi</div>
        </a>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/admin-dashboard.js') }}" defer></script>
@endpush
@endsection
