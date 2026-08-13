<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Nilai PKL - {{ $peserta->nama }}</title>
    <style>
        @page {
            margin: 2.5cm 2.5cm 2.5cm 2.5cm;
            size: A4 portrait;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
        }
        .title-header {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 25px;
            text-transform: uppercase;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            font-size: 11pt;
            font-weight: bold;
        }
        .meta-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }
        .score-table th, .score-table td {
            border: 1px solid #000;
            padding: 7px 10px;
            font-size: 10.5pt;
        }
        .score-table th {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #ffffff;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signature-box {
            float: right;
            width: 260px;
            text-align: center;
        }
        .signature-space {
            height: 65px;
        }
    </style>
</head>
<body>

    @php
        if (!function_exists('terbilangAngka')) {
            function terbilangAngka($angka) {
                $angka = (int) round($angka);
                $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
                
                if ($angka < 12) {
                    return $baca[$angka];
                } elseif ($angka < 20) {
                    return terbilangAngka($angka - 10) . ' Belas';
                } elseif ($angka < 100) {
                    return terbilangAngka(floor($angka / 10)) . ' Puluh' . ($angka % 10 != 0 ? ' ' . terbilangAngka($angka % 10) : '');
                } elseif ($angka < 200) {
                    return 'Seratus' . ($angka - 100 != 0 ? ' ' . terbilangAngka($angka - 100) : '');
                } elseif ($angka < 1000) {
                    return terbilangAngka(floor($angka / 100)) . ' Ratus' . ($angka % 100 != 0 ? ' ' . terbilangAngka($angka % 100) : '');
                }
                return (string)$angka;
            }
        }

        $kedisiplinan   = $penilaian->kedisiplinan ?? 88;
        $kerapian      = $penilaian->kerapian ?? 86;
        $kebersihan    = $penilaian->kebersihan ?? 86;
        $tanggungjawab = $penilaian->tanggung_jawab ?? 86;
        $kerjasama     = $penilaian->kerjasama ?? 87;
        $kreativitas   = $penilaian->kreativitas ?? 87;
        $kejujuran     = $penilaian->kejujuran ?? 86;

        $jumlah = $kedisiplinan + $kerapian + $kebersihan + $tanggungjawab + $kerjasama + $kreativitas + $kejujuran;
        $rataRata = round($jumlah / 7, 2);
    @endphp

    <!-- HEADER TITLE -->
    <div class="title-header">
        DAFTAR NILAI MAHASISWA<br>
        PRAKTIK KERJA LAPANGAN
    </div>

    <!-- METADATA PESERTA -->
    <table class="meta-table">
        <tr>
            <td width="30%">NAMA</td>
            <td width="3%">:</td>
            <td width="67%">{{ strtoupper($peserta->nama) }}</td>
        </tr>
        <tr>
            <td>JURUSAN/PROGRAM STUDI</td>
            <td>:</td>
            <td>{{ strtoupper($peserta->jurusan ?? '-') }}</td>
        </tr>
        <tr>
            <td>TEMPAT PKL</td>
            <td>:</td>
            <td>Dinas Pendidikan Provinsi Sumatera Selatan</td>
        </tr>
    </table>

    <!-- TABEL PENILAIAN -->
    <table class="score-table">
        <thead>
            <tr>
                <th width="8%">NO</th>
                <th width="47%">BIDANG PEKERJAAN<br>YANG DILATIHKAN</th>
                <th width="20%">DENGAN<br>ANGKA</th>
                <th width="25%">DENGAN HURUF</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Kedisiplinan</td>
                <td class="text-center">{{ $kedisiplinan }}</td>
                <td class="text-center">{{ terbilangAngka($kedisiplinan) }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Kerapian</td>
                <td class="text-center">{{ $kerapian }}</td>
                <td class="text-center">{{ terbilangAngka($kerapian) }}</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Kebersihan</td>
                <td class="text-center">{{ $kebersihan }}</td>
                <td class="text-center">{{ terbilangAngka($kebersihan) }}</td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Tanggung jawab</td>
                <td class="text-center">{{ $tanggungjawab }}</td>
                <td class="text-center">{{ terbilangAngka($tanggungjawab) }}</td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Kerjasama</td>
                <td class="text-center">{{ $kerjasama }}</td>
                <td class="text-center">{{ terbilangAngka($kerjasama) }}</td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>Kreativitas</td>
                <td class="text-center">{{ $kreativitas }}</td>
                <td class="text-center">{{ terbilangAngka($kreativitas) }}</td>
            </tr>
            <tr>
                <td class="text-center">7</td>
                <td>Kejujuran</td>
                <td class="text-center">{{ $kejujuran }}</td>
                <td class="text-center">{{ terbilangAngka($kejujuran) }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-bold">JUMLAH</td>
                <td class="text-center text-bold">{{ $jumlah }}</td>
                <td class="text-center text-bold">{{ terbilangAngka($jumlah) }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-bold">RATA-RATA</td>
                <td class="text-center text-bold">{{ $rataRata }}</td>
                <td class="text-center text-bold">{{ terbilangAngka($rataRata) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- SIGNATURE SECTION -->
    <table class="signature-table">
        <tr>
            <td width="50%"></td>
            <td width="50%">
                <div class="signature-box">
                    Palembang, {{ now()->translatedFormat('d F Y') }}<br>
                    Pembimbing Magang Lapangan,<br>
                    <div class="signature-space"></div>
                    <strong><u>{{ $peserta->pembimbing?->nama ?? 'Pembimbing Lapangan' }}</u></strong><br>
                    NIP. {{ $peserta->pembimbing?->nip ?? '--------------------' }}
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
