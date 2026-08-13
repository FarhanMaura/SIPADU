@extends('layouts.adminlte')
@section('title', 'Rekap Nilai & Sertifikat')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-file-invoice"></i> Rekap Nilai & Cetak Sertifikat Magang</h1>
        <p><i class="fas fa-chevron-right"></i> Admin <i class="fas fa-chevron-right"></i> Rekap Nilai & Sertifikat</p>
    </div>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-award"></i> Rekapitulasi Evaluasi Akhir Peserta</h3>
        <form action="{{ route('admin.rekap_nilai.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/instansi..." onchange="this.form.submit()" />
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nama Peserta</th>
                    <th>Instansi & Bidang</th>
                    <th>Pembimbing</th>
                    <th>Nilai Akhir</th>
                    <th>Status Penilaian</th>
                    <th width="240">Cetak PDF Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $peserta)
                @php $penilaian = $peserta->penilaian; @endphp
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($pesertas->currentPage() - 1) * $pesertas->perPage() + $loop->iteration }}</td>
                    <td>
                        <strong style="color: #1e293b; display: block;">{{ $peserta->nama }}</strong>
                        <small style="color: #64748b;">NIM/NISN: {{ $peserta->nim_nisn ?? '-' }}</small>
                    </td>
                    <td>
                        <strong style="color: #0f172a;">{{ $peserta->instansi->nama ?? '-' }}</strong><br>
                        <small style="color: #64748b;">Bidang: {{ $peserta->bidang->nama ?? '-' }}</small>
                    </td>
                    <td>
                        <strong style="color: #334155;">{{ $peserta->pembimbing->nama ?? '-' }}</strong>
                    </td>
                    <td>
                        @if($penilaian)
                            <strong style="font-size: 1.1rem; color: #15803d;">{{ $penilaian->nilai_angka }}</strong>
                            <span class="badge-status approved" style="font-size: 0.75rem; margin-left: 4px;">{{ $penilaian->predikat ?? 'A' }}</span>
                        @else
                            <span style="color: #94a3b8; font-size: 0.85rem;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($penilaian)
                            <span class="badge-status approved"><i class="fas fa-check-circle mr-1"></i> Selesai Dinilai</span>
                        @else
                            <span class="badge-status pending"><i class="fas fa-clock mr-1"></i> Belum Dinilai</span>
                        @endif
                    </td>
                    <td>
                        @if($penilaian)
                            <div style="display: flex; gap: 0.3rem; flex-wrap: wrap;">
                                <a href="{{ route('admin.rekap_nilai.pdf', $peserta) }}" class="edit" style="background: #e0f2fe; color: #0284c7; padding: 0.35rem 0.6rem; font-size: 0.8rem;" title="Download PDF Daftar Nilai">
                                    <i class="fas fa-file-pdf"></i> Daftar Nilai
                                </a>
                                <a href="{{ route('admin.rekap_nilai.sertifikat', $peserta) }}" class="edit" style="background: #fef3c7; color: #b45309; padding: 0.35rem 0.6rem; font-size: 0.8rem;" title="Download PDF Sertifikat">
                                    <i class="fas fa-certificate"></i> Sertifikat
                                </a>
                            </div>
                        @else
                            <span style="font-size: 0.8rem; color: #94a3b8;"><i class="fas fa-lock mr-1"></i> Penilaian Belum Tersedia</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-folder-open fa-2x mb-3 text-muted"></i>
                        <p class="mb-0 font-weight-bold">Belum ada data peserta magang.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span><i class="far fa-clock" style="margin-right: 6px;"></i> Terakhir diperbarui: {{ today()->translatedFormat('d F Y') }}</span>
        {{ $pesertas->links() }}
    </div>
</div>
@endsection
