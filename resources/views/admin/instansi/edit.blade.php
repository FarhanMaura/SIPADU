@extends('layouts.adminlte')
@section('title', 'Edit Instansi')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="fas fa-edit"></i> Edit Instansi
        </h1>
        <p>
            <i class="fas fa-chevron-right"></i> Form <i class="fas fa-chevron-right"></i> Edit Instansi
        </p>
    </div>
    <a href="javascript:history.back()" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Form Container -->
<div class="form-container-clean">
    <form action="{{ route('admin.instansi.update', $instansi) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label>Nama Instansi <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $instansi->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $instansi->alamat) }}</textarea>
            </div>
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="telp" class="form-control" value="{{ old('telp', $instansi->telp) }}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $instansi->email) }}">
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('admin.instansi.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
