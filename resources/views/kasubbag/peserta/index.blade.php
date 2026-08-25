@extends('layouts.adminlte')
@section('title', 'Kelola Peserta Magang')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-graduate"></i> Kelola Peserta Magang</h1>
        <p><i class="fas fa-chevron-right"></i> Kasubbag <i class="fas fa-chevron-right"></i> Peserta Magang</p>
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
</div>

<!-- Import Form (Hidden by default) -->
<div id="import-form" class="table-container" style="display: none; padding: 1.5rem; margin-bottom: 1.5rem; background: #f0fdf4; border-color: #bbf7d0;">
    <h5 style="font-weight: 700; color: #166534; margin-bottom: 1rem; margin-top: 0; font-size: 1.1rem;"><i class="fas fa-file-excel"></i> Import Data Peserta dari Excel</h5>
    <form action="{{ route('kasubbag.peserta.import') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; align-items: center; gap: 1rem;">
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
    <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #64748b;">Format file harus berformat .xlsx atau .xls</div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-list-ul"></i> Daftar Peserta Magang</h3>
        <form action="{{ route('kasubbag.peserta.index') }}" method="GET" class="search-box">
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
                    <th width="160">Aksi</th>
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
                                <small style="color: #64748b; display: block;">{{ $peserta->nim_nisn ?? '-' }}</small>
                                @if($peserta->user_id)
                                    <span style="font-size: 0.7rem; color: #16a34a; background: #dcfce7; padding: 0.1rem 0.4rem; border-radius: 4px; font-weight: 600; display: inline-block; margin-top: 2px;">
                                        <i class="fas fa-user-check"></i> Akun Terdaftar
                                    </span>
                                @else
                                    <span style="font-size: 0.7rem; color: #d97706; background: #fef3c7; padding: 0.1rem 0.4rem; border-radius: 4px; font-weight: 600; display: inline-block; margin-top: 2px;" title="Peserta belum mendaftar akun di /register">
                                        <i class="fas fa-user-clock"></i> Belum Registrasi Akun
                                    </span>
                                @endif
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
                            <div style="font-size: 0.85rem; font-weight: 700; color: #1e293b; margin-top: 2px;">
                                <i class="fas fa-building text-primary mr-1"></i> {{ $peserta->bidang->nama }}
                            </div>
                            @if($peserta->pembimbing)
                                <small style="color: #64748b; font-size: 0.75rem; display: block;"><i class="fas fa-user-tie text-secondary mr-1"></i> {{ $peserta->pembimbing->nama }}</small>
                            @endif
                        @else
                            <span class="badge-status pending" style="font-size: 0.75rem; margin-top: 2px; display: inline-block;">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Belum Ditempatkan
                            </span>
                        @endif

                        <!-- Quick Penempatan Form Toggle Button -->
                        <div style="margin-top: 0.35rem;">
                            <button type="button" onclick="togglePenempatanModal('penempatan-{{ $peserta->id }}')" style="font-size: 0.725rem; padding: 0.2rem 0.55rem; border-radius: 6px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <i class="fas fa-map-marker-alt"></i> {{ $peserta->bidang_id ? 'Ubah Penempatan' : 'Set Penempatan' }}
                            </button>
                        </div>

                        <!-- Quick Penempatan Form Inline Popup -->
                        <div id="penempatan-{{ $peserta->id }}" style="display: none; margin-top: 0.5rem; background: #ffffff; padding: 0.85rem; border-radius: 12px; border: 1px solid #2563eb; box-shadow: 0 10px 25px -5px rgba(37,99,235,0.2); width: 260px; position: absolute; z-index: 50;">
                            <form action="{{ route('kasubbag.peserta.update', $peserta) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="pengajuan_id" value="{{ $peserta->pengajuan_id }}">
                                <input type="hidden" name="nama" value="{{ $peserta->nama }}">
                                <input type="hidden" name="nim_nisn" value="{{ $peserta->nim_nisn }}">
                                <input type="hidden" name="jurusan" value="{{ $peserta->jurusan }}">
                                <input type="hidden" name="jenis_peserta" value="{{ $peserta->jenis_peserta }}">
                                <input type="hidden" name="tgl_mulai" value="{{ $peserta->tgl_mulai?->format('Y-m-d') }}">
                                <input type="hidden" name="tgl_selesai" value="{{ $peserta->tgl_selesai?->format('Y-m-d') }}">
                                <input type="hidden" name="status" value="{{ $peserta->status ?? 'aktif' }}">

                                <div style="font-weight: 700; font-size: 0.8rem; color: #0f172a; margin-bottom: 0.5rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.3rem;">
                                    <i class="fas fa-map-marked-alt text-primary mr-1"></i> Penempatan {{ Str::limit($peserta->nama, 15) }}
                                </div>

                                <div style="margin-bottom: 0.75rem;">
                                    <label style="font-size: 0.725rem; font-weight: 600; color: #475569; display: block; margin-bottom: 0.2rem;">Pilih Bidang Penempatan:</label>
                                    <select name="bidang_id" class="form-control" style="font-size: 0.8rem; padding: 0.35rem 0.5rem; height: auto;" required>
                                        <option value="">-- Pilih Bidang Penempatan --</option>
                                        @foreach($bidangs as $b)
                                            <option value="{{ $b->id }}" {{ $peserta->bidang_id == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small style="font-size: 0.7rem; color: #64748b; margin-top: 0.2rem; display: block;">Pembimbing akan ditentukan oleh Admin.</small>
                                </div>

                                <div style="display: flex; gap: 0.3rem;">
                                    <button type="submit" style="font-size: 0.75rem; padding: 0.35rem 0.75rem; background: #16a34a; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; flex: 1;">
                                        <i class="fas fa-check mr-1"></i> Simpan Bidang
                                    </button>
                                    <button type="button" onclick="togglePenempatanModal('penempatan-{{ $peserta->id }}')" style="font-size: 0.75rem; padding: 0.35rem 0.5rem; background: #cbd5e1; color: #334155; border: none; border-radius: 6px; cursor: pointer;">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
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
                            @if($peserta->pengajuan_id)
                                <a href="{{ route('kasubbag.pengajuan.loa', $peserta->pengajuan_id) }}" class="edit" style="background: #dcfce7; color: #15803d; border-color: #bbf7d0;" title="Unduh LoA PDF (Surat Balasan)"><i class="fas fa-file-pdf"></i> LoA</a>
                            @endif
                            <a href="{{ route('kasubbag.peserta.edit', $peserta) }}" class="edit" title="Edit & Tempatkan"><i class="fas fa-pen"></i> Edit</a>
                            <form action="{{ route('kasubbag.peserta.destroy', $peserta) }}" method="POST" class="d-inline">
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
                    <td colspan="7" class="text-center py-5 text-muted">
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

<script>
function togglePenempatanModal(id) {
    const el = document.getElementById(id);
    if (el) {
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
    }
}
</script>
@endsection
