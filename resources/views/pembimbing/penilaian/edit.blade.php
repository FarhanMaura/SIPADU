@extends('layouts.adminlte')
@section('title', 'Edit Nilai')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-edit"></i> Edit Nilai Kinerja Peserta</h1>
        <p>Perbarui nilai 7 kriteria evaluasi peserta magang.</p>
    </div>
    <a href="{{ route('pembimbing.penilaian.index') }}" class="action-button" style="background: #64748b; box-shadow: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
    <div>
        <form action="{{ route('pembimbing.penilaian.update', $penilaian) }}" method="POST" class="form-container-clean">
            @csrf @method('PUT')
            
            <div class="form-group mb-4">
                <label style="font-weight: 700; color: #1e293b;">Nama Peserta Magang</label>
                <input type="text" class="form-control" value="{{ $penilaian->peserta?->nama }} ({{ $penilaian->peserta?->jurusan ?? 'Tanpa Jurusan' }})" disabled style="background: #f8fafc; font-weight: 600;">
                <input type="hidden" name="peserta_id" value="{{ $penilaian->peserta_id }}">
            </div>

            <h5 class="mt-4 mb-3 font-weight-bold text-dark" style="font-size: 1.1rem; color: #0f172a;">
                <i class="fas fa-tasks text-primary mr-1"></i> Penilaian 7 Indikator Kinerja PKL (0–100)
            </h5>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="font-weight: 600;">1. Kedisiplinan <span class="text-danger">*</span></label>
                    <input type="number" name="kedisiplinan" class="form-control" value="{{ old('kedisiplinan', $penilaian->kedisiplinan ?? 0) }}" min="0" max="100" step="1" required style="border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="font-weight: 600;">2. Kerapian <span class="text-danger">*</span></label>
                    <input type="number" name="kerapian" class="form-control" value="{{ old('kerapian', $penilaian->kerapian ?? 0) }}" min="0" max="100" step="1" required style="border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="font-weight: 600;">3. Kebersihan <span class="text-danger">*</span></label>
                    <input type="number" name="kebersihan" class="form-control" value="{{ old('kebersihan', $penilaian->kebersihan ?? 0) }}" min="0" max="100" step="1" required style="border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="font-weight: 600;">4. Tanggung Jawab <span class="text-danger">*</span></label>
                    <input type="number" name="tanggung_jawab" class="form-control" value="{{ old('tanggung_jawab', $penilaian->tanggung_jawab ?? 0) }}" min="0" max="100" step="1" required style="border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="font-weight: 600;">5. Kerjasama <span class="text-danger">*</span></label>
                    <input type="number" name="kerjasama" class="form-control" value="{{ old('kerjasama', $penilaian->kerjasama ?? 0) }}" min="0" max="100" step="1" required style="border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="font-weight: 600;">6. Kreativitas <span class="text-danger">*</span></label>
                    <input type="number" name="kreativitas" class="form-control" value="{{ old('kreativitas', $penilaian->kreativitas ?? 0) }}" min="0" max="100" step="1" required style="border-radius: 8px;">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label style="font-weight: 600;">7. Kejujuran <span class="text-danger">*</span></label>
                    <input type="number" name="kejujuran" class="form-control" value="{{ old('kejujuran', $penilaian->kejujuran ?? 0) }}" min="0" max="100" step="1" required style="border-radius: 8px;">
                </div>
            </div>

            <div class="form-group mb-4">
                <label style="font-weight: 600;">Catatan / Keterangan Kinerja Bidang</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan evaluasi kinerja peserta selama magang di bidang..." style="border-radius: 8px;">{{ old('keterangan', $penilaian->keterangan) }}</textarea>
            </div>
            
            <hr>
            
            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="action-button" style="padding: 0.75rem 2rem; background: #2563eb;"><i class="fas fa-save mr-2"></i> Perbarui Nilai</button>
                <a href="{{ route('pembimbing.penilaian.index') }}" class="action-button" style="background: #f1f5f9; color: #475569; box-shadow: none;">Batal</a>
            </div>
        </form>
    </div>
    
    <!-- Info Panel -->
    <div>
        <div class="form-container-clean" style="background: #eff6ff; border-color: #bfdbfe; padding: 1.5rem; border-radius: 12px;">
            <h4 style="color: #1d4ed8; font-weight: 700; margin-bottom: 1rem; margin-top: 0; font-size: 1.05rem;"><i class="fas fa-info-circle"></i> Petunjuk 7 Kriteria Penilaian</h4>
            <ul style="color: #475569; font-size: 0.9rem; line-height: 1.6; padding-left: 1.2rem; margin-bottom: 0;">
                <li>Inputkan angka (0-100) untuk masing-masing dari 7 kriteria pekerjaan yang dilatihkan.</li>
                <li>Sistem akan <strong>otomatis menghitung JUMLAH dan RATA-RATA</strong>.</li>
                <li>Rata-rata nilai ini akan tercantum pada **Daftar Nilai Mahasiswa PKL** dan **Piagam Penghargaan Sertifikat**.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
