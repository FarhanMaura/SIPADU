@extends('layouts.adminlte')
@section('title', 'Kelola Instansi')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-building"></i> Kelola Instansi</h1>
        <p><i class="fas fa-chevron-right"></i> Master Data <i class="fas fa-chevron-right"></i> Instansi</p>
    </div>
    <a href="{{ route('admin.instansi.create') }}" class="action-button">
        <i class="fas fa-plus-circle"></i> Tambah Instansi
    </a>
</div>

<!-- Table Container -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Instansi Asal</h3>
        <form action="{{ route('admin.instansi.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari instansi..." onchange="this.form.submit()" />
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Nama Instansi</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Peserta Aktif</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($instansis as $instansi)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($instansis->currentPage() - 1) * $instansis->perPage() + $loop->iteration }}</td>
                    <td>
                        <strong style="color: #1e293b; display: block;">{{ $instansi->nama }}</strong>
                    </td>
                    <td>
                        <small style="color: #64748b; display: block; max-width: 250px;">{{ $instansi->alamat ?? 'Belum ada data alamat' }}</small>
                    </td>
                    <td>
                        <div style="font-size: 0.85rem; color: #475569;"><i class="fas fa-phone mr-1"></i> {{ $instansi->telp ?? '-' }}</div>
                        <div style="font-size: 0.85rem; color: #475569;"><i class="fas fa-envelope mr-1"></i> {{ $instansi->email ?? '-' }}</div>
                    </td>
                    <td>
                        <span class="badge-status approved">{{ $instansi->pesertas_count ?? 0 }} Peserta</span>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="{{ route('admin.instansi.edit', $instansi) }}" class="edit"><i class="fas fa-pen"></i> Edit</a>
                            <form action="{{ route('admin.instansi.destroy', $instansi) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete" onclick="return confirm('Yakin hapus instansi ini?')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-building fa-2x mb-3 text-muted"></i>
                        <p class="mb-0 font-weight-bold">Belum ada data instansi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span><i class="far fa-clock" style="margin-right: 6px;"></i> Terakhir diperbarui: {{ today()->translatedFormat('d F Y') }}</span>
        <div class="pagination">
            {{ $instansis->links() }}
        </div>
    </div>
</div>
@endsection
