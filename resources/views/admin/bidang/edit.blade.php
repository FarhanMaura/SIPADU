@extends('layouts.adminlte')
@section('title', 'Edit Bidang')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="fas fa-edit"></i> Edit Bidang
        </h1>
        <p>
            <i class="fas fa-chevron-right"></i> Master Data
            <i class="fas fa-chevron-right"></i> Bidang
            <i class="fas fa-chevron-right"></i> Edit
        </p>
    </div>
    <a href="{{ route('admin.bidang.index') }}" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Form Container -->
<div class="form-container-clean">
    <form action="{{ route('admin.bidang.update', $bidang) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Bidang <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $bidang->nama) }}" placeholder="Masukkan nama bidang penempatan..." required>
            @error('nama')<div class="invalid-feedback text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Deskripsi Bidang</label>
            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tuliskan penjelasan singkat mengenai ruang lingkup bidang ini...">{{ old('deskripsi', $bidang->deskripsi) }}</textarea>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Perbarui Bidang</button>
            <a href="{{ route('admin.bidang.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
