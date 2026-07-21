@extends('layouts.adminlte')
@section('title', 'Kelola Pembimbing')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-chalkboard-teacher"></i> Kelola Pembimbing</h1>
        <p><i class="fas fa-chevron-right"></i> Master Data <i class="fas fa-chevron-right"></i> Pembimbing</p>
    </div>
    <a href="{{ route('admin.pembimbing.create') }}" class="action-button">
        <i class="fas fa-plus-circle"></i> Tambah Pembimbing
    </a>
</div>

<!-- Table Container -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Pembimbing</h3>
        <form action="{{ route('admin.pembimbing.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pembimbing..." onchange="this.form.submit()" />
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Nama & NIP</th>
                    <th>Bidang Penempatan</th>
                    <th>Kontak</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembimbings as $p)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($pembimbings->currentPage() - 1) * $pembimbings->perPage() + $loop->iteration }}</td>
                    <td>
                        <strong style="color: #1e293b; display: block;">{{ $p->nama }}</strong>
                        <small style="color: #64748b;">NIP. {{ $p->nip ?? '-' }}</small>
                    </td>
                    <td>
                        @if($p->bidang)
                            <span class="badge-status approved">{{ $p->bidang->nama }}</span>
                        @else
                            <span class="badge-status pending">Belum Ditugaskan</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size: 0.85rem; color: #475569;"><i class="fas fa-phone mr-1"></i> {{ $p->no_hp ?? '-' }}</div>
                        <div style="font-size: 0.85rem; color: #475569;"><i class="fas fa-envelope mr-1"></i> {{ $p->user?->email ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="{{ route('admin.pembimbing.edit', $p) }}" class="edit"><i class="fas fa-pen"></i> Edit</a>
                            <form action="{{ route('admin.pembimbing.destroy', $p) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete" onclick="return confirm('Yakin hapus pembimbing ini?')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-chalkboard-teacher fa-2x mb-3 text-muted"></i>
                        <p class="mb-0 font-weight-bold">Belum ada data pembimbing.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span><i class="far fa-clock" style="margin-right: 6px;"></i> Terakhir diperbarui: {{ today()->translatedFormat('d F Y') }}</span>
        <div class="pagination">
            {{ $pembimbings->links() }}
        </div>
    </div>
</div>
@endsection
