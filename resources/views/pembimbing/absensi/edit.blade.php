@extends('layouts.adminlte')
@section('title', 'Edit Absensi')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-edit"></i> Edit Absensi</h1>
        <p>Perbarui data kehadiran peserta magang.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
    <div>
        <form action="{{ route('pembimbing.absensi.update', $absensi) }}" method="POST" class="form-container-clean">
    @csrf @method('PUT')
    <div class="form-group">
        <label>Peserta</label>
        <input type="text" class="form-control" value="{{ $absensi->peserta?->nama }}" disabled>
        <input type="hidden" name="peserta_id" value="{{ $absensi->peserta_id }}">
    </div>
    <div class="form-group">
        <label>Tanggal <span class="text-danger">*</span></label>
        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $absensi->tanggal?->format('Y-m-d')) }}" required>
    </div>
    <div class="form-group">
        <label>Status <span class="text-danger">*</span></label>
        <select name="status" class="form-control" required>
            <option value="hadir" {{ old('status', $absensi->status) === 'hadir' ? 'selected' : '' }}>Hadir</option>
            <option value="izin" {{ old('status', $absensi->status) === 'izin' ? 'selected' : '' }}>Izin</option>
            <option value="sakit" {{ old('status', $absensi->status) === 'sakit' ? 'selected' : '' }}>Sakit</option>
            <option value="alpa" {{ old('status', $absensi->status) === 'alpa' ? 'selected' : '' }}>Alpa</option>
        </select>
    </div>
    <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $absensi->keterangan) }}</textarea>
    </div>
    
    <hr>
    
    <div style="display: flex; gap: 1rem;">
        <button type="submit" class="action-button" style="padding: 0.75rem 2rem;"><i class="fas fa-save mr-2"></i> Perbarui</button>
        <a href="{{ route('pembimbing.absensi.index') }}" class="action-button" style="background: #f1f5f9; color: #475569; box-shadow: none;">Batal</a>
    </div>
        </form>
    </div>
    
    <!-- Info Panel -->
    <div>
        <div class="form-container-clean" style="background: #eff6ff; border-color: #bfdbfe; padding: 2rem;">
            <h4 style="color: #1d4ed8; font-weight: 700; margin-bottom: 1rem;"><i class="fas fa-info-circle"></i> Petunjuk Absensi</h4>
            <ul style="color: #475569; font-size: 0.95rem; line-height: 1.6; padding-left: 1.2rem; margin-bottom: 0;">
                <li>Pilih nama peserta bimbingan yang bersangkutan.</li>
                <li>Tentukan tanggal absensi yang ingin dicatat.</li>
                <li>Pilih status kehadiran peserta secara akurat (Hadir, Izin, Sakit, atau Alpa).</li>
                <li>Jika peserta berhalangan hadir (Sakit/Izin/Alpa), mohon sertakan keterangan yang jelas.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
