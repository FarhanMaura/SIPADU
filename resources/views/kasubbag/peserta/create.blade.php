@extends('layouts.adminlte')
@section('title', 'Tambah Peserta Magang')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-plus"></i> Tambah Peserta Magang Baru</h1>
        <p>Kasubbag menambahkan data peserta magang dan membuatkan akun login peserta.</p>
    </div>
    <a href="{{ route('kasubbag.peserta.index') }}" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-user-plus text-primary"></i> Formulir Tambah Peserta Magang Baru</h3>
    </div>
    <div style="padding: 2rem;">
        <form action="{{ route('kasubbag.peserta.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem;">
                <div style="grid-column: 1 / -1;">
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Pilih Pengajuan Magang (Referensi) <span class="text-danger">*</span></label>
                    <select name="pengajuan_id" class="form-control" required>
                        <option value="">-- Pilih Referensi Pengajuan --</option>
                        @foreach($pengajuans as $p)
                            <option value="{{ $p->id }}" {{ old('pengajuan_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->pic_nama }} — {{ $p->nama_instansi }} @if($p->nim_nisn)({{ $p->nim_nisn }})@endif [Periode: {{ $p->tgl_mulai?->format('d/m/Y') }} - {{ $p->tgl_selesai?->format('d/m/Y') }}]
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Nama Lengkap Peserta <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Muhammad Febrian" required>
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">NIM / NISN</label>
                    <input type="text" name="nim_nisn" class="form-control" value="{{ old('nim_nisn') }}" placeholder="Contoh: 221410011">
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Jurusan / Program Studi</label>
                    <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan') }}" placeholder="Contoh: Sistem Informasi">
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Kategori / Jenis Peserta</label>
                    <select name="jenis_peserta" class="form-control">
                        <option value="Mahasiswa" {{ old('jenis_peserta') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa (Perguruan Tinggi)</option>
                        <option value="Peserta Didik" {{ old('jenis_peserta') == 'Peserta Didik' ? 'selected' : '' }}>Peserta Didik / Siswa (SMA/SMK)</option>
                        <option value="Lainnya" {{ old('jenis_peserta') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Tanggal Mulai Magang</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="{{ old('tgl_mulai') }}">
                </div>

                <div>
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Tanggal Selesai Magang</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="{{ old('tgl_selesai') }}">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Status Keaktifan Peserta</label>
                    <select name="status" class="form-control">
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif (Sedang Magang)</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai (Telah Menyelesaikan Magang)</option>
                    </select>
                </div>
            </div>

            <!-- Penempatan Bidang & Pembimbing -->
            <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9;">
                <h4 style="margin-bottom: 1rem; color: #0f172a; font-size: 0.95rem; font-weight: 700;">
                    <i class="fas fa-map-marker-alt text-primary mr-1"></i> Penempatan Bidang & Pembimbing (Sesuai Bidang Admin)
                </h4>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Bidang Penempatan</label>
                        <select name="bidang_id" class="form-control">
                            <option value="">-- Belum Ditempatkan (Pilih Bidang) --</option>
                            @foreach($bidangs as $b)
                                <option value="{{ $b->id }}" {{ old('bidang_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Pembimbing Magang (Opsional)</label>
                        <select name="pembimbing_id" class="form-control">
                            <option value="">-- Belum Ditentukan (Pilih Pembimbing) --</option>
                            @foreach($pembimbings as $pem)
                                <option value="{{ $pem->id }}" {{ old('pembimbing_id') == $pem->id ? 'selected' : '' }}>
                                    {{ $pem->nama }} @if($pem->bidang)({{ $pem->bidang->nama }})@endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                <h4 style="margin-bottom: 1rem; color: #0f172a; font-size: 1rem;"><i class="fas fa-lock text-warning mr-1"></i> Akun Login Peserta (Opsional)</h4>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Email Login</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="peserta@example.com">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 0.4rem; display: block;">Password Login</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                    </div>
                </div>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; display: flex; gap: 1rem;">
                <button type="submit" class="action-button" style="background: #16a34a; padding: 0.7rem 1.75rem;">
                    <i class="fas fa-save"></i> Simpan Peserta Baru
                </button>
                <a href="{{ route('kasubbag.peserta.index') }}" class="action-button" style="background: #e2e8f0; color: #475569; padding: 0.7rem 1.5rem; box-shadow: none;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
