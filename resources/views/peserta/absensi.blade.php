@extends('layouts.adminlte')
@section('title', 'Presensi / Absensi Harian')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-calendar-check"></i> Presensi / Absensi Harian</h1>
        <p>Isi presensi harian magang Anda dan lihat riwayat kehadiran.</p>
    </div>
</div>

<!-- Form Absensi Hari Ini -->
<div class="table-container mb-4" style="border: 2px solid {{ $sudahAbsenHariIni ? '#86efac' : '#fcd34d' }}; border-radius: 20px;">
    <div class="table-toolbar" style="background: {{ $sudahAbsenHariIni ? '#f0fdf4' : '#fffbeb' }}; padding: 1.5rem; border-bottom: 1px solid {{ $sudahAbsenHariIni ? '#bbf7d0' : '#fde68a' }};">
        <h3 style="margin: 0; color: #0f172a;">
            <i class="fas fa-edit" style="color: {{ $sudahAbsenHariIni ? '#16a34a' : '#d97706' }}"></i>
            Input Presensi Hari Ini — {{ now()->translatedFormat('l, d F Y') }}
        </h3>
    </div>
    <div style="padding: 1.5rem;">
        @if($sudahAbsenHariIni)
            <!-- Sudah absen -->
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div>
                    @if($sudahAbsenHariIni->status === 'hadir')
                        <span class="badge-count" style="font-size: 1.1rem; padding: 0.4rem 1rem;"><i class="fas fa-check-circle mr-1"></i> HADIR</span>
                    @elseif($sudahAbsenHariIni->status === 'izin')
                        <span class="badge-count two" style="font-size: 1.1rem; padding: 0.4rem 1rem; background: #fef3c7; color: #d97706;"><i class="fas fa-info-circle mr-1"></i> IZIN</span>
                    @elseif($sudahAbsenHariIni->status === 'sakit')
                        <span class="badge-count two" style="font-size: 1.1rem; padding: 0.4rem 1rem;"><i class="fas fa-procedures mr-1"></i> SAKIT</span>
                    @endif
                </div>
                <div>
                    <strong style="font-size: 1.1rem;">Anda sudah mengisi presensi hari ini.</strong>
                    @if($sudahAbsenHariIni->keterangan)
                    <br><small style="color: #64748b;">Keterangan: {{ $sudahAbsenHariIni->keterangan }}</small>
                    @endif
                </div>
            </div>
        @else
            <!-- Form Input Presensi -->
            <form action="{{ route('peserta.absensi.self') }}" method="POST" id="form-absen">
                @csrf
                <div style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px;">
                        <label style="font-weight: 600; margin-bottom: 0.5rem; display: block;">Status Kehadiran <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required onchange="toggleKeterangan(this.value)" style="border-radius: 12px; padding: 0.75rem 1rem; border-color: #cbd5e1;">
                            <option value="hadir">✅ Hadir</option>
                            <option value="izin">📋 Izin</option>
                            <option value="sakit">🤒 Sakit</option>
                        </select>
                    </div>
                    <div id="div-keterangan" style="flex: 2; display: none; min-width: 250px;">
                        <label style="font-weight: 600; margin-bottom: 0.5rem; display: block;">Keterangan / Alasan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Tuliskan keterangan izin atau sakit..." style="border-radius: 12px; padding: 0.75rem 1rem; border-color: #cbd5e1;">
                    </div>
                    <div>
                        <button type="submit" class="action-button" style="background: #16a34a; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.2); border: none; padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; font-size: 1rem; cursor: pointer; color: white; display: flex; gap: 0.5rem; align-items: center;">
                            <i class="fas fa-paper-plane"></i> Kirim Presensi
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<!-- Tabel Riwayat Absensi -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Riwayat Kehadiran Magang</h3>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600; color: #0f172a;">{{ $a->tanggal?->format('d/m/Y') }}</td>
                    <td>
                        @if($a->status === 'hadir') <span class="badge-count">Hadir</span>
                        @elseif($a->status === 'izin') <span class="badge-count two" style="background:#fef3c7; color:#d97706;">Izin</span>
                        @elseif($a->status === 'sakit') <span class="badge-count two">Sakit</span>
                        @else <span class="badge-count zero">Alpa</span>
                        @endif
                    </td>
                    <td>{{ $a->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4" style="color: #94a3b8; text-align: center;">Belum ada data absensi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($absensis, 'links') && $absensis->hasPages())
    <div class="table-footer">
        {{ $absensis->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function toggleKeterangan(val) {
        let divKet = document.getElementById('div-keterangan');
        if (val === 'izin' || val === 'sakit') {
            divKet.style.display = 'block';
        } else {
            divKet.style.display = 'none';
        }
    }
</script>
@endpush
