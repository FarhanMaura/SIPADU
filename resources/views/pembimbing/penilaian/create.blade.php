@extends('layouts.adminlte')
@section('title', 'Beri Nilai')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-plus-circle"></i> Beri Nilai</h1>
        <p>Input nilai akhir untuk peserta magang.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
    <div>
        <form action="{{ route('pembimbing.penilaian.store') }}" method="POST" class="form-container-clean">
    @csrf
    <div class="form-group">
        <label>Peserta <span class="text-danger">*</span></label>
        <select name="peserta_id" class="form-control @error('peserta_id') is-invalid @enderror" required>
            <option value="">-- Pilih Peserta --</option>
            @foreach($pesertas as $p)
            <option value="{{ $p->id }}" {{ (old('peserta_id') ?? request('peserta_id')) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
            @endforeach
        </select>
        @error('peserta_id')<div class="invalid-feedback" style="color: #dc2626; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label>Nilai (0-100) <span class="text-danger">*</span></label>
        <input type="number" name="nilai_angka" class="form-control @error('nilai_angka') is-invalid @enderror" value="{{ old('nilai_angka') }}" min="0" max="100" step="0.01" required>
        @error('nilai_angka')<div class="invalid-feedback" style="color: #dc2626; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
    </div>
    
    <hr>
    
    <div style="display: flex; gap: 1rem;">
        <button type="submit" class="action-button" style="padding: 0.75rem 2rem;"><i class="fas fa-save mr-2"></i> Simpan Nilai</button>
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
                <li>Berikan keterangan atau catatan tambahan jika diperlukan (contoh: "Kinerja sangat memuaskan dan proaktif").</li>
            </ul>
        </div>
    </div>
</div>
@endsection
