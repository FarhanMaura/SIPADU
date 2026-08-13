<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Piagam Penghargaan &amp; Daftar Nilai - {{ $peserta->nama }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background: #ffffff;
            color: #000;
        }

        /* ================= PAGE 1: HALAMAN DEPAN (PIAGAM PENGHARGAAN) ================= */
        .page-front {
            width: 297mm;
            height: 210mm;
            padding: 6mm 10mm;
            box-sizing: border-box;
            background: #ebba16;
            page-break-after: always;
            overflow: hidden;
        }

        .sertifikat-front {
            background: linear-gradient(160deg, #f7c93a 0%, #e8b020 40%, #d4990a 100%);
            border-radius: 8px;
            padding: 16px 22px;
            position: relative;
            border: 3px solid #c9960b;
            height: 198mm;
            overflow: hidden;
        }

        /* DOUBLE BORDER DALAM */
        .border-inner {
            position: absolute;
            top: 6px; left: 6px; right: 6px; bottom: 6px;
            border: 1.5px solid rgba(180, 130, 10, 0.5);
            border-radius: 4px;
            pointer-events: none;
        }

        .border-inner2 {
            position: absolute;
            top: 9px; left: 9px; right: 9px; bottom: 9px;
            border: 1px solid rgba(255, 230, 100, 0.6);
            border-radius: 3px;
            pointer-events: none;
        }

        .content {
            position: relative;
            z-index: 2;
        }

        /* HEADER TABLE: LOGO KIRI, TEKS TENGAH */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 0;
        }

        .header-table .logo-td {
            width: 75px;
            text-align: left;
        }

        .header-table .logo-td img {
            width: 70px;
            height: auto;
            display: block;
        }

        .header-table .text-td {
            text-align: center;
        }

        .header-table .text-td .provinsi {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #1a1a1a;
            letter-spacing: 0.5px;
            line-height: 1.3;
        }

        .header-table .text-td .dinas {
            font-size: 18.5pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #1a1a1a;
            letter-spacing: 1.5px;
            line-height: 1.2;
            margin-top: 2px;
        }

        .header-table .spacer-td {
            width: 75px;
        }

        /* DIVIDER */
        .divider {
            border-top: 2.5px solid #8a6000;
            border-bottom: 1px solid rgba(139, 96, 0, 0.4);
            height: 4px;
            margin-bottom: 8px;
        }

        /* TITLE */
        .title {
            text-align: center;
            margin-bottom: 8px;
        }

        .title h1 {
            font-size: 22pt;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 0;
            color: #1a1a1a;
            text-transform: uppercase;
        }

        .title .nomor {
            font-size: 10.5pt;
            font-style: italic;
            font-weight: bold;
            margin-top: 2px;
            color: #1a1a1a;
        }

        /* WHITE BOX */
        .white-box {
            background: #ffffff;
            border-radius: 14px;
            padding: 14px 22px 12px 22px;
            position: relative;
        }

        .intro {
            font-size: 10.5pt;
            color: #000;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
            color: #000;
            margin-bottom: 8px;
        }

        .detail-table td {
            padding: 2.5px 0;
            vertical-align: top;
        }

        .detail-table .lbl {
            width: 22%;
            font-weight: normal;
        }

        .detail-table .cln {
            width: 3%;
            font-weight: normal;
        }

        .detail-table .val {
            width: 75%;
            font-weight: bold;
            text-transform: uppercase;
        }

        .narration {
            font-size: 10pt;
            line-height: 1.5;
            text-align: justify;
            color: #000;
            margin-bottom: 10px;
        }

        /* TTD TABLE */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            padding: 0;
            vertical-align: top;
        }

        .ttd-table .left {
            width: 55%;
        }

        .ttd-table .right {
            width: 45%;
            text-align: center;
            font-size: 10pt;
            color: #000;
        }

        .stamp-sig-box {
            height: 48px;
            position: relative;
            margin: 2px 0;
        }

        /* ================= PAGE 2: HALAMAN BELAKANG (DAFTAR NILAI) ================= */
        .page-back {
            width: 297mm;
            height: 210mm;
            padding: 12mm 18mm;
            box-sizing: border-box;
            background: #ffffff;
            overflow: hidden;
        }

        .sertifikat-back {
            background: #ffffff;
            color: #000;
        }

        .title-back {
            text-align: center;
            font-weight: bold;
            font-size: 13.5pt;
            margin-bottom: 14px;
            line-height: 1.4;
            text-transform: uppercase;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            font-weight: bold;
            font-size: 10.5pt;
            margin-bottom: 12px;
        }

        .meta-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .score-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            table-layout: fixed;
        }

        .score-table th,
        .score-table td {
            border: 1px solid #000;
            padding: 5.5px 8px;
            word-wrap: break-word;
        }

        .score-table th {
            background: #f8fafc;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .score-table .text-left {
            text-align: left;
        }

        .score-table .text-center {
            text-align: center;
        }

        .score-table .bg-light {
            background: #f8fafc;
        }

        .score-table .bg-blue-light {
            background: #eff6ff;
        }

        .score-table .font-bold {
            font-weight: bold;
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
    if (!function_exists('terbilangAngkaFinalPdf')) {
        function terbilangAngkaFinalPdf($angka) {
            $angka = (int) round($angka);
            $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
            if ($angka < 12) return $baca[$angka];
            elseif ($angka < 20) return terbilangAngkaFinalPdf($angka - 10) . ' Belas';
            elseif ($angka < 100) return terbilangAngkaFinalPdf(floor($angka / 10)) . ' Puluh' . ($angka % 10 != 0 ? ' ' . terbilangAngkaFinalPdf($angka % 10) : '');
            elseif ($angka < 200) return 'Seratus' . ($angka - 100 != 0 ? ' ' . terbilangAngkaFinalPdf($angka - 100) : '');
            elseif ($angka < 1000) return terbilangAngkaFinalPdf(floor($angka / 100)) . ' Ratus' . ($angka % 100 != 0 ? ' ' . terbilangAngkaFinalPdf($angka % 100) : '');
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

    // LOGO
    $logoSumselSvgPath = public_path('images/logosumsel_resmi.svg');
    $logoSumselFallbackPath = public_path('images/logo_sumsel.svg');
    if (file_exists($logoSumselSvgPath)) {
        $logoSumselSrc = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoSumselSvgPath));
    } elseif (file_exists($logoSumselFallbackPath)) {
        $logoSumselSrc = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoSumselFallbackPath));
    } else {
        $logoSumselSrc = asset('images/logosumsel_resmi.svg');
    }

    // WATERMARK
    $tutwuriJpgPath = public_path('images/tutwuri_handayani.jpg');
    $tutwuriSvgPath = public_path('images/tutwuri_watermark.svg');
    if (file_exists($tutwuriJpgPath)) {
        $tutwuriSrc = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($tutwuriJpgPath));
    } elseif (file_exists($tutwuriSvgPath)) {
        $tutwuriSrc = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($tutwuriSvgPath));
    } else {
        $tutwuriSrc = asset('images/tutwuri_handayani.jpg');
    }

    $tglMulaiFormatted = $peserta->tgl_mulai ? \Carbon\Carbon::parse($peserta->tgl_mulai)->translatedFormat('d F Y') : '16 Oktober 2025';
    $tglSelesaiFormatted = $peserta->tgl_selesai ? \Carbon\Carbon::parse($peserta->tgl_selesai)->translatedFormat('d F Y') : '31 Desember 2025';
    $tglSertifikatFormatted = $penilaian->created_at ? \Carbon\Carbon::parse($penilaian->created_at)->translatedFormat('d F Y') : '10 Maret 2026';
    $noSertifikat = $peserta->no_sertifikat ?? '420/5679/Set.3-Disdik.SS/III/2026';
@endphp

<!-- ========================================================= -->
<!-- HALAMAN DEPAN: PIAGAM PENGHARGAAN -->
<!-- ========================================================= -->
<div class="page-front">
    <div class="sertifikat-front">
        <div class="border-inner"></div>
        <div class="border-inner2"></div>

        <div class="content">
            <!-- HEADER TABLE -->
            <table class="header-table">
                <tr>
                    <td class="logo-td">
                        <img src="{{ $logoSumselSrc }}" alt="Logo Sumatera Selatan">
                    </td>
                    <td class="text-td">
                        <div class="provinsi">PEMERINTAH PROVINSI SUMATERA SELATAN</div>
                        <div class="dinas">DINAS PENDIDIKAN</div>
                    </td>
                    <td class="spacer-td"></td>
                </tr>
            </table>

            <div class="divider"></div>

            <!-- TITLE -->
            <div class="title">
                <h1>PIAGAM PENGHARGAAN</h1>
                <div class="nomor">Nomor: {{ $noSertifikat }}</div>
            </div>

            <!-- WHITE BOX -->
            <div class="white-area">
                <!-- WATERMARK TUT WURI HANDAYANI (DOMPDF FLOW-BASED) -->
                @if($tutwuriSrc)
                    <div style="text-align: center; margin-bottom: -150px; padding-top: 10px; opacity: 0.10;">
                        <img src="{{ $tutwuriSrc }}" style="width: 170px; height: 170px;" alt="Tut Wuri Handayani">
                    </div>
                @endif

                <div style="position: relative; z-index: 2;">
                    <div class="intro">
                        Kepala Dinas Pendidikan Provinsi Sumatera Selatan memberikan penghargaan kepada:
                    </div>

                    <table class="detail-table">
                        <tbody>
                            <tr>
                                <td class="lbl">Nama</td>
                                <td class="cln">:</td>
                                <td class="val">{{ strtoupper($peserta->nama) }}</td>
                            </tr>
                            <tr>
                                <td class="lbl">NIS/NISN</td>
                                <td class="cln">:</td>
                                <td class="val" style="text-transform: none;">{{ $peserta->nim_nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="lbl">Asal Sekolah</td>
                                <td class="cln">:</td>
                                <td class="val">{{ strtoupper($peserta->instansi?->nama ?? $peserta->asal_sekolah ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td class="lbl">Jurusan/Prodi</td>
                                <td class="cln">:</td>
                                <td class="val">{{ strtoupper($peserta->jurusan ?? '-') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="narration">
                        yang telah mengikuti program pelatihan dalam pelaksanaan Praktik Kerja Lapangan (PKL) di Dinas Pendidikan
                        Provinsi Sumatera Selatan yang dilaksanakan dari tanggal {{ $tglMulaiFormatted }} sampai dengan {{ $tglSelesaiFormatted }}.
                    </div>

                    <!-- TANDA TANGAN -->
                    <table class="ttd-table">
                        <tr>
                            <td class="left"></td>
                            <td class="right">
                                Palembang, {{ $tglSertifikatFormatted }}<br>
                                a.n. <strong>Kepala Dinas Pendidikan</strong><br>
                                <strong>Sekretaris,</strong><br>

                                <div class="stamp-sig-box">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 45%; text-align: center; vertical-align: middle; padding: 0;">
                                                <!-- STEMPEL -->
                                                <div style="
                                                    width: 65px;
                                                    height: 65px;
                                                    border-radius: 50%;
                                                    border: 2px dashed #1d4ed8;
                                                    text-align: center;
                                                    padding: 2px;
                                                    opacity: 0.82;
                                                    display: inline-block;
                                                ">
                                                    <div style="font-size: 4pt; font-weight: bold; color: #1d4ed8; line-height: 1.2;">
                                                        PEMERINTAH<br>PROVINSI<br>
                                                        <span style="display: block; border-top: 1px solid #1d4ed8; margin: 1px 0;"></span>
                                                        SUMATERA<br>SELATAN<br>
                                                        <span style="display: block; border-top: 1px solid #1d4ed8; margin: 1px 0;"></span>
                                                        DINAS PENDIDIKAN
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 55%; text-align: center; vertical-align: middle; padding: 0;">
                                                <!-- TTD SVG -->
                                                <svg viewBox="0 0 110 38" width="100" height="36">
                                                    <path d="M 8 30 C 28 8, 26 34, 44 12 C 55 2, 50 30, 68 16 C 84 6, 76 30, 108 20" fill="none" stroke="#0f172a" stroke-width="2.0" stroke-linecap="round"/>
                                                    <path d="M 28 22 L 85 24" fill="none" stroke="#0f172a" stroke-width="1.5"/>
                                                </svg>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <strong><u>Misral, S.Sn., M.Sn.</u></strong><br>
                                Penata Tingkat I, III/d<br>
                                NIP 196806042008011016
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- HALAMAN BELAKANG: DAFTAR NILAI -->
<!-- ========================================================= -->
<div class="page-back">
    <div class="sertifikat-back">
        <div class="title-back">
            DAFTAR NILAI MAHASISWA<br>PRAKTIK KERJA LAPANGAN
        </div>

        <table class="meta-table">
            <tbody>
                <tr>
                    <td style="width: 30%;">NAMA</td>
                    <td style="width: 3%;">:</td>
                    <td style="width: 67%;">{{ strtoupper($peserta->nama) }}</td>
                </tr>
                <tr>
                    <td>JURUSAN / PROGRAM STUDI</td>
                    <td>:</td>
                    <td>{{ strtoupper($peserta->jurusan ?? '-') }}</td>
                </tr>
                <tr>
                    <td>TEMPAT PKL</td>
                    <td>:</td>
                    <td>Dinas Pendidikan Provinsi Sumatera Selatan</td>
                </tr>
            </tbody>
        </table>

        <table class="score-table">
            <thead>
                <tr>
                    <th style="width: 6%;">NO</th>
                    <th style="width: 44%;">BIDANG PEKERJAAN<br>YANG DILATIHKAN</th>
                    <th style="width: 22%;">DENGAN<br>ANGKA</th>
                    <th style="width: 28%;">DENGAN HURUF</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-left">Kedisiplinan</td>
                    <td class="text-center">{{ $kedisiplinan }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($kedisiplinan) }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td class="text-left">Kerapian</td>
                    <td class="text-center">{{ $kerapian }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($kerapian) }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td class="text-left">Kebersihan</td>
                    <td class="text-center">{{ $kebersihan }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($kebersihan) }}</td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td class="text-left">Tanggung jawab</td>
                    <td class="text-center">{{ $tanggungjawab }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($tanggungjawab) }}</td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td class="text-left">Kerjasama</td>
                    <td class="text-center">{{ $kerjasama }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($kerjasama) }}</td>
                </tr>
                <tr>
                    <td class="text-center">6</td>
                    <td class="text-left">Kreativitas</td>
                    <td class="text-center">{{ $kreativitas }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($kreativitas) }}</td>
                </tr>
                <tr>
                    <td class="text-center">7</td>
                    <td class="text-left">Kejujuran</td>
                    <td class="text-center">{{ $kejujuran }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($kejujuran) }}</td>
                </tr>
                <tr class="bg-light font-bold">
                    <td colspan="2" class="text-left">JUMLAH</td>
                    <td class="text-center">{{ $jumlah }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($jumlah) }}</td>
                </tr>
                <tr class="bg-blue-light font-bold">
                    <td colspan="2" class="text-left">RATA-RATA</td>
                    <td class="text-center">{{ $rataRata }}</td>
                    <td class="text-center">{{ terbilangAngkaFinalPdf($rataRata) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

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