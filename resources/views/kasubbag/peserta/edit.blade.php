@extends('layouts.adminlte')
@section('title', 'Edit Peserta Magang')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-edit"></i> Edit Data Peserta Magang</h1>
        <p>Kasubbag memperbarui data peserta magang.</p>
    </div>
    <a href="{{ route('kasubbag.peserta.index') }}" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-user-pen text-primary"></i> Formulir Edit Data Peserta Magang</h3>
    </div>
    <div style="padding: 2rem;">
        <form action="{{ route('kasubbag.peserta.update', $peserta) }}" method="POST">
            @csrf @method('PUT')
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem;">
                <div style="grid-column: 1 / -1;">
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Pilih Pengajuan Magang (Referensi) <span class="text-danger">*</span></label>
                    <select name="pengajuan_id" class="form-control" required>
                        @foreach($pengajuans as $p)
                            <option value="{{ $p->id }}" {{ old('pengajuan_id', $peserta->pengajuan_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->pic_nama }} — {{ $p->nama_instansi }} @if($p->nim_nisn)({{ $p->nim_nisn }})@endif [Periode: {{ $p->tgl_mulai?->format('d/m/Y') }} - {{ $p->tgl_selesai?->format('d/m/Y') }}]
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Nama Lengkap Peserta <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $peserta->nama) }}" required placeholder="Nama lengkap peserta">
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">NIM / NISN</label>
                    <input type="text" name="nim_nisn" class="form-control" value="{{ old('nim_nisn', $peserta->nim_nisn) }}" placeholder="Nomor Induk Mahasiswa / Siswa">
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Jurusan / Program Studi</label>
                    <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $peserta->jurusan) }}" placeholder="Jurusan / Program studi">
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Kategori / Jenis Peserta</label>
                    <select name="jenis_peserta" class="form-control">
                        <option value="Mahasiswa" {{ old('jenis_peserta', $peserta->jenis_peserta) == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa (Perguruan Tinggi)</option>
                        <option value="Peserta Didik" {{ old('jenis_peserta', $peserta->jenis_peserta) == 'Peserta Didik' || old('jenis_peserta', $peserta->jenis_peserta) == 'Siswa (SMA/SMK)' ? 'selected' : '' }}>Peserta Didik / Siswa (SMA/SMK)</option>
                        <option value="Lainnya" {{ old('jenis_peserta', $peserta->jenis_peserta) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Tanggal Mulai Magang</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="{{ old('tgl_mulai', $peserta->tgl_mulai?->format('Y-m-d')) }}">
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Tanggal Selesai Magang</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="{{ old('tgl_selesai', $peserta->tgl_selesai?->format('Y-m-d')) }}">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Status Keaktifan Peserta</label>
                    <select name="status" class="form-control">
                        <option value="aktif" {{ old('status', $peserta->status) == 'aktif' ? 'selected' : '' }}>Aktif (Sedang Magang)</option>
                        <option value="selesai" {{ old('status', $peserta->status) == 'selesai' ? 'selected' : '' }}>Selesai (Telah Menyelesaikan Magang)</option>
                    </select>
                </div>
            </div>

            <!-- Penempatan Bidang -->
            <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9;">
                <h4 style="margin-bottom: 1rem; color: #0f172a; font-size: 0.95rem; font-weight: 700;">
                    <i class="fas fa-map-marker-alt text-primary mr-1"></i> Penempatan Bidang Kerja
                </h4>
                <div style="max-width: 500px;">
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Bidang Penempatan</label>
                    <select name="bidang_id" class="form-control">
                        <option value="">-- Belum Ditempatkan (Pilih Bidang) --</option>
                        @foreach($bidangs as $b)
                            <option value="{{ $b->id }}" {{ old('bidang_id', $peserta->bidang_id) == $b->id ? 'selected' : '' }}>
                                {{ $b->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small style="font-size: 0.75rem; color: #64748b; margin-top: 0.35rem; display: block;">
                        <i class="fas fa-info-circle mr-1"></i> Pembimbing lapangan ditentukan oleh Administrator melalui menu Penentuan Pembimbing.
                    </small>
                </div>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; display: flex; gap: 1rem;">
                <button type="submit" class="action-button" style="background: #16a34a; padding: 0.7rem 1.75rem;">
                    <i class="fas fa-check-circle"></i> Perbarui Data & Penempatan Peserta
                </button>
                <a href="{{ route('kasubbag.peserta.index') }}" class="action-button" style="background: #e2e8f0; color: #475569; padding: 0.7rem 1.5rem; box-shadow: none;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
