@extends('layouts.adminlte')
@section('title', 'Dashboard Peserta')

@section('content')
@if($peserta)

<!-- Header Greeting -->
<div class="page-header" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 2rem; border-radius: 24px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.3);">
            <i class="fas fa-user-graduate fa-2x" style="color: #F9DC5C"></i>
        </div>
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 700; margin-bottom: 0.3rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Selamat datang, {{ $peserta->nama }}!</h1>
            <p style="color: rgba(255, 255, 255, 0.9); font-size: 0.95rem; margin-bottom: 0; text-shadow: 0 1px 3px rgba(0,0,0,0.3);">{{ $peserta->jurusan ?? 'Peserta Magang' }} — {{ $peserta->instansi?->nama ?? '-' }}</p>
        </div>
    </div>
</div>

@if(!$peserta->bidang)
<div class="alert-toast alert-toast-danger mb-4">
    <i class="fas fa-exclamation-triangle"></i> Anda belum mendapatkan bidang penempatan. Hubungi admin/kasubbag.
</div>
@endif

<!-- Quick Callout to Absensi Page -->
<div class="table-container mb-4" style="border: 2px solid {{ $sudahAbsenHariIni ? '#86efac' : '#fcd34d' }}; border-radius: 20px;">
    <div style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="margin: 0 0 0.3rem 0; color: #0f172a;">
                <i class="fas fa-clipboard-check" style="color: {{ $sudahAbsenHariIni ? '#16a34a' : '#d97706' }}"></i>
                Presensi Hari Ini — {{ now()->translatedFormat('l, d F Y') }}
            </h3>
            <p style="margin: 0; color: #64748b;">
                @if($sudahAbsenHariIni)
                    Status: <strong style="color: #16a34a; text-transform: uppercase;">{{ $sudahAbsenHariIni->status }}</strong> (Sudah Mengisi Presensi)
                @else
                    Status: <strong style="color: #d97706;">Belum Mengisi Presensi Hari Ini</strong>
                @endif
            </p>
        </div>
        <a href="{{ route('peserta.absensi') }}" class="action-button" style="background: #2563eb; padding: 0.75rem 1.25rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-calendar-check"></i> Buka Halaman Absensi <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid" style="margin-top: 2rem;">
    <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='{{ route('peserta.absensi') }}'">
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-label">Total Hadir</div>
        <div class="stat-value">{{ $totalHadir }} <span style="font-size: 1rem; font-weight: 500; color: #64748b;">hari</span></div>
    </div>
    <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='{{ route('peserta.absensi') }}'">
        <div class="stat-icon"><i class="fas fa-info-circle"></i></div>
        <div class="stat-label">Total Izin</div>
        <div class="stat-value">{{ $totalIzin }} <span style="font-size: 1rem; font-weight: 500; color: #64748b;">hari</span></div>
    </div>
    <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='{{ route('peserta.absensi') }}'">
        <div class="stat-icon"><i class="fas fa-procedures"></i></div>
        <div class="stat-label">Total Sakit</div>
        <div class="stat-value">{{ $totalSakit }} <span style="font-size: 1rem; font-weight: 500; color: #64748b;">hari</span></div>
    </div>
    <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='{{ route('peserta.penilaian') }}'">
        <div class="stat-icon"><i class="fas fa-star"></i></div>
        <div class="stat-label">Penilaian</div>
        <div class="stat-value">{!! $nilai ? '<span style="font-size:1.2rem;color:#16a34a">Sudah Dinilai</span>' : '<span style="font-size:1.2rem;color:#d97706">Belum</span>' !!}</div>
    </div>
</div>

<!-- Absensi Terbaru -->
<div class="table-container mb-4">
    <div class="table-toolbar">
        <h3><i class="fas fa-clock"></i> Riwayat Absensi Terakhir</h3>
        <a href="{{ route('peserta.absensi') }}" class="action-button" style="padding: 0.4rem 1rem; font-size: 0.85rem;">Lihat Semua</a>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAbsensi as $absen)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>
                        @if($absen->status === 'hadir') <span class="badge-count">Hadir</span>
                        @elseif($absen->status === 'sakit') <span class="badge-count two">Sakit</span>
                        @elseif($absen->status === 'izin') <span class="badge-count two" style="background:#fef3c7; color:#d97706;">Izin</span>
                        @else <span class="badge-count zero">Alpa</span>
                        @endif
                    </td>
                    <td>{{ $absen->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada riwayat absensi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@else
<div class="page-header" style="background: white; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; justify-content: center; padding: 4rem 2rem;">
    <div>
        <i class="fas fa-clock fa-4x mb-4" style="color: #94a3b8;"></i>
        <h2 style="color: #1e293b; font-weight: 700;">Status: Pending</h2>
        <p style="color: #64748b; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Pengajuan Anda sedang diproses oleh admin/kasubbag. Silakan kembali lagi nanti untuk melihat status pendaftaran magang Anda.</p>
    </div>
</div>
@endif
@endsection
