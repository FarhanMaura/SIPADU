<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan Penolakan Magang - {{ $pengajuan->nama_instansi }}</title>
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
        .alasan-box {
            margin: 6px 0 10px 38px;
            padding: 8px 14px;
            background: #f8fafc;
            border-left: 3px solid #334155;
            font-style: italic;
            font-size: 10.5pt;
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
                <p>Laman: http://disdikss.sumselprov.go.id, Pos-el: wardik.sumsel@gmail.com</p>
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
            <td>Lampiran</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td><strong>Jawaban Permohonan Izin Magang / PKL</strong></td>
        </tr>
    </table>

    <!-- TUJUAN SURAT -->
    <div style="margin-top: 10px; margin-bottom: 12px; font-size: 11pt; line-height: 1.35;">
        Yth. Pimpinan / Dekan / Kepala {{ $pengajuan->instansi?->nama ?? $pengajuan->nama_instansi }}<br>
        di<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tempat</strong>
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p>
            Memperhatikan surat permohonan magang dari {{ $pengajuan->instansi?->nama ?? $pengajuan->nama_instansi }} perihal Permohonan Izin Magang / Praktek Kerja Lapangan (PKL) bagi mahasiswa/siswa atas nama <strong>{{ $pengajuan->pic_nama }}</strong>@if($pengajuan->pesertas->count() > 1) dkk ({{ $pengajuan->pesertas->count() }} orang)@endif (NIM/NIS: {{ $pengajuan->nim_nisn ?? '-' }}, Program Studi: {{ $pengajuan->jurusan ?? '-' }}) untuk periode pelaksanaan tanggal {{ $pengajuan->tgl_mulai?->translatedFormat('d F Y') }} s/d {{ $pengajuan->tgl_selesai?->translatedFormat('d F Y') }}.
        </p>

        <p>
            Sehubungan dengan hal tersebut, setelah dilakukan peninjauan berkas serta koordinasi bersama Kasubbag Umum dan Kepegawaian terkait ketersediaan formasi dan kuota penerimaan peserta magang pada Dinas Pendidikan Provinsi Sumatera Selatan, dengan hormat kami sampaikan bahwa permohonan magang tersebut <strong>belum dapat kami penuhi / terima</strong>.
        </p>

        <p style="margin-bottom: 4px;">
            Adapun pertimbangan dan alasan keputusan ini adalah:
        </p>

        <div class="alasan-box">
            &ldquo;{{ $pengajuan->keterangan_reject ?? 'Keterbatasan kuota penerimaan dan ketidaksesuaian formasi bidang ilmu dengan kebutuhan dinas saat ini.' }}&rdquo;
        </div>

        @if(!empty($pengajuan->rekomendasi_instansi))
        <p>
            Berdasarkan pertimbangan kesesuaian latar belakang program studi pemohon, kami merekomendasikan/menyarankan agar permohonan magang dapat dialihkan ke instansi mitra: <strong>{{ $pengajuan->rekomendasi_instansi }}</strong>.
        </p>
        @endif

        <p style="text-indent: 0; margin-top: 10px; margin-bottom: 12px;">
            Demikian surat pemberitahuan ini kami sampaikan. Atas perhatian, pengertian, dan kerja sama yang baik dari pihak {{ $pengajuan->instansi?->nama ?? $pengajuan->nama_instansi }}, kami ucapkan terima kasih.
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
