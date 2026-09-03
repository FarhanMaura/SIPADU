@extends('layouts.adminlte')
@section('title', 'Peserta Magang')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-graduate"></i> Kelola Peserta Magang</h1>
        <p><i class="fas fa-chevron-right"></i> Master Data <i class="fas fa-chevron-right"></i> Peserta Magang</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.peserta.create') }}" class="action-button">
            <i class="fas fa-plus-circle"></i> Tambah Peserta
        </a>
    </div>
</div>

<!-- Stats Ringkasan Status Magang -->
<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="stat-card" style="border-left: 4px solid #3b82f6;">
        <div class="stat-icon" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-users"></i></div>
        <div class="stat-label">Total Peserta</div>
        <div class="stat-value">{{ $totalPeserta }}</div>
    </div>
    <div class="stat-card" style="border-left: 4px solid #10b981; cursor: pointer;" onclick="window.location.href='{{ route('admin.peserta.index', array_merge(request()->except('status', 'page'), ['status' => 'aktif'])) }}'">
        <div class="stat-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-user-clock"></i></div>
        <div class="stat-label">Sedang Magang</div>
        <div class="stat-value" style="color: #059669;">{{ $totalAktif }}</div>
    </div>
    <div class="stat-card" style="border-left: 4px solid #64748b; cursor: pointer;" onclick="window.location.href='{{ route('admin.peserta.index', array_merge(request()->except('status', 'page'), ['status' => 'selesai'])) }}'">
        <div class="stat-icon" style="background: #f1f5f9; color: #475569;"><i class="fas fa-user-check"></i></div>
        <div class="stat-label">Selesai Magang</div>
        <div class="stat-value" style="color: #334155;">{{ $totalSelesai }}</div>
    </div>
    <div class="stat-card" style="border-left: 4px solid #8b5cf6;">
        <div class="stat-icon" style="background: #f5f3ff; color: #8b5cf6;"><i class="fas fa-university"></i></div>
        <div class="stat-label">Total Instansi Asal</div>
        <div class="stat-value">{{ $totalInstansi }}</div>
    </div>
</div>

<!-- Filter Box -->
<div class="table-container" style="padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <form action="{{ route('admin.peserta.index') }}" method="GET">
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
            <!-- Filter Instansi -->
            <div style="flex: 1; min-width: 220px;">
                <label style="font-size: 0.8rem; font-weight: 700; color: #475569; margin-bottom: 0.4rem; display: block;">
                    <i class="fas fa-university text-primary mr-1"></i> Dari Instansi Mana:
                </label>
                <select name="instansi_id" class="form-control" onchange="this.form.submit()" style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.9rem;">
                    <option value="">-- Semua Instansi Asal --</option>
                    @foreach($instansis as $ins)
                        <option value="{{ $ins->id }}" {{ request('instansi_id') == $ins->id ? 'selected' : '' }}>
                            {{ $ins->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status Magang -->
            <div style="flex: 1; min-width: 180px;">
                <label style="font-size: 0.8rem; font-weight: 700; color: #475569; margin-bottom: 0.4rem; display: block;">
                    <i class="fas fa-toggle-on text-primary mr-1"></i> Status Magang:
                </label>
                <select name="status" class="form-control" onchange="this.form.submit()" style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.9rem;">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>🟢 Sedang Magang</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>⚪ Selesai Magang</option>
                </select>
            </div>

            <!-- Input Pencarian -->
            <div style="flex: 1.5; min-width: 240px;">
                <label style="font-size: 0.8rem; font-weight: 700; color: #475569; margin-bottom: 0.4rem; display: block;">
                    <i class="fas fa-search text-primary mr-1"></i> Cari Nama / NIM / Jurusan:
                </label>
                <div style="position: relative;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci lalu Enter..." class="form-control" style="border-radius: 8px; border: 1px solid #cbd5e1; padding-left: 2.2rem; font-size: 0.9rem;">
                    <i class="fas fa-search" style="position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                </div>
            </div>

            <!-- Tombol Aksi Filter -->
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="action-button" style="padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; cursor: pointer; border: none;">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                @if(request('instansi_id') || request('status') || request('search'))
                    <a href="{{ route('admin.peserta.index') }}" class="action-button" style="background: #f1f5f9; color: #475569; box-shadow: none; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-times mr-1"></i> Reset
                    </a>
                @endif
            </div>
        </div>

        <!-- Info Active Filters -->
        @if(request('instansi_id') || request('status') || request('search'))
            <div style="margin-top: 1rem; padding-top: 0.75rem; border-top: 1px dashed #e2e8f0; display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; font-size: 0.85rem; color: #64748b;">
                <strong style="color: #1e293b;">Filter Aktif:</strong>
                @if(request('instansi_id'))
                    @php $filteredIns = $instansis->firstWhere('id', request('instansi_id')); @endphp
                    <span style="background: #eff6ff; color: #1d4ed8; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                        Instansi: {{ $filteredIns?->nama ?? request('instansi_id') }}
                    </span>
                @endif
                @if(request('status'))
                    <span style="background: {{ request('status') === 'aktif' ? '#ecfdf5' : '#f1f5f9' }}; color: {{ request('status') === 'aktif' ? '#047857' : '#334155' }}; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                        Status: {{ request('status') === 'aktif' ? 'Sedang Magang' : 'Selesai Magang' }}
                    </span>
                @endif
                @if(request('search'))
                    <span style="background: #fef3c7; color: #92400e; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                        Cari: "{{ request('search') }}"
                    </span>
                @endif
                <span style="margin-left: auto; color: #059669; font-weight: 600;">
                    Ditemukan: {{ $pesertas->total() }} peserta
                </span>
            </div>
        @endif
    </form>
</div>

<!-- Table Container -->
<div class="table-container">
    <div class="table-toolbar">
        <h3>
            <i class="fas fa-list-ul"></i> Daftar Peserta Magang
            <span style="font-size: 0.85rem; font-weight: normal; color: #64748b; margin-left: 0.5rem;">(Total {{ $pesertas->total() }})</span>
        </h3>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nama Peserta Magang</th>
                    <th>Asal Instansi &amp; Jurusan</th>
                    <th>Penempatan Bidang &amp; Pembimbing</th>
                    <th>Periode Magang</th>
                    <th width="150">Status Magang</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $peserta)
                <tr>
                    <td style="font-weight: 600; color: #0f172a;">
                        {{ ($pesertas->currentPage() - 1) * $pesertas->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.8rem;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: {{ $peserta->status === 'aktif' ? '#eff6ff' : '#f1f5f9' }}; color: {{ $peserta->status === 'aktif' ? '#2563eb' : '#64748b' }}; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.05rem;">
                                {{ strtoupper(substr($peserta->nama, 0, 1)) }}
                            </div>
                            <div>
                                <strong style="display: block; color: #1e293b; font-size: 0.95rem;">{{ $peserta->nama }}</strong>
                                <small style="color: #64748b; display: block;">NIM/NISN: {{ $peserta->nim_nisn ?? '-' }}</small>
                                @if($peserta->jenis_peserta)
                                    <span style="font-size: 0.7rem; color: #475569; background: #f1f5f9; padding: 0.1rem 0.4rem; border-radius: 4px; display: inline-block; margin-top: 2px;">
                                        {{ $peserta->jenis_peserta }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong style="color: #0f172a; font-size: 0.95rem; display: block;">{{ $peserta->instansi->nama ?? '-' }}</strong>
                        <small style="color: #64748b;"><i class="fas fa-graduation-cap mr-1"></i> {{ $peserta->jurusan ?? 'Belum ada data jurusan' }}</small>
                    </td>
                    <td>
                        @if($peserta->bidang)
                            <div style="font-weight: 600; color: #1e293b; font-size: 0.85rem; margin-bottom: 2px;">
                                <i class="fas fa-building text-primary mr-1"></i> {{ $peserta->bidang->nama }}
                            </div>
                        @else
                            <span class="badge-status pending" style="font-size: 0.75rem; margin-bottom: 2px; display: inline-block;">Belum Ditempatkan</span>
                        @endif
                        @if($peserta->pembimbing)
                            <small style="color: #475569; display: block;"><i class="fas fa-user-tie text-success mr-1"></i> {{ $peserta->pembimbing->nama }}</small>
                        @endif
                    </td>
                    <td>
                        @if($peserta->tgl_mulai)
                            <small style="color: #0f172a; font-weight: 600; display: block;">
                                <i class="fas fa-calendar-alt text-primary mr-1"></i> {{ $peserta->tgl_mulai->format('d/m/Y') }}
                            </small>
                            <small style="color: #64748b; display: block;">
                                s/d {{ $peserta->tgl_selesai?->format('d/m/Y') ?? '?' }}
                            </small>
                        @else
                            <span style="color: #94a3b8; font-size: 0.85rem;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($peserta->status === 'aktif')
                            <span class="badge-status approved" style="display: inline-flex; align-items: center; gap: 5px; font-weight: 700; padding: 0.35rem 0.75rem; font-size: 0.85rem;">
                                <i class="fas fa-user-clock"></i> Sedang Magang
                            </span>
                        @else
                            <span class="badge-status" style="display: inline-flex; align-items: center; gap: 5px; background: #e2e8f0; color: #334155; font-weight: 700; padding: 0.35rem 0.75rem; font-size: 0.85rem;">
                                <i class="fas fa-check-circle text-success"></i> Selesai Magang
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="action-icons" style="display: flex; align-items: center; gap: 0.35rem;">
                            <!-- Tombol Cepat Ubah Status Magang -->
                            <form action="{{ route('admin.peserta.toggle_status', $peserta) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                @if($peserta->status === 'aktif')
                                    <button type="submit" class="edit" style="background: #eff6ff; color: #2563eb; border: none; cursor: pointer; padding: 0.35rem 0.55rem; border-radius: 6px;" title="Ubah status menjadi: Selesai Magang" onclick="return confirm('Tandai peserta {{ addslashes($peserta->nama) }} telah SELESAI magang?')">
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                @else
                                    <button type="submit" class="edit" style="background: #f0fdf4; color: #16a34a; border: none; cursor: pointer; padding: 0.35rem 0.55rem; border-radius: 6px;" title="Ubah status menjadi: Sedang Magang" onclick="return confirm('Aktifkan kembali peserta {{ addslashes($peserta->nama) }} ke status SEDANG MAGANG?')">
                                        <i class="fas fa-redo"></i> Aktifkan
                                    </button>
                                @endif
                            </form>

                            <a href="{{ route('admin.peserta.edit', $peserta) }}" class="edit" title="Edit Peserta" style="padding: 0.35rem 0.55rem;">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.peserta.destroy', $peserta) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete" title="Hapus Peserta" style="border: none; cursor: pointer; padding: 0.35rem 0.55rem;" onclick="return confirm('Yakin hapus data peserta {{ addslashes($peserta->nama) }}?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-user-graduate fa-3x mb-3 text-muted" style="opacity: 0.4;"></i>
                        <p class="mb-1 font-weight-bold" style="font-size: 1.1rem; color: #334155;">Tidak ada data peserta magang yang sesuai.</p>
                        @if(request('instansi_id') || request('status') || request('search'))
                            <p style="font-size: 0.9rem; color: #64748b;">Coba ubah atau reset filter pencarian di atas.</p>
                            <a href="{{ route('admin.peserta.index') }}" class="action-button" style="background: #2563eb; color: white; display: inline-block; margin-top: 0.5rem;">
                                <i class="fas fa-sync-alt mr-1"></i> Reset Semua Filter
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span><i class="far fa-clock" style="margin-right: 6px;"></i> Terakhir diperbarui: {{ today()->translatedFormat('d F Y') }}</span>
        <div class="pagination">
            {{ $pesertas->links() }}
        </div>
    </div>
</div>
@endsection
