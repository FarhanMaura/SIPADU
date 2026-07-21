@extends('layouts.adminlte')
@section('title', 'Dashboard Pembimbing')

@section('content')
<!-- Header Greeting -->
<div class="page-header" style="background: linear-gradient(135deg, #20a4b0 0%, #178892 100%); color: white; padding: 2rem; border-radius: 24px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; box-shadow: 0 4px 20px rgba(32, 164, 176, 0.15);">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
            <i class="fas fa-chalkboard-teacher fa-2x" style="color: #F9DC5C"></i>
        </div>
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 700; margin-bottom: 0.3rem;">Selamat datang, {{ auth()->user()->name }}!</h1>
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin-bottom: 0;">Pembimbing Magang — Bidang: <strong>{{ $pembimbing?->bidang?->nama ?? 'Belum ditentukan' }}</strong></p>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='{{ route('pembimbing.peserta.index') }}'">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-label">Peserta Bimbingan</div>
        <div class="stat-value">{{ $stats['total_peserta'] }} <span style="font-size: 1rem; font-weight: 500; color: #64748b;">orang</span></div>
    </div>
    <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='{{ route('pembimbing.absensi.index') }}'">
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-label">Hadir Hari Ini</div>
        <div class="stat-value">{{ $stats['hadir_hari_ini'] }} <span style="font-size: 1rem; font-weight: 500; color: #64748b;">orang</span></div>
    </div>
    <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='{{ route('pembimbing.penilaian.index') }}'">
        <div class="stat-icon"><i class="fas fa-star"></i></div>
        <div class="stat-label">Sudah Dinilai</div>
        <div class="stat-value">{{ $stats['sudah_dinilai'] }} <span style="font-size: 1rem; font-weight: 500; color: #64748b;">peserta</span></div>
    </div>
    <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='{{ route('pembimbing.penilaian.create') }}'">
        <div class="stat-icon"><i class="fas fa-star-half-alt"></i></div>
        <div class="stat-label">Belum Dinilai</div>
        <div class="stat-value">{{ $stats['belum_dinilai'] }} <span style="font-size: 1rem; font-weight: 500; color: #64748b;">peserta</span></div>
    </div>
</div>

<!-- Quick Actions & Tables -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Daftar Peserta -->
    <div class="table-container" style="margin-bottom: 0;">
        <div class="table-toolbar">
            <h3><i class="fas fa-users"></i> Peserta Bimbingan Saya</h3>
            <a href="{{ route('pembimbing.peserta.index') }}" class="action-button" style="padding: 0.4rem 1rem; font-size: 0.85rem;">Lihat Semua</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Instansi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesertas as $p)
                    <tr>
                        <td style="font-weight: 600; color: #0f172a;">{{ $p->nama }}</td>
                        <td>{{ $p->jurusan ?? '-' }}</td>
                        <td>{{ $p->instansi?->nama ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada peserta bimbingan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Absensi Terbaru -->
    <div class="table-container" style="margin-bottom: 0;">
        <div class="table-toolbar">
            <h3><i class="fas fa-calendar-alt"></i> Absensi Terbaru</h3>
            <a href="{{ route('pembimbing.absensi.create') }}" class="action-button" style="padding: 0.4rem 1rem; font-size: 0.85rem; background: #16a34a; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.2);">
                <i class="fas fa-plus"></i> Input
            </a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Peserta</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi_terbaru as $absen)
                    <tr>
                        <td style="font-weight: 600; color: #0f172a;">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') }}</td>
                        <td>{{ $absen->peserta->nama }}</td>
                        <td>
                            @if($absen->status === 'hadir') <span class="badge-count">Hadir</span>
                            @elseif($absen->status === 'sakit') <span class="badge-count two">Sakit</span>
                            @elseif($absen->status === 'izin') <span class="badge-count two" style="background:#fef3c7; color:#d97706;">Izin</span>
                            @else <span class="badge-count zero">Alpa</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada data absensi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
