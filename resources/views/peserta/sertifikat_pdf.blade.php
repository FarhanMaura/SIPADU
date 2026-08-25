<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Piagam Penghargaan &amp; Daftar Nilai - {{ $peserta->nama }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            height: 100%;
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            background: #ffffff;
            font-size: 10pt;
        }

        /* ================= PAGE 1: HALAMAN DEPAN (PIAGAM PENGHARGAAN) ================= */
        .page-1-table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
            background-color: #f3c72b;
            page-break-after: always;
        }

        .page-1-cell {
            padding: 2.5mm 3.5mm;
            vertical-align: middle;
        }

        .cert-frame-outer {
            background-color: #d4990a;
            border: 3px solid #78350f;
            padding: 2mm;
        }

        .cert-frame-inner {
            background-color: #fffef5;
            border: 1.5px solid #92400e;
            padding: 4mm 7mm 3.5mm 7mm;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            padding: 0;
        }

        .logo-col {
            width: 80px;
            text-align: left;
        }

        .logo-col img {
            width: 72px;
            height: auto;
            display: block;
        }

        .kop-text-col {
            text-align: center;
        }

        .provinsi-text {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #111827;
            letter-spacing: 0.5px;
            line-height: 1.15;
        }

        .dinas-text {
            font-size: 20pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #111827;
            letter-spacing: 1.5px;
            line-height: 1.15;
            margin-top: 1px;
        }

        .alamat-text {
            font-size: 8.5pt;
            font-style: italic;
            color: #374151;
            margin-top: 1px;
        }

        .spacer-col {
            width: 80px;
        }

        .divider-line {
            border-top: 2.5px solid #78350f;
            border-bottom: 1px solid #78350f;
            height: 3px;
            margin: 3px 0 5px 0;
        }

        .title-wrapper {
            text-align: center;
            margin: 2px 0 5px 0;
        }

        .title-wrapper h1 {
            font-size: 24pt;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 0;
            color: #111827;
            text-transform: uppercase;
        }

        .title-wrapper .nomor-surat {
            font-size: 10.5pt;
            font-style: italic;
            font-weight: bold;
            margin-top: 1px;
            color: #1f2937;
        }

        .white-card {
            background-color: #ffffff;
            border: 1.5px solid #ca8a04;
            border-radius: 10px;
            padding: 5mm 9mm 4mm 9mm;
        }

        .intro-sentence {
            font-size: 11pt;
            color: #000;
            margin-bottom: 3px;
            line-height: 1.25;
        }

        .peserta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            color: #000;
            margin: 4px 0 6px 0;
        }

        .peserta-table td {
            padding: 2.5px 0;
            vertical-align: top;
        }

        .peserta-table .label-cell {
            width: 25%;
        }

        .peserta-table .colon-cell {
            width: 3%;
        }

        .peserta-table .value-cell {
            width: 72%;
            font-weight: bold;
            text-transform: uppercase;
        }

        .narration-sentence {
            font-size: 10.5pt;
            line-height: 1.5;
            text-align: justify;
            color: #000;
            margin-bottom: 6px;
        }

        .ttd-layout-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-layout-table td {
            padding: 0;
            vertical-align: top;
        }

        .ttd-left-space {
            width: 55%;
        }

        .ttd-right-box {
            width: 45%;
            text-align: center;
            font-size: 10pt;
            color: #000;
            line-height: 1.25;
        }

        .stamp-sig-wrap {
            height: 58px;
            margin: 1px 0;
            text-align: center;
        }

        .stamp-sig-wrap img {
            height: 58px;
            max-width: 180px;
            object-fit: contain;
        }

        /* ================= PAGE 2: HALAMAN BELAKANG (DAFTAR NILAI) ================= */
        .page-2-table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        .page-2-cell {
            padding: 3mm 4mm;
            vertical-align: middle;
        }

        .page-2-border {
            border: 2.5px solid #334155;
            padding: 6mm 10mm;
        }

        .title-back-area {
            text-align: center;
            font-weight: bold;
            font-size: 13.5pt;
            margin-bottom: 8px;
            line-height: 1.3;
            text-transform: uppercase;
            color: #0f172a;
        }

        .meta-info-table {
            width: 100%;
            border-collapse: collapse;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .meta-info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .score-data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin: 8px 0 10px 0;
        }

        .score-data-table th,
        .score-data-table td {
            border: 1px solid #000;
            padding: 4px 6px;
        }

        .score-data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            font-size: 9pt;
        }

        .score-data-table .text-center {
            text-align: center;
        }

        .score-data-table .font-bold {
            font-weight: bold;
        }

        .score-data-table .bg-total {
            background-color: #f8fafc;
        }

        .score-data-table .bg-final {
            background-color: #e0f2fe;
        }

        .footer-eval-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-top: 10px;
        }

        .footer-eval-table td {
            vertical-align: top;
            padding: 0;
        }

        .alert-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #d97706;
            padding: 15px 20px;
            border-radius: 8px;
            font-family: sans-serif;
            margin: 20px;
        }
    </style>
</head>
<body>

@if($peserta && $penilaian)

@php
    if (!function_exists('terbilangAngkaSertifikat')) {
        function terbilangAngkaSertifikat($angka) {
            $angka = (int) round($angka);
            $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
            if ($angka < 12) return $baca[$angka];
            elseif ($angka < 20) return terbilangAngkaSertifikat($angka - 10) . ' Belas';
            elseif ($angka < 100) return terbilangAngkaSertifikat(floor($angka / 10)) . ' Puluh' . ($angka % 10 != 0 ? ' ' . terbilangAngkaSertifikat($angka % 10) : '');
            elseif ($angka < 200) return 'Seratus' . ($angka - 100 != 0 ? ' ' . terbilangAngkaSertifikat($angka - 100) : '');
            elseif ($angka < 1000) return terbilangAngkaSertifikat(floor($angka / 100)) . ' Ratus' . ($angka % 100 != 0 ? ' ' . terbilangAngkaSertifikat($angka % 100) : '');
            return (string)$angka;
        }
    }

    $kedisiplinan   = $penilaian->kedisiplinan ?? 88;
    $kerapian       = $penilaian->kerapian ?? 86;
    $kebersihan     = $penilaian->kebersihan ?? 86;
    $tanggungjawab  = $penilaian->tanggung_jawab ?? 86;
    $kerjasama      = $penilaian->kerjasama ?? 87;
    $kreativitas    = $penilaian->kreativitas ?? 87;
    $kejujuran      = $penilaian->kejujuran ?? 86;

    $jumlah = $kedisiplinan + $kerapian + $kebersihan + $tanggungjawab + $kerjasama + $kreativitas + $kejujuran;
    $rataRata = round($jumlah / 7, 2);

    $predikat = 'Baik';
    if ($rataRata >= 90) {
        $predikat = 'Amat Baik';
    } elseif ($rataRata >= 80) {
        $predikat = 'Baik';
    } elseif ($rataRata >= 70) {
        $predikat = 'Cukup';
    } else {
        $predikat = 'Kurang';
    }

    // LOGO SUMSEL BASE64
    $logoSumselPath = public_path('images/logo_sumsel.png');
    if (!file_exists($logoSumselPath)) {
        $logoSumselPath = public_path('images/logo_sumsel.jpg');
    }
    $logoSumselSrc = file_exists($logoSumselPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoSumselPath))
        : '';

    // STEMPEL & TTD RESMI BASE64
    $ttdPath = public_path('images/stempel_ttd_disdik.png');
    if (!file_exists($ttdPath)) {
        $ttdPath = public_path('images/ttd_stempel_disdik.png');
    }
    $ttdSrc = file_exists($ttdPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($ttdPath))
        : '';

    $tglMulaiFormatted = $peserta->tgl_mulai ? \Carbon\Carbon::parse($peserta->tgl_mulai)->translatedFormat('d F Y') : '01 Januari 2026';
    $tglSelesaiFormatted = $peserta->tgl_selesai ? \Carbon\Carbon::parse($peserta->tgl_selesai)->translatedFormat('d F Y') : '31 Desember 2026';
    $tglSertifikatFormatted = $penilaian->created_at ? \Carbon\Carbon::parse($penilaian->created_at)->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
    
    // Nomor Sertifikat
    $nomorRaw = $penilaian->no_sertifikat ?? $peserta->no_sertifikat ?? '5152';
    $noSertifikat = str_contains($nomorRaw, '/') ? $nomorRaw : "420/{$nomorRaw}/Set.3-Disdik.SS/III/2026";
@endphp

<!-- ========================================================= -->
<!-- HALAMAN DEPAN: PIAGAM PENGHARGAAN -->
<!-- ========================================================= -->
<table class="page-1-table">
    <tr>
        <td class="page-1-cell">
            <div class="cert-frame-outer">
                <div class="cert-frame-inner">
                    <!-- HEADER TABLE -->
                    <table class="header-table">
                        <tr>
                            <td class="logo-col">
                                @if($logoSumselSrc)
                                    <img src="{{ $logoSumselSrc }}" alt="Logo Sumatera Selatan">
                                @endif
                            </td>
                            <td class="kop-text-col">
                                <div class="provinsi-text">PEMERINTAH PROVINSI SUMATERA SELATAN</div>
                                <div class="dinas-text">DINAS PENDIDIKAN</div>
                                <div class="alamat-text">Jalan Kapten A. Rivai No. 47 Palembang, Pos-el: disdiksumselprov47@gmail.com</div>
                            </td>
                            <td class="spacer-col"></td>
                        </tr>
                    </table>

                    <div class="divider-line"></div>

                    <!-- TITLE -->
                    <div class="title-wrapper">
                        <h1>PIAGAM PENGHARGAAN</h1>
                        <div class="nomor-surat">Nomor: {{ $noSertifikat }}</div>
                    </div>

                    <!-- WHITE BOX -->
                    <div class="white-card">
                        <div class="intro-sentence">
                            Kepala Dinas Pendidikan Provinsi Sumatera Selatan memberikan penghargaan kepada:
                        </div>

                        <table class="peserta-table">
                            <tbody>
                                <tr>
                                    <td class="label-cell">Nama</td>
                                    <td class="colon-cell">:</td>
                                    <td class="value-cell">{{ strtoupper($peserta->nama) }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">NISN / NIM</td>
                                    <td class="colon-cell">:</td>
                                    <td class="value-cell" style="text-transform: none;">{{ $peserta->nim_nisn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Asal Sekolah / Perguruan Tinggi</td>
                                    <td class="colon-cell">:</td>
                                    <td class="value-cell">{{ strtoupper($peserta->instansi?->nama ?? $peserta->asal_sekolah ?? '-') }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Jurusan / Program Studi</td>
                                    <td class="colon-cell">:</td>
                                    <td class="value-cell">{{ strtoupper($peserta->jurusan ?? '-') }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="narration-sentence">
                            yang telah mengikuti program pelatihan dalam pelaksanaan <strong>Praktik Kerja Lapangan (PKL) / Magang</strong> di Dinas Pendidikan
                            Provinsi Sumatera Selatan yang dilaksanakan dari tanggal {{ $tglMulaiFormatted }} sampai dengan {{ $tglSelesaiFormatted }} dengan predikat kelulusan <strong>{{ strtoupper($predikat) }}</strong>.
                        </div>

                        <!-- TANDA TANGAN -->
                        <table class="ttd-layout-table">
                            <tr>
                                <td class="ttd-left-space"></td>
                                <td class="ttd-right-box">
                                    Palembang, {{ $tglSertifikatFormatted }}<br>
                                    a.n. <strong>Kepala Dinas Pendidikan</strong><br>
                                    <strong>Plt. Sekretaris,</strong><br>

                                    <div class="stamp-sig-wrap">
                                        @if($ttdSrc)
                                            <img src="{{ $ttdSrc }}" alt="Stempel & TTD">
                                        @else
                                            <div style="height: 58px;"></div>
                                        @endif
                                    </div>

                                    <strong><u>Dra. PONIYEM, M.Pd.</u></strong><br>
                                    Pembina Utama Muda, IV/c<br>
                                    NIP. 196806042008012016
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>

<!-- ========================================================= -->
<!-- HALAMAN BELAKANG: DAFTAR NILAI -->
<!-- ========================================================= -->
<table class="page-2-table">
    <tr>
        <td class="page-2-cell">
            <div class="page-2-border">
                <div class="title-back-area">
                    DAFTAR NILAI PRAKTIK KERJA LAPANGAN (PKL)<br>DINAS PENDIDIKAN PROVINSI SUMATERA SELATAN
                </div>

                <table class="meta-info-table">
                    <tbody>
                        <tr>
                            <td style="width: 28%; padding: 2px 0;">NAMA</td>
                            <td style="width: 2%;">:</td>
                            <td style="width: 70%;">{{ strtoupper($peserta->nama) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0;">NISN / NIM</td>
                            <td>:</td>
                            <td>{{ $peserta->nim_nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0;">JURUSAN / PROGRAM STUDI</td>
                            <td>:</td>
                            <td>{{ strtoupper($peserta->jurusan ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0;">TEMPAT MAGANG / PKL</td>
                            <td>:</td>
                            <td>Dinas Pendidikan Provinsi Sumatera Selatan</td>
                        </tr>
                    </tbody>
                </table>

                <table class="score-data-table">
                    <thead>
                        <tr>
                            <th style="width: 7%;">NO</th>
                            <th style="width: 45%;">BIDANG PEKERJAAN / ASPEK PENILAIAN</th>
                            <th style="width: 18%;">NILAI ANGKA</th>
                            <th style="width: 30%;">DENGAN HURUF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Kedisiplinan</td>
                            <td class="text-center font-bold">{{ $kedisiplinan }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($kedisiplinan) }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Kerapian</td>
                            <td class="text-center font-bold">{{ $kerapian }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($kerapian) }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Kebersihan</td>
                            <td class="text-center font-bold">{{ $kebersihan }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($kebersihan) }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>Tanggung Jawab</td>
                            <td class="text-center font-bold">{{ $tanggungjawab }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($tanggungjawab) }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td>Kerjasama</td>
                            <td class="text-center font-bold">{{ $kerjasama }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($kerjasama) }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td>Kreativitas</td>
                            <td class="text-center font-bold">{{ $kreativitas }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($kreativitas) }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td>Kejujuran</td>
                            <td class="text-center font-bold">{{ $kejujuran }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($kejujuran) }}</td>
                        </tr>
                        <tr class="bg-total font-bold">
                            <td colspan="2" class="text-center">JUMLAH</td>
                            <td class="text-center font-bold">{{ $jumlah }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($jumlah) }}</td>
                        </tr>
                        <tr class="bg-final font-bold">
                            <td colspan="2" class="text-center">RATA-RATA (NILAI AKHIR)</td>
                            <td class="text-center font-bold">{{ $rataRata }}</td>
                            <td class="text-center">{{ terbilangAngkaSertifikat($rataRata) }} ({{ $predikat }})</td>
                        </tr>
                    </tbody>
                </table>

                <!-- TTD PEMBIMBING LAPANGAN -->
                <table class="footer-eval-table">
                    <tr>
                        <td style="width: 55%;">
                            <div style="font-size: 8.5pt; color: #475569; padding-top: 4px; line-height: 1.35;">
                                <strong>Keterangan Predikat:</strong><br>
                                85 - 100 : Amat Baik (A)<br>
                                75 - 84 &nbsp; : Baik (B)<br>
                                60 - 74 &nbsp; : Cukup (C)
                            </div>
                        </td>
                        <td style="width: 45%; text-align: center;">
                            Palembang, {{ $tglSertifikatFormatted }}<br>
                            Pembimbing Lapangan,<br>
                            <div style="height: 48px;"></div>
                            <strong><u>{{ $peserta->pembimbing?->nama ?? 'Pembimbing Lapangan' }}</u></strong><br>
                            NIP. {{ $peserta->pembimbing?->nip ?? '-' }}
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

@elseif(!$penilaian)
<div class="alert-box">
    ⚠️ Sertifikat belum dapat diunduh karena penilaian belum diinput oleh pembimbing.
</div>
@else
<div class="alert-box">
    ❌ Data peserta tidak ditemukan.
</div>
@endif

</body>
</html>