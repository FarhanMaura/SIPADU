<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Magang - {{ $peserta->nama }}</title>
    <link rel="stylesheet" href="{{ public_path('css/sertifikat_pdf.css') }}">
</head>
<body>
    <div class="container">
        <div class="inner-border"></div>
        <div class="logo">
            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/logo.jpeg'))) }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-bottom: 5px;">
            <br>SIPADU
        </div>
        
        <div class="title">SERTIFIKAT MAGANG</div>
        
        <div class="subtitle">Diberikan secara resmi kepada:</div>
        
        <div class="name">{{ $peserta->nama }}</div>
        
        <div class="details">{{ $peserta->jurusan ?? '' }} - {{ $peserta->instansi?->nama }}</div>
        
        <div class="description">
            Telah menyelesaikan program magang dengan baik di bidang <strong>{{ $peserta->bidang?->nama ?? '-' }}</strong><br>
            yang dilaksanakan pada periode <strong>{{ ($peserta->tgl_mulai ?? $peserta->pengajuan?->tgl_mulai)?->format('d F Y') }}</strong> sampai dengan <strong>{{ ($peserta->tgl_selesai ?? $peserta->pengajuan?->tgl_selesai)?->format('d F Y') }}</strong>.
        </div>
        
        <div class="score-box">
            <span class="score-text">Nilai Akhir:</span> <span class="score-number">{{ $penilaian->nilai_angka }} ({{ $penilaian->predikat }})</span>
        </div>
        
        <div class="signature-area">
            <div class="signature-line"></div>
            <div class="signature-name">{{ $peserta->pembimbing?->nama }}</div>
            <div class="signature-title">Pembimbing Magang</div>
        </div>
    </div>
</body>
</html>
