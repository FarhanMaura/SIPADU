<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan LoA - {{ $pengajuan->nama_instansi }}</title>
    <style>
        @page {
            margin: 2.2cm 2cm 2cm 2.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo {
            width: 80px;
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
        }
        .header-text h2 {
            margin: 2px 0;
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header-text p {
            margin: 0;
            font-size: 9.5pt;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .meta-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .content {
            text-align: justify;
            margin-bottom: 25px;
        }
        .content p {
            margin-bottom: 12px;
            text-indent: 35px;
        }
        .peserta-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }
        .peserta-table th, .peserta-table td {
            border: 1px solid #000;
            padding: 5px 8px;
            font-size: 10pt;
        }
        .peserta-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .signature-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        .signature-table td {
            vertical-align: top;
        }
        .signature-box {
            text-align: center;
            width: 250px;
            float: right;
        }
        .signature-space {
            height: 65px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI PEMPROV SUMSEL -->
    <table class="header-table">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="{{ public_path('images/logo_sumsel.png') }}" class="logo" alt="Logo Sumsel" onerror="this.style.display='none'">
            </td>
            <td width="85%" class="header-text">
                <h3>PEMERINTAH PROVINSI SUMATERA SELATAN</h3>
                <h2>DINAS PENDIDIKAN</h2>
                <p>Jalan Kapten A. Rivai Palembang Provinsi Sumatera Selatan</p>
                <p>Telepon : (0711) 352288 - 354122 Faximile : (0711) 357483 Kode Pos 30126</p>
                <p>Email : sumsel@sumselprov.go.id | Website : www.sumselprov.go.id</p>
            </td>
        </tr>
    </table>

    <!-- TANGGAL SURAT -->
    <div style="text-align: right; margin-bottom: 15px;">
        Palembang, {{ now()->translatedFormat('d F Y') }}
    </div>

    <!-- METADATA SURAT -->
    <table class="meta-table">
        <tr>
            <td width="15%">Nomor</td>
            <td width="2%">:</td>
            <td width="53%">400.3/ {{ sprintf('%04d', $pengajuan->id) }} /Disdik/{{ date('Y') }}</td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>:</td>
            <td>Segera</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>1 (satu) eksp.</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td><strong>Penyampaian Nama-nama Peserta Giat Magang pada Dinas Pendidikan Provinsi Sumatera Selatan</strong></td>
        </tr>
    </table>

    <div style="margin-bottom: 15px;">
        Kepada Yth.<br>
        <strong>Para Pimpinan / Kepala {{ $pengajuan->nama_instansi }}</strong><br>
        u.p. {{ $pengajuan->pic_nama }} ({{ $pengajuan->pic_email }})<br>
        di -<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Palembang / Tempat</strong>
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p>
            Menindaklanjuti permohonan magang dari <strong>{{ $pengajuan->nama_instansi }}</strong> mengenai pelaksanaan kegiatan Magang / Praktik Kerja Lapangan (PKL) bagi mahasiswa / peserta didik di lingkungan Dinas Pendidikan Provinsi Sumatera Selatan.
        </p>

        <p>
            Berkaitan dengan hal tersebut di atas, Pemerintah Provinsi Sumatera Selatan melalui Dinas Pendidikan Provinsi Sumatera Selatan menyampaikan bahwa permohonan magang untuk sejumlah <strong>{{ $pengajuan->jml_peserta }} orang peserta</strong> terhitung dari tanggal <strong>{{ $pengajuan->tgl_mulai?->translatedFormat('d F Y') }}</strong> sampai dengan <strong>{{ $pengajuan->tgl_selesai?->translatedFormat('d F Y') }}</strong> dinyatakan <strong>DISETUJUI / DITERIMA</strong>.
        </p>

        <p style="text-indent: 0; margin-bottom: 5px;">Adapun rincian peserta magang yang diterima adalah sebagai berikut:</p>
        <table class="peserta-table">
            <thead>
                <tr>
                    <th width="30">NO</th>
                    <th>NAMA PESERTA</th>
                    <th>NIM / NISN</th>
                    <th>JURUSAN / PRODI</th>
                    <th>INSTANSI / KAMPUS</th>
                </tr>
            </thead>
            <tbody>
                @if($pengajuan->pesertas->count() > 0)
                    @foreach($pengajuan->pesertas as $index => $peserta)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td><strong>{{ $peserta->nama }}</strong></td>
                        <td>{{ $peserta->nim_nisn ?? '-' }}</td>
                        <td>{{ $peserta->jurusan ?? '-' }}</td>
                        <td>{{ $peserta->instansi?->nama ?? $pengajuan->nama_instansi }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td><strong>{{ $pengajuan->pic_nama }}</strong></td>
                        <td>{{ $pengajuan->nim_nisn ?? '-' }}</td>
                        <td>{{ $pengajuan->jurusan ?? '-' }}</td>
                        <td>{{ $pengajuan->nama_instansi }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <p>
            Peserta magang diwajibkan mematuhi seluruh peraturan kedisiplinan dan tata tertib yang berlaku di lingkungan Dinas Pendidikan Provinsi Sumatera Selatan serta mengikuti arahan pembinaan dari Kasubbag Umum dan Kepegawaian.
        </p>

        <p>
            Demikian surat balasan penerimaan magang (Letter of Acceptance) ini disampaikan untuk dapat dipergunakan sebagaimana mestinya. Atas perhatian dan kerjasamanya diucapkan terima kasih.
        </p>
    </div>

    <!-- TANDA TANGAN KASUBBAG -->
    <table class="signature-table">
        <tr>
            <td width="55%"></td>
            <td width="45%">
                <div class="signature-box">
                    a.n. Kepala Dinas Pendidikan Prov. Sumsel<br>
                    <strong>Kasubbag Umum dan Kepegawaian,</strong>
                    <div class="signature-space"></div>
                    <strong><u>Misral, S.Sn., M.Sn.</u></strong><br>
                    Penata Tingkat I, III/d<br>
                    NIP. 19680604 200801 1 016
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
