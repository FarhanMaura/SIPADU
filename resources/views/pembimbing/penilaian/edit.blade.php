@extends('layouts.adminlte')
@section('title', 'Edit Nilai')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-edit"></i> Edit Nilai</h1>
        <p>Perbarui nilai akhir peserta magang.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
    <div>
        <form action="{{ route('pembimbing.penilaian.update', $penilaian) }}" method="POST" class="form-container-clean">
    @csrf @method('PUT')
    <div class="form-group">
        <label>Peserta</label>
        <input type="text" class="form-control" value="{{ $penilaian->peserta?->nama }}" disabled>
        <input type="hidden" name="peserta_id" value="{{ $penilaian->peserta_id }}">
    </div>
    <div class="form-group">
        <label>Nilai (0-100) <span class="text-danger">*</span></label>
        <input type="number" name="nilai_angka" class="form-control" value="{{ old('nilai_angka', $penilaian->nilai_angka) }}" min="0" max="100" step="0.01" required>
    </div>
    <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $penilaian->keterangan) }}</textarea>
    </div>
    
    <hr>
    
    <div style="display: flex; gap: 1rem;">
        <button type="submit" class="action-button" style="padding: 0.75rem 2rem;"><i class="fas fa-save mr-2"></i> Perbarui Nilai</button>
        <a href="{{ route('pembimbing.penilaian.index') }}" class="action-button" style="background: #f1f5f9; color: #475569; box-shadow: none;">Batal</a>
    </div>
        </form>
    </div>
    
    <!-- Info Panel -->
    <div>
        <div class="form-container-clean" style="background: #eff6ff; border-color: #bfdbfe; padding: 2rem;">
            <h4 style="color: #1d4ed8; font-weight: 700; margin-bottom: 1rem;"><i class="fas fa-info-circle"></i> Petunjuk Penilaian</h4>
            <ul style="color: #475569; font-size: 0.95rem; line-height: 1.6; padding-left: 1.2rem; margin-bottom: 0;">
                <li>Skala nilai adalah <strong>0 hingga 100</strong>.</li>
                <li>Nilai ini akan menjadi komponen nilai akhir magang peserta.</li>
                <li>Gunakan desimal (opsional) menggunakan tanda titik (contoh: 85.50).</li>
                <li>Peserta dapat melihat nilai ini di dashboard mereka.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
