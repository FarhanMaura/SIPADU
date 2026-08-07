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
        <div style="font-size: 0.9rem; font-weight: 700; color: #0284c7; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.5rem;">DINAS PENDIDIKAN PROVINSI SUMATERA SELATAN</div>
        <h2 style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; letter-spacing: 0.05em;">SERTIFIKAT MAGANG</h2>
        <p style="color: #64748b; font-size: 1rem; margin-bottom: 0.5rem;">Diberikan secara resmi kepada:</p>
        <h3 style="font-size: 2rem; font-weight: 700; color: #2563eb; margin-bottom: 0.5rem;">{{ $peserta->nama }}</h3>
        <p style="color: #475569; font-size: 1rem; margin-bottom: 1.5rem;">NIM/NIS: {{ $peserta->nim_nisn ?? '-' }} | {{ $peserta->jurusan ?? '' }} — {{ $peserta->instansi?->nama }}</p>
        
        <p style="color: #1e293b; font-size: 1rem; margin-bottom: 0.5rem;">
            Telah menyelesaikan seluruh rangkaian program magang di bidang <strong>{{ $peserta->bidang?->nama ?? '-' }}</strong>
        </p>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">
            Periode: {{ ($peserta->tgl_mulai ?? $peserta->pengajuan?->tgl_mulai)?->format('d F Y') }} s/d {{ ($peserta->tgl_selesai ?? $peserta->pengajuan?->tgl_selesai)?->format('d F Y') }}
        </p>
        
        <div style="display: inline-block; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 0.75rem 2rem; border-radius: 12px; margin-bottom: 2rem;">
            <p style="margin: 0; color: #166534; font-size: 1rem;">Hasil Penilaian Akhir: <strong style="font-size: 1.4rem; margin-left: 0.5rem;">{{ $penilaian->nilai_angka }} ({{ $penilaian->predikat }})</strong></p>
        </div>
        
        <div style="display: flex; justify-content: space-around; gap: 1rem; border-top: 1px solid #cbd5e1; padding-top: 1.5rem; margin-top: 1rem;">
            <div style="text-align: center; flex: 1;">
                <p style="color: #0f172a; font-weight: 600; margin-bottom: 0.2rem;">Kasubbag Umum dan Kepegawaian</p>
                <p style="color: #64748b; font-size: 0.85rem;">Dinas Pendidikan Prov. Sumsel</p>
            </div>
            <div style="text-align: center; flex: 1;">
                <p style="color: #0f172a; font-weight: 600; margin-bottom: 0.2rem;">{{ $peserta->pembimbing?->nama ?? 'Pembimbing Bidang' }}</p>
                <p style="color: #64748b; font-size: 0.85rem;">Pembimbing Magang Bidang</p>
            </div>
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
