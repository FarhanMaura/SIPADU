@extends('layouts.adminlte')
@section('title', 'Kelola Bidang')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-tag"></i> Kelola Bidang</h1>
        <p><i class="fas fa-chevron-right"></i> Master Data <i class="fas fa-chevron-right"></i> Bidang</p>
    </div>
    <a href="{{ route('admin.bidang.create') }}" class="action-button">
        <i class="fas fa-plus-circle"></i> Tambah Bidang
    </a>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
        <div class="stat-label">Total Bidang</div>
        <div class="stat-value">{{ $bidangs->total() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-label">Total Peserta</div>
        <div class="stat-value">{{ \App\Models\Peserta::count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
        <div class="stat-label">Bidang Aktif</div>
        <div class="stat-value">{{ \App\Models\Bidang::whereHas('pesertas')->count() }}</div>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Bidang</h3>
        <!-- Search bar (GET request to filter) -->
        <form action="{{ route('admin.bidang.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bidang..." onchange="this.form.submit()" />
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="80">#</th>
                    <th>Nama Bidang</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Peserta</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bidangs as $bidang)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($bidangs->currentPage() - 1) * $bidangs->perPage() + $loop->iteration }}</td>
                    <td><strong>{{ $bidang->nama }}</strong></td>
                    <td>{{ $bidang->deskripsi ?? '-' }}</td>
                    <td>
                        <span class="badge-count {{ $bidang->pesertas_count == 0 ? 'zero' : ($bidang->pesertas_count >= 2 ? 'two' : '') }}">
                            {{ $bidang->pesertas_count }}
                        </span>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="{{ route('admin.bidang.edit', $bidang) }}" class="edit"><i class="fas fa-pen"></i> Edit</a>
                            <form action="{{ route('admin.bidang.destroy', $bidang) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete" onclick="return confirm('Yakin hapus bidang ini?')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-tags fa-2x mb-3 text-muted"></i>
                        <p class="mb-0 font-weight-bold">Belum ada data bidang.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span><i class="far fa-clock" style="margin-right: 6px;"></i> Terakhir diperbarui: {{ today()->translatedFormat('d F Y') }}</span>
        <div class="pagination">
            {{ $bidangs->links() }}
        </div>
    </div>
</div>
@endsection
