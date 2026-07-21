@extends('layouts.adminlte')
@section('title', 'Edit Peserta')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="fas fa-edit"></i> Edit Peserta
        </h1>
        <p>
            <i class="fas fa-chevron-right"></i> Form <i class="fas fa-chevron-right"></i> Edit Peserta
        </p>
    </div>
    <a href="javascript:history.back()" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Form Container -->
<div class="form-container-clean">
    <form action="{{ route('admin.peserta.update', $peserta) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label>Pengajuan (Instansi) <span class="text-danger">*</span></label>
                <select name="pengajuan_id" class="form-control @error('pengajuan_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Pengajuan --</option>
                    @foreach($pengajuans as $pj)
                    <option value="{{ $pj->id }}" {{ old('pengajuan_id', $peserta->pengajuan_id) == $pj->id ? 'selected' : '' }}>{{ $pj->nama_instansi }} ({{ $pj->tgl_mulai?->format('d/m/Y') }})</option>
                    @endforeach
                </select>
                @error('pengajuan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>NIM / NISN</label>
                <input type="text" name="nim_nisn" class="form-control" value="{{ old('nim_nisn', $peserta->nim_nisn) }}">
            </div>
            <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $peserta->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Jurusan / Prodi</label>
                <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $peserta->jurusan) }}">
            </div>
            <div class="form-group">
                <label>Jenis Peserta</label>
                <select name="jenis_peserta" class="form-control">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Mahasiswa" {{ old('jenis_peserta', $peserta->jenis_peserta) === 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="Peserta Didik" {{ old('jenis_peserta', $peserta->jenis_peserta) === 'Peserta Didik' ? 'selected' : '' }}>Peserta Didik</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" class="form-control" value="{{ old('tgl_mulai', $peserta->tgl_mulai?->format('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label>Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" class="form-control" value="{{ old('tgl_selesai', $peserta->tgl_selesai?->format('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="aktif" {{ old('status', $peserta->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ old('status', $peserta->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
