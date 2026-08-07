@extends('layouts.adminlte')
@section('title', 'Penempatan Peserta')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="fas fa-edit"></i> Penempatan Peserta
        </h1>
        <p>
            <i class="fas fa-chevron-right"></i> Form <i class="fas fa-chevron-right"></i> Penempatan Bidang & Pembimbing Peserta
        </p>
    </div>
    <a href="javascript:history.back()" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="alert alert-info border-0 shadow-sm mb-4" style="background: #e0f2fe; color: #0369a1; border-radius: 12px; padding: 1rem 1.25rem;">
    <i class="fas fa-info-circle mr-2"></i> <strong>Catatan Alur Penempatan:</strong> Setelah pembinaan oleh Kasubbag Umum & Kepegawaian pada hari pertama, peserta ditempatkan pada bidang yang sesuai. Penentuan Pembimbing ditentukan oleh Atasan di bidang masing-masing berdasarkan tugas yang diberikan.
</div>

<!-- Form Container -->
<div class="form-container-clean">
    <form action="{{ route('admin.peserta.penempatan.save', $peserta) }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-body">
            <div class="form-group">
                <label>Bidang <span class="text-danger">*</span></label>
                <select name="bidang_id" class="form-control @error('bidang_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Bidang --</option>
                    @foreach($bidangs as $bidang)
                    <option value="{{ $bidang->id }}" {{ $peserta->bidang_id == $bidang->id ? 'selected' : '' }}>{{ $bidang->nama }}</option>
                    @endforeach
                </select>
                @error('bidang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Pembimbing <span class="text-danger">*</span></label>
                <select name="pembimbing_id" class="form-control @error('pembimbing_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach($pembimbings as $pem)
                    <option value="{{ $pem->id }}" {{ $peserta->pembimbing_id == $pem->id ? 'selected' : '' }}>{{ $pem->nama }} ({{ $pem->bidang?->nama ?? 'Tanpa Bidang' }})</option>
                    @endforeach
                </select>
                @error('pembimbing_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan Penempatan</button>
            <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
