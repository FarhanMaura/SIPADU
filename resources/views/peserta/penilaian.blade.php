@extends('layouts.adminlte')
@section('title', 'Penilaian Saya')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-star"></i> Penilaian Saya</h1>
        <p>Hasil evaluasi dan penilaian magang Anda.</p>
    </div>
</div>

<div class="table-container">
    <div class="table-toolbar">
        <h3><i class="fas fa-award"></i> Hasil Penilaian Akhir</h3>
    </div>
    <div style="padding: 1.5rem;">
        @if($penilaian)
        <table style="width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 1.5rem;">
            <tbody>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; width: 250px; color: #64748b; font-weight: 600;">Nilai Angka</th>
                    <td style="padding: 1rem 0;">
                        <strong style="font-size: 2.5rem; color: #2563eb; line-height: 1;">{{ $penilaian->nilai_angka }}</strong>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f0f4fa;">
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Keterangan / Feedback</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #1e293b; line-height: 1.6;">{{ $penilaian->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="padding: 1rem 0; color: #64748b; font-weight: 600;">Dinilai oleh</th>
                    <td style="padding: 1rem 0; font-weight: 500; color: #1e293b;">
                        <i class="fas fa-user-tie text-muted mr-1"></i> {{ $penilaian->pembimbing?->nama ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        
        <a href="{{ route('peserta.sertifikat') }}" class="action-button" style="background: #16a34a; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.2);">
            <i class="fas fa-download"></i> Unduh Sertifikat
        </a>
        @else
        <div class="alert-toast alert-toast-danger" style="background: #fffbeb; border-color: #fde68a; color: #d97706;">
            <i class="fas fa-info-circle"></i> Nilai belum tersedia. Hubungi pembimbing Anda untuk informasi lebih lanjut.
        </div>
        @endif
    </div>
</div>
@endsection
