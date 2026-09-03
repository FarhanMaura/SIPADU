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
        <label>Peserta Magang <span class="text-danger">*</span></label>
        <select name="peserta_id" class="form-control @error('peserta_id') is-invalid @enderror" required>
            <option value="">-- Pilih Peserta --</option>
            @foreach($pesertas as $p)
            <option value="{{ $p->id }}" {{ (old('peserta_id') ?? request('peserta_id')) == $p->id ? 'selected' : '' }}>{{ $p->nama }} ({{ $p->jurusan ?? 'Tanpa Jurusan' }})</option>
            @endforeach
        </select>
        @error('peserta_id')<div class="invalid-feedback" style="color: #dc2626; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>@enderror
    </div>

    <h5 class="mt-4 mb-3 font-weight-bold text-dark"><i class="fas fa-tasks mr-1"></i> Penilaian Indikator Kinerja Bidang (0–100)</h5>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div class="form-group">
            <label>Kedisiplinan</label>
            <input type="number" name="kedisiplinan" class="form-control" value="{{ old('kedisiplinan', 0) }}" min="0" max="100" step="1">
        </div>
        <div class="form-group">
            <label>Kerapian</label>
            <input type="number" name="kerapian" class="form-control" value="{{ old('kerapian', 0) }}" min="0" max="100" step="1">
        </div>
        <div class="form-group">
            <label>Kebersihan</label>
            <input type="number" name="kebersihan" class="form-control" value="{{ old('kebersihan', 0) }}" min="0" max="100" step="1">
        </div>
        <div class="form-group">
            <label>Tanggung Jawab</label>
            <input type="number" name="tanggung_jawab" class="form-control" value="{{ old('tanggung_jawab', 0) }}" min="0" max="100" step="1">
        </div>
        <div class="form-group">
            <label>Kerjasama</label>
            <input type="number" name="kerjasama" class="form-control" value="{{ old('kerjasama', 0) }}" min="0" max="100" step="1">
        </div>
        <div class="form-group">
            <label>Kreativitas</label>
            <input type="number" name="kreativitas" class="form-control" value="{{ old('kreativitas', 0) }}" min="0" max="100" step="1">
        </div>
        <div class="form-group" style="grid-column: span 2;">
            <label>Kejujuran</label>
            <input type="number" name="kejujuran" class="form-control" value="{{ old('kejujuran', 0) }}" min="0" max="100" step="1">
        </div>
    </div>

    <div class="form-group">
        <label>Catatan / Keterangan Kinerja Bidang</label>
        <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan evaluasi kinerja peserta selama magang di bidang...">{{ old('keterangan') }}</textarea>
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
