@extends('layouts.adminlte')
@section('title', 'Verifikasi Pengajuan Magang')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-file-signature"></i> Verifikasi Pengajuan Magang & LoA</h1>
        <p><i class="fas fa-chevron-right"></i> Kasubbag <i class="fas fa-chevron-right"></i> Pengajuan Magang</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-hourglass-start"></i></div>
        <div class="stat-label">Menunggu Review</div>
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
        <form action="{{ route('kasubbag.pengajuan.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
            <input type="text" name="search" class="form-control" placeholder="Cari instansi / PIC..." value="{{ request('search') }}" style="border-radius: 8px; padding: 0.4rem 0.8rem;">
            <button type="submit" class="action-button" style="padding: 0.4rem 0.8rem;"><i class="fas fa-search"></i></button>
        </form>
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
                    <th width="220">Aksi & LoA</th>
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
                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                            <a href="{{ route('kasubbag.pengajuan.show', $p) }}" class="edit" style="background: #e0f2fe; color: #0369a1; padding: 0.35rem 0.6rem;" title="Detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($p->status === 'approved')
                                <a href="{{ route('kasubbag.pengajuan.loa', $p) }}" class="edit" style="background: #dcfce7; color: #15803d; padding: 0.35rem 0.6rem;" title="Cetak LoA">
                                    <i class="fas fa-file-pdf"></i> LoA PDF
                                </a>
                            @endif
                        </div>
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
