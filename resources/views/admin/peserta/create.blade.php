@extends('layouts.adminlte')
@section('title', 'Tambah Peserta')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="fas fa-edit"></i> Tambah Peserta
        </h1>
        <p>
            <i class="fas fa-chevron-right"></i> Form <i class="fas fa-chevron-right"></i> Tambah Peserta
        </p>
    </div>
    <a href="javascript:history.back()" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Form Container -->
<div class="form-container-clean">
    <form action="{{ route('admin.peserta.store') }}" method="POST">
        @csrf
        <div class="form-body">
            <div class="form-group">
                <label>Pengajuan (harus sudah disetujui) <span class="text-danger">*</span></label>
                <select name="pengajuan_id" class="form-control @error('pengajuan_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Pengajuan --</option>
                    @foreach($pengajuans as $pj)
                    <option value="{{ $pj->id }}" {{ old('pengajuan_id') == $pj->id ? 'selected' : '' }}>{{ $pj->nama_instansi }} ({{ $pj->tgl_mulai?->format('d/m/Y') }})</option>
                    @endforeach
                </select>
                @error('pengajuan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>NIM / NISN</label>
                <input type="text" name="nim_nisn" class="form-control" value="{{ old('nim_nisn') }}">
            </div>
            <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Jurusan / Prodi</label>
                <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan') }}">
            </div>
            <div class="form-group">
                <label>Jenis Peserta</label>
                <select name="jenis_peserta" class="form-control">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Mahasiswa" {{ old('jenis_peserta') === 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="Peserta Didik" {{ old('jenis_peserta') === 'Peserta Didik' ? 'selected' : '' }}>Peserta Didik</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" class="form-control" value="{{ old('tgl_mulai') }}">
            </div>
            <div class="form-group">
                <label>Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" class="form-control" value="{{ old('tgl_selesai') }}">
            </div>
            <hr><h5>Akun Login Peserta</h5>
            <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
