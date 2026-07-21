@extends('layouts.adminlte')
@section('title', 'Data Peserta')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-graduate"></i> Kelola Peserta Magang</h1>
        <p><i class="fas fa-chevron-right"></i> Manajemen Magang <i class="fas fa-chevron-right"></i> Peserta</p>
    </div>
    <div>
        <a href="{{ route('admin.peserta.create') }}" class="action-button">
            <i class="fas fa-plus-circle"></i> Tambah Peserta
        </a>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-label">Total Peserta</div>
        <div class="stat-value">{{ $pesertas->total() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-check-double"></i></div>
        <div class="stat-label">Ditempatkan</div>
        <div class="stat-value">{{ $pesertas->whereNotNull('bidang_id')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-user-slash"></i></div>
        <div class="stat-label">Belum Ditempatkan</div>
        <div class="stat-value">{{ $pesertas->whereNull('bidang_id')->count() }}</div>
    </div>
    <div class="stat-card" style="cursor: pointer;" onclick="var el = document.getElementById('import-form'); el.style.display = el.style.display === 'none' ? 'block' : 'none';">
        <div class="stat-icon"><i class="fas fa-file-excel"></i></div>
        <div class="stat-label">Import Excel</div>
        <div class="stat-value" style="font-size: 1.2rem; margin-top:1rem; color: #16a34a;">Klik Disini</div>
    </div>
</div>

<!-- Import Form (Hidden by default) -->
<div id="import-form" class="table-container" style="display: none; padding: 1.5rem; margin-bottom: 1.5rem; background: #f0fdf4; border-color: #bbf7d0;">
    <h5 style="font-weight: 700; color: #166534; margin-bottom: 1rem; margin-top: 0; font-size: 1.1rem;"><i class="fas fa-file-excel"></i> Import Data Peserta</h5>
    <form action="{{ route('admin.peserta.import') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; align-items: center; gap: 1rem;">
        @csrf
        <select name="pengajuan_id" required style="border-radius: 12px; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; background: white; max-width: 250px;">
            <option value="">-- Pilih Pengajuan --</option>
            @foreach($pengajuans as $pj)
                <option value="{{ $pj->id }}">{{ $pj->nama_instansi }} ({{ $pj->tgl_mulai?->format('d/m/Y') }})</option>
            @endforeach
        </select>
        <input type="file" name="file_peserta" accept=".xlsx,.xls" required style="max-width: 300px; border-radius: 12px; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; background: white;">
        <button type="submit" class="action-button" style="background: #16a34a; box-shadow: none; padding: 0.6rem 1.5rem; border: none; cursor: pointer; color: white;"><i class="fas fa-upload"></i> Upload</button>
    </form>
    <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #64748b;">Format file harus .xlsx atau .xls</div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Peserta Magang</h3>
        <form action="{{ route('admin.peserta.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/instansi..." onchange="this.form.submit()" />
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nama Lengkap</th>
                    <th>Instansi Asal &amp; Jurusan</th>
                    <th>Jenis &amp; Bidang</th>
                    <th>Periode Magang</th>
                    <th>Status</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $peserta)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($pesertas->currentPage() - 1) * $pesertas->perPage() + $loop->iteration }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.8rem;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                {{ strtoupper(substr($peserta->nama, 0, 1)) }}
                            </div>
                            <div>
                                <strong style="display: block; color: #1e293b;">{{ $peserta->nama }}</strong>
                                <small style="color: #64748b;">{{ $peserta->nim_nisn ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong style="color: #0f172a;">{{ $peserta->instansi->nama ?? '-' }}</strong><br>
                        <small style="color: #64748b;">{{ $peserta->jurusan ?? '-' }}</small>
                    </td>
                    <td>
                        @if($peserta->jenis_peserta)
                            <span class="badge-status {{ $peserta->jenis_peserta === 'Mahasiswa' ? 'approved' : 'pending' }}" style="margin-bottom: 4px; display: inline-block;">
                                {{ $peserta->jenis_peserta }}
                            </span><br>
                        @endif
                        @if($peserta->bidang)
                            <div style="font-size: 0.8rem; color: #1e293b;"><i class="fas fa-building mr-1 text-primary"></i> {{ $peserta->bidang->nama }}</div>
                        @else
                            <span class="badge-status pending" style="font-size: 0.75rem;">Belum Ditempatkan</span>
                        @endif
                    </td>
                    <td>
                        @if($peserta->tgl_mulai)
                            <small style="color: #0f172a;"><i class="fas fa-calendar-alt mr-1 text-success"></i> {{ $peserta->tgl_mulai->format('d/m/Y') }}</small><br>
                            <small style="color: #64748b;"><i class="fas fa-calendar-check mr-1 text-danger"></i> {{ $peserta->tgl_selesai?->format('d/m/Y') ?? '?' }}</small>
                        @else
                            <span style="color: #94a3b8; font-size: 0.85rem;">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-status {{ $peserta->status === 'aktif' ? 'approved' : ($peserta->status === 'selesai' ? 'pending' : 'rejected') }}">
                            {{ ucfirst($peserta->status ?? 'aktif') }}
                        </span>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="{{ route('admin.peserta.penempatan', $peserta) }}" class="edit" style="background: #f0fdf4; color: #16a34a;"><i class="fas fa-map-marker-alt"></i> Seting</a>
                            <a href="{{ route('admin.peserta.edit', $peserta) }}" class="edit"><i class="fas fa-pen"></i></a>
                            <form action="{{ route('admin.peserta.destroy', $peserta) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete" onclick="return confirm('Yakin hapus peserta ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-users-slash fa-2x mb-3 text-muted"></i>
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
