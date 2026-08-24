<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan LoA - {{ $pengajuan->nama_instansi }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm 1.5cm 2.2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.35;
            color: #000;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo {
            width: 78px;
            height: auto;
        }
        .header-text {
            text-align: center;
        }
        .header-text h3 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header-text h2 {
            margin: 2px 0;
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header-text p {
            margin: 0;
            font-size: 8.5pt;
            line-height: 1.3;
        }
        .header-line {
            border-bottom: 3px double #000;
            margin-bottom: 12px;
            margin-top: 4px;
        }
        .date-box {
            text-align: right;
            margin-bottom: 10px;
            font-size: 11pt;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 11pt;
        }
        .meta-table td {
            vertical-align: top;
            padding: 1px 0;
        }
        .content {
            text-align: justify;
            font-size: 11pt;
            line-height: 1.4;
        }
        .content p {
            margin-bottom: 8px;
            text-indent: 38px;
        }
        .ketentuan-list {
            margin: 4px 0 10px 0;
            padding-left: 20px;
            text-align: justify;
        }
        .ketentuan-list li {
            margin-bottom: 5px;
            padding-left: 4px;
            line-height: 1.35;
        }
        .signature-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .signature-box {
            text-align: center;
            width: 250px;
            float: right;
        }
        .tembusan {
            margin-top: 15px;
            font-size: 9.5pt;
            line-height: 1.3;
        }
        .tembusan ol {
            margin: 2px 0 0 0;
            padding-left: 18px;
        }
    </style>
</head>
<body>

    @php
        $logoSumselPath = public_path('images/logo_sumsel.png');
        if (!file_exists($logoSumselPath)) {
            $logoSumselPath = public_path('images/logo_sumsel.jpg');
        }
        $logoSumselSrc = file_exists($logoSumselPath)
            ? 'data:image/' . (pathinfo($logoSumselPath, PATHINFO_EXTENSION) === 'png' ? 'png' : 'jpeg') . ';base64,' . base64_encode(file_get_contents($logoSumselPath))
            : '';

        $stempelPath = public_path('images/stempel_ttd_disdik.png');
        $stempelSrc = file_exists($stempelPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($stempelPath))
            : '';

        $romawiMap = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulanRomawi = $romawiMap[(int)date('n')];

        $pesertaPertama = $pengajuan->pesertas->first();
        $bidangPenempatan = $pesertaPertama?->bidang?->nama;
    @endphp

    <!-- KOP SURAT RESMI PEMERINTAH PROVINSI SUMATERA SELATAN -->
    <table class="header-table">
        <tr>
            <td width="14%" style="text-align: center; vertical-align: middle;">
                @if($logoSumselSrc)
                    <img src="{{ $logoSumselSrc }}" class="logo" alt="Logo Sumsel">
                @else
                    <img src="{{ public_path('images/logo_sumsel.png') }}" class="logo" alt="Logo Sumsel" onerror="this.style.display='none'">
                @endif
            </td>
            <td width="86%" class="header-text">
                <h3>PEMERINTAH PROVINSI SUMATERA SELATAN</h3>
                <h2>DINAS PENDIDIKAN</h2>
                <p>Jalan Kapten A. Rivai No. 47 Palembang, Provinsi Sumatera Selatan</p>
                <p>Telepon (0711) 354137 – 311089, Faksmile (0711) 311089 Kode Pos 30126</p>
                <p>Laman: http://disdikss.sumselprov.go.id, Pos-el: disdiksumselprov47@gmail.com</p>
            </td>
        </tr>
    </table>
    <div class="header-line"></div>

    <!-- TANGGAL SURAT -->
    <div class="date-box">
        {{ now()->translatedFormat('d F Y') }}
    </div>

    <!-- METADATA SURAT -->
    <table class="meta-table">
        <tr>
            <td width="12%">Nomor</td>
            <td width="2%">:</td>
            <td width="86%">420/{{ 10000 + $pengajuan->id }}/Set.3-Disdik.SS/{{ $bulanRomawi }}/{{ date('Y') }}</td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>:</td>
            <td>Biasa</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td><strong>Praktek Kerja Lapangan</strong></td>
        </tr>
    </table>

    <!-- TUJUAN SURAT -->
    <div style="margin-top: 10px; margin-bottom: 12px; font-size: 11pt; line-height: 1.35;">
        Yth. Pimpinan / Dekan / Kepala {{ $pengajuan->instansi?->nama ?? $pengajuan->nama_instansi }}<br>
        di<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Palembang</strong>
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p>
            Memperhatikan permohonan magang dari {{ $pengajuan->instansi?->nama ?? $pengajuan->nama_instansi }} perihal Permohonan Izin Magang / Praktek Kerja Lapangan (PKL). Kami pada prinsipnya menyetujui Mahasiswa / Siswa tersebut ({{ $pengajuan->pic_nama }}@if($pengajuan->pesertas->count() > 1) dkk ({{ $pengajuan->pesertas->count() }} orang)@endif) untuk melaksanakan Praktek Kerja Lapangan di Dinas Pendidikan Provinsi Sumatera Selatan dengan ketentuan sebagai berikut :
        </p>

        <ol class="ketentuan-list">
            <li>
                Untuk Pengaturan jadwal dan tugas dapat diatur bersama dengan Bidang {{ $bidangPenempatan ?? 'Umum dan Kepegawaian' }} Dinas Pendidikan Provinsi Sumatera Selatan terhitung tanggal {{ $pengajuan->tgl_mulai?->translatedFormat('d F Y') }} s/d {{ $pengajuan->tgl_selesai?->translatedFormat('d F Y') }};
            </li>
            <li>
                Setelah selesai melaksanakan Praktek Kerja Lapangan agar menyampaikan laporan kepada kami;
            </li>
            <li>
                Tetap mematuhi dan mempedomani Tata Tertib serta Disiplin Kerja yang telah ditetapkan oleh Pemerintah;
            </li>
            <li>
                Pengambilan data di Dinas Pendidikan Provinsi Sumatera Selatan tidak untuk dipublikasi, hanya untuk kepentingan sendiri;
            </li>
            <li>
                Agar setiap Mahasiswa / Siswa membuat surat pernyataan cukup diatas materai dan diketahui oleh pihak Unit Kerja asal yang isinya akan mematuhi semua peraturan yang telah ditetapkan pada Dinas Pendidikan Provinsi Sumatera Selatan.
            </li>
        </ol>

        <p style="text-indent: 0; margin-top: 8px; margin-bottom: 12px;">
            Demikian atas kerjasamanya diucapkan terima kasih.
        </p>
    </div>

    <!-- TANDA TANGAN PLT. SEKRETARIS & STEMPEL RESMI -->
    <table class="signature-table">
        <tr>
            <td width="50%">
                <!-- TEMBUSAN -->
                <div class="tembusan">
                    <strong>Tembusan:</strong>
                    <ol>
                        <li>Kepala Dinas Pendidikan Provinsi Sumatera Selatan;</li>
                        <li>Kasubbag Umum dan Kepegawaian;</li>
                        <li>Arsip.</li>
                    </ol>
                </div>
            </td>
            <td width="50%">
                <div class="signature-box">
                    <div>Plt. Sekretaris,</div>
                    <div style="height: 75px; margin: 3px 0; position: relative;">
                        @if($stempelSrc)
                            <img src="{{ $stempelSrc }}" style="height: 75px; width: auto; display: inline-block;" alt="Stempel & TTD">
                        @else
                            <div style="height: 65px;"></div>
                        @endif
                    </div>
                    <div style="font-weight: bold; font-size: 11pt; text-decoration: underline;">Dra. Poniyem, M.Pd.</div>
                    <div style="font-size: 10pt;">Pembina Tingkat I, IV/b</div>
                    <div style="font-size: 10pt;">NIP 196812261994032001</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
