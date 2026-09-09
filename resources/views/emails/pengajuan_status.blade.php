<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengumuman Seleksi Magang</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1e293b;
            line-height: 1.6;
        }
        .wrapper {
            width: 100%;
            background-color: #f1f5f9;
            padding: 30px 15px;
            box-sizing: border-box;
        }
        .container {
            max-width: 620px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #0d2166 0%, #1e3a8a 100%);
            color: #ffffff;
            padding: 30px 25px;
            text-align: center;
        }
        .header h1 {
            margin: 10px 0 4px 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 0;
            font-size: 12px;
            color: #cbd5e1;
        }
        .content {
            padding: 30px 25px;
        }
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .badge-approved {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }
        .badge-rejected {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .lead-text {
            font-size: 14px;
            color: #334155;
            margin-bottom: 20px;
        }
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .info-table td {
            padding: 6px 0;
            vertical-align: top;
        }
        .info-table td.label {
            width: 140px;
            color: #64748b;
            font-weight: 600;
        }
        .info-table td.val {
            color: #0f172a;
            font-weight: 600;
        }
        .cta-btn {
            display: inline-block;
            background: #2563eb;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            margin: 5px 0;
        }
        .cta-btn-success {
            background: #16a34a;
        }
        .notes-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 14px 16px;
            border-radius: 0 10px 10px 0;
            margin: 20px 0;
            font-size: 13px;
            color: #1e40af;
        }
        .notes-box h4 {
            margin: 0 0 6px 0;
            font-size: 13px;
            color: #1d4ed8;
        }
        .notes-box ol {
            margin: 0;
            padding-left: 18px;
        }
        .notes-box li {
            margin-bottom: 4px;
        }
        .footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 25px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <div style="font-size: 28px;">🏛️</div>
                <h1>DINAS PENDIDIKAN PROVINSI SUMATERA SELATAN</h1>
                <p>Sistem Informasi Pendaftaran dan Administrasi Magang (SIMAG-DISDIKPROV SUMSEL)</p>
            </div>

            <!-- Content Body -->
            <div class="content">
                @if($pengajuan->status === 'approved')
                    <div class="badge badge-approved">
                        ✅ PENGAJUAN DITERIMA (APPROVED)
                    </div>
                @else
                    <div class="badge badge-rejected">
                        ❌ PENGAJUAN BELUM DAPAT DITERIMA (DITOLAK)
                    </div>
                @endif

                <div class="greeting">
                    Yth. Sdr/i {{ $pengajuan->pic_nama }},
                </div>

                @if($pengajuan->status === 'approved')
                    <p class="lead-text">
                        Selamat! Berdasarkan hasil verifikasi berkas permohonan magang mandiri oleh Kasubbag Umum dan Kepegawaian Dinas Pendidikan Provinsi Sumatera Selatan, pengajuan Anda dinyatakan <strong>MEMENUHI SYARAT DAN DITERIMA</strong>.
                    </p>

                    <!-- Table Info -->
                    <div class="info-card">
                        <table class="info-table">
                            <tr>
                                <td class="label">Nama Peserta</td>
                                <td class="val">: {{ $pengajuan->pic_nama }}</td>
                            </tr>
                            <tr>
                                <td class="label">NIM / NISN</td>
                                <td class="val">: {{ $pengajuan->nim_nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Asal Sekolah/Kampus</td>
                                <td class="val">: {{ $pengajuan->nama_instansi }}</td>
                            </tr>
                            <tr>
                                <td class="label">Jurusan</td>
                                <td class="val">: {{ $pengajuan->jurusan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Periode Magang</td>
                                <td class="val">: {{ $pengajuan->tgl_mulai?->translatedFormat('d F Y') }} s/d {{ $pengajuan->tgl_selesai?->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="label">Status Akun Portal</td>
                                <td class="val" style="color:#16a34a;">: AKTIF (Dapat Login)</td>
                            </tr>
                            <tr>
                                <td class="label">Email Login</td>
                                <td class="val">: {{ $pengajuan->pic_email }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- CTA Buttons -->
                    <div style="text-align: center; margin: 25px 0;">
                        <a href="{{ route('pengajuan.surat_balasan', $pengajuan) }}" class="cta-btn cta-btn-success" target="_blank">
                            📄 Unduh Surat Balasan (LoA PDF)
                        </a>
                        &nbsp;
                        <a href="{{ route('login') }}" class="cta-btn" target="_blank">
                            🔐 Masuk ke Portal Peserta
                        </a>
                    </div>

                    <!-- Arahan Magang -->
                    <div class="notes-box">
                        <h4>📢 Petunjuk & Tata Tertib Awal Masuk Magang:</h4>
                        <ol>
                            <li>Hadir pada hari pertama pelaksanaan magang pukul <strong>07.30 WIB</strong> di Kantor Dinas Pendidikan Provinsi Sumatera Selatan (Jl. Kapten A. Rivai No.47, Palembang).</li>
                            <li>Melapor ke <strong>Subbagian Umum dan Kepegawaian</strong> dengan membawa berkas cetak Surat Balasan (LoA) ini beserta Surat Pengantar asli.</li>
                            <li>Mengenakan pakaian rapi, sopan (kemeja putih / seragam almamater instansi asal).</li>
                            <li>Mengisi presensi kehadiran setiap hari kerja melalui portal peserta SIMAG.</li>
                        </ol>
                    </div>
                @else
                    <p class="lead-text">
                        Terima kasih atas minat dan permohonan magang yang telah Anda ajukan kepada Dinas Pendidikan Provinsi Sumatera Selatan. Melalui surat elektronik ini kami sampaikan bahwa permohonan Anda saat ini <strong>BELUM DAPAT KAMI TERIMA</strong>.
                    </p>

                    <div class="info-card" style="border-left: 4px solid #dc2626;">
                        <div style="font-weight: 700; color: #dc2626; margin-bottom: 6px; font-size: 13px;">Alasan / Keterangan Penolakan:</div>
                        <div style="color: #334155; font-size: 13px;">
                            "{{ $pengajuan->keterangan_reject ?? 'Kapasitas kuota penerimaan magang pada periode ini telah terpenuhi.' }}"
                        </div>
                        @if($pengajuan->rekomendasi_instansi)
                            <div style="margin-top: 10px; font-size: 12px; color: #0284c7;">
                                <strong>Rekomendasi Alternatif:</strong> {{ $pengajuan->rekomendasi_instansi }}
                            </div>
                        @endif
                    </div>

                    <div style="text-align: center; margin: 25px 0;">
                        <a href="{{ route('pengajuan.surat_balasan', $pengajuan) }}" class="cta-btn" style="background: #64748b;" target="_blank">
                            📄 Unduh Surat Keterangan Resmi (PDF)
                        </a>
                    </div>
                @endif

                <p style="font-size: 12px; color: #64748b; margin-top: 25px;">
                    Email ini dikirimkan secara otomatis oleh Sistem Informasi Magang (SIMAG). Jika ada pertanyaan lebih lanjut, silakan hubungi kami via email: wardik.sumsel@gmail.com.
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <strong>Subbagian Umum dan Kepegawaian</strong><br>
                Dinas Pendidikan Provinsi Sumatera Selatan<br>
                Jl. Kapten A. Rivai No.47, Sungai Pangeran, Kec. Ilir Timur I, Palembang, Sumatera Selatan 30121<br>
                &copy; {{ date('Y') }} SIMAG-DISDIKPROV SUMSEL. Hak Cipta Dilindungi.
            </div>
        </div>
    </div>
</body>
</html>
