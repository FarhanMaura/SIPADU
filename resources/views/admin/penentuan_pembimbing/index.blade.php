@extends('layouts.adminlte')
@section('title', 'Penentuan Pembimbing & Bidang')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-check"></i> Penentuan Pembimbing & Bidang Penempatan</h1>
        <p><i class="fas fa-chevron-right"></i> Admin <i class="fas fa-chevron-right"></i> Penentuan Pembimbing</p>
    </div>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Peserta Magang & Penempatan Pembimbing</h3>
        <form action="{{ route('admin.penentuan_pembimbing.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peserta/instansi..." onchange="this.form.submit()" />
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nama Peserta</th>
                    <th>Instansi & Jurusan</th>
                    <th>Bidang Penempatan</th>
                    <th>Pembimbing Lapangan</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $peserta)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">{{ ($pesertas->currentPage() - 1) * $pesertas->perPage() + $loop->iteration }}</td>
                    <td>
                        <strong style="color: #1e293b; display: block;">{{ $peserta->nama }}</strong>
                        <small style="color: #64748b;">NIM/NISN: {{ $peserta->nim_nisn ?? '-' }}</small>
                    </td>
                    <td>
                        <strong style="color: #0f172a;">{{ $peserta->instansi->nama ?? '-' }}</strong><br>
                        <small style="color: #64748b;">{{ $peserta->jurusan ?? '-' }}</small>
                    </td>
                    <form action="{{ route('admin.penentuan_pembimbing.update', $peserta) }}" method="POST">
                        @csrf @method('PATCH')
                        <td>
                            <select name="bidang_id" class="form-control" style="border-radius: 8px; font-size: 0.85rem; padding: 0.4rem 0.6rem;">
                                <option value="">-- Pilih Bidang --</option>
                                @foreach($bidangs as $b)
                                    <option value="{{ $b->id }}" {{ $peserta->bidang_id == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="pembimbing_id" class="form-control" style="border-radius: 8px; font-size: 0.85rem; padding: 0.4rem 0.6rem;">
                                <option value="">-- Pilih Pembimbing --</option>
                                @foreach($pembimbings as $pb)
                                    <option value="{{ $pb->id }}" {{ $peserta->pembimbing_id == $pb->id ? 'selected' : '' }}>{{ $pb->nama }} ({{ $pb->bidang?->nama ?? '-' }})</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="action-button" style="background: #16a34a; padding: 0.4rem 0.8rem; font-size: 0.85rem; border: none; box-shadow: none;">
                                <i class="fas fa-check"></i> Simpan
                            </button>
                        </td>
                    </form>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-user-slash fa-2x mb-3 text-muted"></i>
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
