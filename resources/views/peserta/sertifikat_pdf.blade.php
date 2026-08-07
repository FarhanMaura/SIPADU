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
        <div class="header-org">
            DINAS PENDIDIKAN PROVINSI SUMATERA SELATAN
        </div>
        
        <div class="title">SERTIFIKAT MAGANG</div>
        
        <div class="subtitle">Diberikan secara resmi kepada:</div>
        
        <div class="name">{{ $peserta->nama }}</div>
        
        <div class="details">NIM/NIS: {{ $peserta->nim_nisn ?? '-' }} | Jurusan: {{ $peserta->jurusan ?? '-' }} — {{ $peserta->instansi?->nama }}</div>
        
        <div class="description">
            Telah menyelesaikan seluruh rangkaian program magang dengan hasil kualifikasi memuaskan pada <strong>Bidang {{ $peserta->bidang?->nama ?? '-' }}</strong> Dinas Pendidikan Provinsi Sumatera Selatan, yang dilaksanakan pada periode <strong>{{ ($peserta->tgl_mulai ?? $peserta->pengajuan?->tgl_mulai)?->format('d F Y') }}</strong> sampai dengan <strong>{{ ($peserta->tgl_selesai ?? $peserta->pengajuan?->tgl_selesai)?->format('d F Y') }}</strong>.
        </div>
        
        <div class="score-box">
            <span class="score-text">Hasil Penilaian Akhir:</span> <span class="score-number">{{ $penilaian->nilai_angka }} ({{ $penilaian->predikat }})</span>
        </div>
        
        <div class="signature-container">
            <div class="signature-box left">
                <div class="signature-line"></div>
                <div class="signature-name">Kasubbag Umum dan Kepegawaian</div>
                <div class="signature-title">Dinas Pendidikan Prov. Sumsel</div>
            </div>
            <div class="signature-box right">
                <div class="signature-line"></div>
                <div class="signature-name">{{ $peserta->pembimbing?->nama ?? 'Pembimbing Bidang' }}</div>
                <div class="signature-title">Pembimbing Magang Bidang</div>
            </div>
        </div>
    </div>
</body>
</html>
