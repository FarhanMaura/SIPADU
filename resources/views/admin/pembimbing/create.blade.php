@extends('layouts.adminlte')
@section('title', 'Tambah Pembimbing')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="fas fa-edit"></i> Tambah Pembimbing
        </h1>
        <p>
            <i class="fas fa-chevron-right"></i> Form <i class="fas fa-chevron-right"></i> Tambah Pembimbing
        </p>
    </div>
    <a href="javascript:history.back()" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Form Container -->
<div class="form-container-clean">
    <form action="{{ route('admin.pembimbing.store') }}" method="POST">
        @csrf
        <div class="form-body">
            <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ old('nip') }}">
            </div>
            <div class="form-group">
                <label>Bidang</label>
                <select name="bidang_id" class="form-control">
                    <option value="">-- Pilih Bidang --</option>
                    @foreach($bidangs as $bidang)
                    <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>{{ $bidang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
            </div>
            <hr><h5>Akun Login</h5>
            <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.pembimbing.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
