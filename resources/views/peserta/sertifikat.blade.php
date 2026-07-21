@extends('layouts.adminlte')
@section('title', 'Sertifikat Magang')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-certificate"></i> Sertifikat Magang</h1>
        <p>Sertifikat resmi tanda kelulusan program magang Anda.</p>
    </div>
</div>

<div class="form-container-clean" style="text-align: center; max-width: 800px; margin: 0 auto;">
    @if($peserta && $penilaian)
    <div style="border: 8px solid #f8fafc; padding: 3rem 2rem; border-radius: 16px; background: white; box-shadow: inset 0 0 0 1px #e2e8f0; position: relative;">
        <i class="fas fa-award" style="font-size: 4rem; color: #f59e0b; margin-bottom: 1rem; opacity: 0.2; position: absolute; top: 2rem; right: 2rem;"></i>
        <h2 style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 2rem; letter-spacing: 0.1em;">SERTIFIKAT MAGANG</h2>
        <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 0.5rem;">Diberikan kepada:</p>
        <h3 style="font-size: 2rem; font-weight: 700; color: #2563eb; margin-bottom: 0.5rem;">{{ $peserta->nama }}</h3>
        <p style="color: #475569; font-size: 1.1rem; margin-bottom: 2rem;">{{ $peserta->jurusan ?? '' }} - {{ $peserta->instansi?->nama }}</p>
        
        <p style="color: #1e293b; font-size: 1.1rem; margin-bottom: 1rem;">
            Telah menyelesaikan program magang di bidang <strong>{{ $peserta->bidang?->nama ?? '-' }}</strong>
        </p>
        <p style="color: #64748b; margin-bottom: 2rem;">
            Periode: {{ ($peserta->tgl_mulai ?? $peserta->pengajuan?->tgl_mulai)?->format('d F Y') }} s/d {{ ($peserta->tgl_selesai ?? $peserta->pengajuan?->tgl_selesai)?->format('d F Y') }}
        </p>
        
        <div style="display: inline-block; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 1rem 2rem; border-radius: 12px; margin-bottom: 2rem;">
            <p style="margin: 0; color: #166534; font-size: 1.1rem;">Nilai Akhir: <strong style="font-size: 1.5rem; margin-left: 0.5rem;">{{ $penilaian->nilai_angka }}</strong></p>
        </div>
        
        <div style="text-align: center; max-width: 300px; margin: 0 auto; border-top: 1px solid #cbd5e1; padding-top: 1rem;">
            <p style="color: #0f172a; font-weight: 600; margin-bottom: 0;">{{ $peserta->pembimbing?->nama }}</p>
            <p style="color: #64748b; font-size: 0.9rem;">Pembimbing Magang</p>
        </div>
    </div>
    <div style="margin-top: 2rem;">
        <a href="{{ route('peserta.sertifikat.download') }}" class="action-button" style="background: #2563eb; color: white; padding: 0.8rem 1.5rem; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(37,99,235,0.3);">
            <i class="fas fa-file-pdf"></i> Unduh PDF Sertifikat
        </a>
    </div>
    @elseif(!$penilaian)
    <div class="alert-toast alert-toast-danger" style="background: #fffbeb; border-color: #fde68a; color: #d97706; text-align: left;">
        <i class="fas fa-exclamation-triangle"></i> Sertifikat belum dapat diunduh karena nilai Anda belum diinput oleh pembimbing.
    </div>
    @else
    <div class="alert-toast alert-toast-danger" style="text-align: left;">
        <i class="fas fa-exclamation-circle"></i> Data peserta tidak ditemukan.
    </div>
    @endif
</div>
@endsection
