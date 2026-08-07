<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan Penerimaan Magang - {{ $pengajuan->nama_instansi }}</title>
    <style>
        @page { margin: 2.5cm 2cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h3 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .header h2 { margin: 2px 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .header p { margin: 0; font-size: 10pt; font-style: italic; }
        .surat-meta { margin-bottom: 20px; }
        .surat-meta table { width: 100%; border-collapse: collapse; }
        .surat-meta td { vertical-align: top; padding: 2px 0; }
        .content { text-align: justify; margin-bottom: 30px; }
        .content p { margin-bottom: 15px; text-indent: 30px; }
        .peserta-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .peserta-table th, .peserta-table td { border: 1px solid #000; padding: 6px 10px; text-align: left; font-size: 11pt; }
        .peserta-table th { background-color: #f2f2f2; text-align: center; }
        .signature-section { width: 100%; margin-top: 40px; }
        .signature-box { float: right; width: 280px; text-align: center; }
        .signature-space { height: 70px; }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <div class="header">
        <h3>PEMERINTAH PROVINSI SUMATERA SELATAN</h3>
        <h2>DINAS PENDIDIKAN</h2>
        <p>Jalan Kapten A. Rivai No. 47 Palembang, Sumatera Selatan | Telp: (0711) 351028</p>
    </div>

    <!-- METADATA SURAT -->
    <div class="surat-meta">
        <table>
            <tr>
                <td width="15%">Nomor</td>
                <td width="2%">:</td>
                <td width="48%">420/ {{ sprintf('%04d', $pengajuan->id) }} /DISDIK.SS/{{ date('Y') }}</td>
                <td width="35%" style="text-align: right;">Palembang, {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>Penting / Resmi</td>
                <td></td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td><strong>Persetujuan & Balasan Permohonan Magang</strong></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 20px;">
        Kepada Yth.<br>
        <strong>Pimpinan / Kepala {{ $pengajuan->nama_instansi }}</strong><br>
        u.p. {{ $pengajuan->pic_nama }}<br>
        Di Tempat
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p>
            Menindaklanjuti Surat Permohonan Pengajuan Magang dari {{ $pengajuan->nama_instansi }} mengenai pelaksanaan kegiatan Magang / Praktik Kerja Lapangan (PKL) bagi peserta didik / mahasiswa Anda di lingkungan Dinas Pendidikan Provinsi Sumatera Selatan.
        </p>

        <p>
            Berdasarkan hasil verifikasi berkas dan **pertimbangan kesesuaian jurusan bersama Kasubbag Umum dan Kepegawaian**, dengan ini kami menyampaikan bahwa permohonan magang untuk sejumlah <strong>{{ $pengajuan->jml_peserta }} orang peserta</strong> untuk periode <strong>{{ $pengajuan->tgl_mulai?->format('d F Y') }} s/d {{ $pengajuan->tgl_selesai?->format('d F Y') }}</strong> dinyatakan <strong>DISETUJUI / DITERIMA</strong>.
        </p>

        <p>
            Sehubungan dengan persetujuan tersebut, kami menyampaikan beberapa ketentuan pelaksanaan sebagai berikut:
        </p>

        <ol style="margin-left: 20px; margin-bottom: 15px;">
            <li>Pada hari pertama pelaksanaan magang, seluruh peserta <strong>wajib mengikuti Pembinaan oleh Kasubbag Umum dan Kepegawaian</strong> Dinas Pendidikan Provinsi Sumatera Selatan.</li>
            <li>Setelah pembinaan, peserta akan ditempatkan pada Bidang yang sesuai, di mana Penentuan Pembimbing Magang akan ditetapkan oleh Atasan Bidang masing-masing berdasarkan tugas yang diberikan.</li>
            <li>Peserta wajib menjaga ketertiban, kedisiplinan, kerapian, serta mematuhi seluruh peraturan yang berlaku di lingkungan Dinas Pendidikan Provinsi Sumatera Selatan.</li>
        </ol>

        <p>
            Demikian surat balasan penerimaan ini disampaikan untuk dipergunakan sebagaimana mestinya. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
        </p>
    </div>

    <!-- TANDA TANGAN KASUBBAG -->
    <div class="signature-section">
        <div class="signature-box">
            An. Kepala Dinas Pendidikan Prov. Sumsel<br>
            <strong>Kasubbag Umum dan Kepegawaian</strong>
            <div class="signature-space"></div>
            <strong><u>Kasubbag Umum & Kepegawaian</u></strong><br>
            NIP. 19780512 200501 1 004
        </div>
    </div>

</body>
</html>
