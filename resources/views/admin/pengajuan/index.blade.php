@extends('layouts.adminlte')
@section('title', 'Pengajuan Magang')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-file-signature"></i> Kelola Pengajuan Magang</h1>
        <p><i class="fas fa-chevron-right"></i> Manajemen Magang <i class="fas fa-chevron-right"></i> Pengajuan</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-hourglass-start"></i></div>
        <div class="stat-label">Menunggu Tinjauan</div>
        <div class="stat-value">{{ $pengajuans->where('status', 'pending')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-label">Telah Disetujui</div>
        <div class="stat-value">{{ $pengajuans->where('status', 'approved')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
        <div class="stat-label">Telah Ditolak</div>
        <div class="stat-value">{{ $pengajuans->where('status', 'rejected')->count() }}</div>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Berkas Pengajuan Masuk</h3>
        <div class="filter-tabs">
            <span class="active">Semua</span>
        </div>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nama Peserta & Kontak</th>
                    <th>Sekolah / Kampus & Jurusan</th>
                    <th>Periode & Berkas</th>
                    <th>Status</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $p)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($pengajuans->currentPage() - 1) * $pengajuans->perPage() + $loop->iteration }}</td>
                    <td>
                        <strong style="color: #1e293b; display: block; font-size: 0.95rem;">{{ $p->pic_nama }}</strong>
                        @if($p->nim_nisn)<small style="color: #475569; font-weight: 600; display: block;"><i class="fas fa-id-card mr-1"></i> {{ $p->nim_nisn }}</small>@endif
                        <small style="color: #64748b; display: block;"><i class="fas fa-phone mr-1"></i> {{ $p->pic_telp }}</small>
                        <small style="color: #64748b; display: block;"><i class="fas fa-envelope mr-1"></i> {{ $p->pic_email }}</small>
                    </td>
                    <td>
                        <strong style="color: #1e293b; display: block;">{{ $p->nama_instansi }}</strong>
                        @if($p->jurusan)<small style="color: #0284c7; font-weight: 500; display: block;">{{ $p->jurusan }} ({{ $p->jenis_peserta ?? 'Peserta' }})</small>@endif
                        <small style="color: #94a3b8;"><i class="far fa-calendar-alt"></i> Diajukan: {{ $p->created_at?->format('d/m/Y') }}</small>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #1e293b; font-size: 0.85rem;"><i class="far fa-clock mr-1 text-primary"></i> {{ $p->tgl_mulai?->format('d M') ?? '-' }} - {{ $p->tgl_selesai?->format('d M Y') ?? '-' }}</div>
                        <div style="font-size: 0.85rem; color: #64748b; margin-top: 2px;"><i class="fas fa-users mr-1 text-success"></i> {{ $p->jml_peserta }} Peserta</div>
                        <div style="margin-top: 4px; display: flex; gap: 4px; flex-wrap: wrap;">
                            @if($p->file_surat)
                                <a href="{{ route('kasubbag.pengajuan.file', ['pengajuan' => $p->id, 'type' => 'surat']) }}" target="_blank" class="badge bg-light text-dark" title="Lihat Surat Permohonan"><i class="fas fa-file-pdf text-danger"></i> Surat</a>
                            @endif
                            @if($p->file_transkrip)
                                <a href="{{ route('kasubbag.pengajuan.file', ['pengajuan' => $p->id, 'type' => 'transkrip']) }}" target="_blank" class="badge bg-light text-dark" title="Lihat Transkrip Nilai"><i class="fas fa-file-alt text-primary"></i> Transkrip</a>
                            @endif
                            @if($p->file_surat_pernyataan)
                                <a href="{{ route('kasubbag.pengajuan.file', ['pengajuan' => $p->id, 'type' => 'surat_pernyataan']) }}" target="_blank" class="badge bg-light text-dark" title="Lihat Surat Pernyataan"><i class="fas fa-file-signature text-info"></i> Pernyataan</a>
                            @endif
                            @if($p->file_peserta)
                                <a href="{{ route('kasubbag.pengajuan.file', ['pengajuan' => $p->id, 'type' => 'peserta']) }}" target="_blank" class="badge bg-light text-dark" title="Lihat Daftar Peserta"><i class="fas fa-file-excel text-success"></i> Excel</a>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($p->status === 'pending')
                            <span class="badge-status pending">Menunggu</span>
                        @elseif($p->status === 'approved')
                            <span class="badge-status approved">Disetujui</span>
                        @else
                            <span class="badge-status rejected">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($p->status === 'pending')
                        <div class="action-icons">
                            <form action="{{ route('admin.pengajuan.approve', $p) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="edit" style="background: #f0fdf4; color: #16a34a;" onclick="return confirm('Setujui pengajuan ini?')">
                                    <i class="fas fa-check"></i> Terima
                                </button>
                            </form>
                            <form action="{{ route('admin.pengajuan.reject', $p) }}" method="POST" class="d-inline" id="form-reject-{{ $p->id }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="keterangan_reject" id="keterangan_reject_{{ $p->id }}">
                                <input type="hidden" name="rekomendasi_instansi" id="rekomendasi_instansi_{{ $p->id }}">
                                <button type="button" class="delete" style="background: #fef2f2; color: #dc2626;" onclick="rejectPengajuan({{ $p->id }})">
                                    <i class="fas fa-times"></i> Tolak / Alihkan
                                </button>
                            </form>
                        </div>
                        @else
                            <span style="font-size: 0.8rem; color: #94a3b8;"><i class="fas fa-lock mr-1"></i> Status Final</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-folder-open fa-2x mb-3 text-muted"></i>
                        <p class="mb-0 font-weight-bold">Belum ada pengajuan masuk.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span><i class="far fa-clock" style="margin-right: 6px;"></i> Terakhir diperbarui: {{ today()->translatedFormat('d F Y') }}</span>
        <div class="pagination">
            {{ $pengajuans->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function rejectPengajuan(id) {
        let alasan = prompt('Masukkan alasan penolakan / ketidaksesuaian jurusan (mis. "Jurusan tidak sesuai kebutuhan Dinas Pendidikan"):');
        if (alasan === null) {
            return;
        }
        if (alasan.trim() === '') {
            alert('Alasan penolakan wajib diisi!');
            return;
        }
        
        let rekomendasi = prompt('Bila dialihkan ke instansi lain, masukkan nama instansi rekomendasi (mis. "Dinas Pariwisata Provinsi Sumsel") atau kosongkan:');
        
        document.getElementById('keterangan_reject_' + id).value = alasan;
        if (rekomendasi && rekomendasi.trim() !== '') {
            document.getElementById('rekomendasi_instansi_' + id).value = rekomendasi.trim();
        }
        document.getElementById('form-reject-' + id).submit();
    }
</script>
@endpush
