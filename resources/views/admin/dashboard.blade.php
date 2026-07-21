@extends('layouts.adminlte')
@section('title', 'Admin Dashboard')

@section('content')
<!-- Header Greeting -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-chart-simple"></i> Selamat datang, {{ auth()->user()->name }}!</h1>
        <p><i class="fas fa-user-cog"></i> Administrator Sistem — Mengelola program magang, bidang, pembimbing, dan persetujuan instansi.</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <a href="{{ route('admin.pengajuan.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-label">Pengajuan Menunggu</div>
        <div class="stat-value">{{ $stats['pengajuan_pending'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Lihat Detail</div>
    </a>
    <a href="{{ route('admin.peserta.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-label">Total Peserta Magang</div>
        <div class="stat-value">{{ $stats['total_peserta'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Lihat Detail</div>
    </a>
    <a href="{{ route('admin.pengajuan.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-label">Pengajuan Disetujui</div>
        <div class="stat-value">{{ $stats['pengajuan_approved'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Lihat Detail</div>
    </a>
    <a href="{{ route('admin.pembimbing.index') }}" style="text-decoration: none;" class="stat-card">
        <div class="stat-icon"><i class="fas fa-chalkboard-user"></i></div>
        <div class="stat-label">Total Pembimbing</div>
        <div class="stat-value">{{ $stats['total_pembimbing'] }}</div>
        <div class="stat-link"><i class="fas fa-chevron-right"></i> Lihat Detail</div>
    </a>
</div>

<!-- Quick Actions & Tables -->
<div class="table-container mb-4">
    <div class="table-toolbar">
        <h3><i class="fas fa-file-alt"></i> Pengajuan Terbaru</h3>
        <div class="filter-tabs">
            <a href="{{ route('admin.pengajuan.index') }}" style="text-decoration: none;"><span class="active">Semua</span></a>
        </div>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Instansi</th>
                    <th>PIC</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan_terbaru as $p)
                <tr>
                    <td><strong>{{ $p->nama_instansi }}</strong></td>
                    <td>{{ $p->pic_nama }}</td>
                    <td>
                        @if($p->status === 'pending') <span class="badge-status pending">Menunggu</span>
                        @elseif($p->status === 'approved') <span class="badge-status approved">Disetujui</span>
                        @else <span class="badge-status rejected">Ditolak</span>
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

<div class="table-container mb-4">
    <div class="table-toolbar">
        <h3><i class="fas fa-user-graduate"></i> Peserta Terbaru</h3>
        <div class="filter-tabs">
            <a href="{{ route('admin.peserta.index') }}" style="text-decoration: none;"><span class="active">Semua</span></a>
        </div>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
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
        <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
    </div>
    <div class="stats-grid" style="padding: 1.5rem; margin-bottom: 0;">
        <a href="{{ route('admin.pembimbing.create') }}" class="stat-card" style="text-align: center; text-decoration: none;">
            <i class="fas fa-user-plus" style="font-size: 2rem; color: #2563eb; margin-bottom: 1rem;"></i>
            <div style="font-weight: 600; color: #1e293b;">Tambah Pembimbing</div>
        </a>
        <a href="{{ route('admin.peserta.create') }}" class="stat-card" style="text-align: center; text-decoration: none;">
            <i class="fas fa-user-graduate" style="font-size: 2rem; color: #16a34a; margin-bottom: 1rem;"></i>
            <div style="font-weight: 600; color: #1e293b;">Tambah Peserta</div>
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
