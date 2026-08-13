@extends('layouts.adminlte')
@section('title', 'Sertifikat & Daftar Nilai Magang')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-certificate"></i> Sertifikat Magang & Daftar Nilai (Bolak-Balik)</h1>
        <p>Pratinjau Halaman Depan (Piagam Penghargaan) dan Halaman Belakang (Daftar Nilai PKL).</p>
    </div>
</div>

<div style="max-width: 900px; margin: 0 auto; font-family: 'Times New Roman', serif;">
    @if($peserta && $penilaian)

    @php
        if (!function_exists('terbilangAngkaFinalWeb')) {
            function terbilangAngkaFinalWeb($angka) {
                $angka = (int) round($angka);
                $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
                if ($angka < 12) return $baca[$angka];
                elseif ($angka < 20) return terbilangAngkaFinalWeb($angka - 10) . ' Belas';
                elseif ($angka < 100) return terbilangAngkaFinalWeb(floor($angka / 10)) . ' Puluh' . ($angka % 10 != 0 ? ' ' . terbilangAngkaFinalWeb($angka % 10) : '');
                elseif ($angka < 200) return 'Seratus' . ($angka - 100 != 0 ? ' ' . terbilangAngkaFinalWeb($angka - 100) : '');
                elseif ($angka < 1000) return terbilangAngkaFinalWeb(floor($angka / 100)) . ' Ratus' . ($angka % 100 != 0 ? ' ' . terbilangAngkaFinalWeb($angka % 100) : '');
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

        // Logo Sumsel SVG resmi (hijau) - file dari user
        $logoSumselSvgPath = public_path('images/logosumsel_resmi.svg');
        $logoSumselFallbackPath = public_path('images/logo_sumsel.svg');
        if (file_exists($logoSumselSvgPath)) {
            $logoSumselSrc = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoSumselSvgPath));
        } elseif (file_exists($logoSumselFallbackPath)) {
            $logoSumselSrc = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoSumselFallbackPath));
        } else {
            $logoSumselSrc = asset('images/logosumsel_resmi.svg');
        }

        // Logo Tut Wuri Handayani untuk watermark - file dari user
        $tutwuriJpgPath = public_path('images/tutwuri_handayani.jpg');
        $tutwuriSvgPath = public_path('images/tutwuri_watermark.svg');
        if (file_exists($tutwuriJpgPath)) {
            $tutwuriSrc = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($tutwuriJpgPath));
        } elseif (file_exists($tutwuriSvgPath)) {
            $tutwuriSrc = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($tutwuriSvgPath));
        } else {
            $tutwuriSrc = asset('images/tutwuri_handayani.jpg');
        }

        $logoJpegPath = public_path('images/logo.jpeg');
        $logoJpegSrc = file_exists($logoJpegPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoJpegPath))
            : asset('images/logo.jpeg');

        $tglMulaiFormatted = $peserta->tgl_mulai ? \Carbon\Carbon::parse($peserta->tgl_mulai)->translatedFormat('d F Y') : '16 Oktober 2025';
        $tglSelesaiFormatted = $peserta->tgl_selesai ? \Carbon\Carbon::parse($peserta->tgl_selesai)->translatedFormat('d F Y') : '31 Desember 2025';
        $tglSertifikatFormatted = $penilaian->created_at ? \Carbon\Carbon::parse($penilaian->created_at)->translatedFormat('d F Y') : '10 Maret 2026';
    @endphp

    <!-- BUTTON DOWNLOAD PDF -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <a href="{{ route('peserta.sertifikat.download') }}" class="action-button" style="background: #2563eb; color: white; padding: 1rem 2.5rem; font-size: 1.1rem; text-decoration: none; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 0.75rem; box-shadow: 0 6px 20px rgba(37,99,235,0.35);">
            <i class="fas fa-file-pdf fa-lg"></i> Unduh PDF Sertifikat (2 Halaman Bolak-Balik)
        </a>
    </div>

    <!-- ========================================================= -->
    <!-- HALAMAN DEPAN: PIAGAM PENGHARGAAN -->
    <!-- ========================================================= -->
    <div style="margin-bottom: 1rem; text-align: left; font-weight: 700; color: #1e293b; font-size: 1.1rem; font-family: sans-serif;">
        <i class="fas fa-file-alt text-primary mr-1"></i> 1. HALAMAN DEPAN (PIAGAM PENGHARGAAN)
    </div>

    <!-- FRAME SERTIFIKAT KUNING EMAS - SESUAI FOTO REFERENSI -->
    <div style="
        background: linear-gradient(160deg, #f7c93a 0%, #e8b020 40%, #d4990a 100%);
        border-radius: 8px;
        padding: 0;
        position: relative;
        box-shadow: 0 16px 50px rgba(0,0,0,0.25);
        margin-bottom: 3rem;
        overflow: hidden;
        color: #000;
        border: 3px solid #c9960b;
    ">
        <!-- DOUBLE BORDER DALAM -->
        <div style="
            position: absolute; inset: 8px;
            border: 1.5px solid rgba(180,130,10,0.5);
            border-radius: 4px;
            pointer-events: none;
            z-index: 0;
        "></div>
        <div style="
            position: absolute; inset: 11px;
            border: 1px solid rgba(255,230,100,0.6);
            border-radius: 3px;
            pointer-events: none;
            z-index: 0;
        "></div>

        <!-- KONTEN UTAMA DENGAN PADDING -->
        <div style="position: relative; z-index: 2; padding: 1.8rem 2rem 1.8rem 2rem;">

            <!-- HEADER ROW: Logo kiri + Teks tengah -->
            <div style="display: flex; align-items: center; margin-bottom: 1rem; min-height: 90px;">
                
                <!-- LOGO SUMATERA SELATAN (HIJAU) DI KIRI ATAS -->
                <div style="flex: 0 0 auto; margin-right: 1.5rem;">
                    <img src="{{ $logoSumselSrc }}" alt="Logo Sumatera Selatan"
                        style="width: 85px; height: auto; display: block; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.18));">
                </div>

                <!-- TEKS KOP DI TENGAH -->
                <div style="flex: 1; text-align: center;">
                    <div style="font-size: 1.2rem; font-weight: 800; text-transform: uppercase; color: #1a1a1a; letter-spacing: 0.5px; font-family: 'Times New Roman', serif; line-height: 1.3;">
                        PEMERINTAH PROVINSI SUMATERA SELATAN
                    </div>
                    <div style="font-size: 1.8rem; font-weight: 900; text-transform: uppercase; color: #1a1a1a; letter-spacing: 2px; font-family: 'Times New Roman', serif; line-height: 1.2; margin-top: 2px;">
                        DINAS PENDIDIKAN
                    </div>
                </div>

                <!-- PLACEHOLDER KANAN (UNTUK BALANCE LAYOUT) -->
                <div style="flex: 0 0 85px;"></div>
            </div>

            <!-- GARIS PEMISAH HEADER -->
            <div style="border-top: 2.5px solid #8a6000; border-bottom: 1px solid rgba(139,96,0,0.4); height: 5px; margin-bottom: 0.8rem;"></div>

            <!-- JUDUL PIAGAM PENGHARGAAN -->
            <div style="text-align: center; margin-bottom: 1rem;">
                <h1 style="font-size: 2.4rem; font-weight: 900; letter-spacing: 2px; margin: 0; color: #1a1a1a; text-transform: uppercase; font-family: 'Times New Roman', serif;">
                    PIAGAM PENGHARGAAN
                </h1>
                <div style="font-size: 1rem; font-style: italic; font-weight: bold; margin-top: 3px; color: #1a1a1a; font-family: 'Times New Roman', serif;">
                    Nomor: {{ $peserta->no_sertifikat ?? '420/5679/Set.3-Disdik.SS/III/2026' }}
                </div>
            </div>

            <!-- AREA PUTIH MEMBULAT (ISI SERTIFIKAT) -->
            <div style="
                background-color: #ffffff;
                border-radius: 18px;
                padding: 1.8rem 2.2rem 1.6rem 2.2rem;
                box-shadow: 0 4px 18px rgba(0,0,0,0.10);
                position: relative;
                overflow: hidden;
            ">

                <!-- WATERMARK TUT WURI HANDAYANI DI TENGAH (TRANSPARANSI 90% = OPACITY 0.10) -->
                <div style="
                    position: absolute;
                    top: 50%; left: 50%;
                    transform: translate(-50%, -50%);
                    width: 320px; height: 320px;
                    opacity: 0.10;
                    pointer-events: none;
                    z-index: 1;
                ">
                    <img src="{{ $tutwuriSrc }}" alt="Tut Wuri Handayani Watermark"
                        style="width: 100%; height: 100%; object-fit: contain;">
                </div>

                <!-- ISI KONTEN SERTIFIKAT -->
                <div style="position: relative; z-index: 2; font-family: 'Times New Roman', serif;">

                    <div style="font-size: 1.05rem; color: #000; margin-bottom: 1rem; text-align: left; line-height: 1.5;">
                        Kepala Dinas Pendidikan Provinsi Sumatera Selatan memberikan penghargaan kepada:
                    </div>

                    <table style="width: 100%; border-collapse: collapse; font-size: 1.05rem; color: #000; text-align: left; margin-bottom: 1rem;">
                        <tbody>
                            <tr>
                                <td style="width: 22%; padding: 3px 0; font-weight: normal; vertical-align: top;">Nama</td>
                                <td style="width: 3%; padding: 3px 0; font-weight: normal; vertical-align: top;">:</td>
                                <td style="width: 75%; padding: 3px 0; font-weight: bold; text-transform: uppercase; vertical-align: top;">{{ strtoupper($peserta->nama) }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 3px 0; font-weight: normal; vertical-align: top;">NIS/NISN</td>
                                <td style="padding: 3px 0; font-weight: normal; vertical-align: top;">:</td>
                                <td style="padding: 3px 0; font-weight: bold; vertical-align: top;">{{ $peserta->nim_nisn ?? '221410011' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 3px 0; font-weight: normal; vertical-align: top;">Asal Sekolah</td>
                                <td style="padding: 3px 0; font-weight: normal; vertical-align: top;">:</td>
                                <td style="padding: 3px 0; font-weight: bold; text-transform: uppercase; vertical-align: top;">{{ strtoupper($peserta->instansi?->nama ?? $peserta->asal_sekolah ?? 'UNIVERSITAS BINA DARMA PALEMBANG') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 3px 0; font-weight: normal; vertical-align: top;">Jurusan/Prodi</td>
                                <td style="padding: 3px 0; font-weight: normal; vertical-align: top;">:</td>
                                <td style="padding: 3px 0; font-weight: bold; text-transform: uppercase; vertical-align: top;">{{ strtoupper($peserta->jurusan ?? 'SISTEM INFORMASI') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="font-size: 1rem; line-height: 1.65; text-align: justify; color: #000; margin-bottom: 1.4rem;">
                        yang telah mengikuti program pelatihan dalam pelaksanaan Praktik Kerja Lapangan (PKL) di Dinas Pendidikan
                        Provinsi Sumatera Selatan yang dilaksanakan dari tanggal {{ $tglMulaiFormatted }} sampai dengan {{ $tglSelesaiFormatted }}.
                    </div>

                    <!-- TANDA TANGAN & CAP -->
                    <div style="width: 100%;">
                        <div style="float: right; width: 300px; text-align: center; font-size: 1rem; color: #000; position: relative;">
                            Palembang, {{ $tglSertifikatFormatted }}<br>
                            a.n. <strong>Kepala Dinas Pendidikan</strong><br>
                            <strong>Sekretaris,</strong><br>

                            <div style="height: 80px; position: relative; margin: 4px 0;">
                                <!-- STEMPEL BIRU -->
                                <div style="position: absolute; left: 5px; top: -15px; width: 100px; height: 100px; opacity: 0.80; z-index: 10; pointer-events: none;">
                                    <svg viewBox="0 0 100 100" width="100%" height="100%">
                                        <circle cx="50" cy="50" r="46" fill="none" stroke="#1d4ed8" stroke-width="2" stroke-dasharray="4 1.5"/>
                                        <circle cx="50" cy="50" r="38" fill="none" stroke="#1d4ed8" stroke-width="1.5"/>
                                        <path id="stampTop2" d="M 13 50 A 37 37 0 0 1 87 50" fill="none"/>
                                        <text font-size="6.5" font-weight="bold" fill="#1d4ed8" text-anchor="middle">
                                            <textPath href="#stampTop2" startOffset="50%">PEMERINTAH PROVINSI SUMSEL</textPath>
                                        </text>
                                        <path id="stampBot2" d="M 87 50 A 37 37 0 0 1 13 50" fill="none"/>
                                        <text font-size="6.5" font-weight="bold" fill="#1d4ed8" text-anchor="middle">
                                            <textPath href="#stampBot2" startOffset="50%">DINAS PENDIDIKAN</textPath>
                                        </text>
                                        <line x1="20" y1="50" x2="80" y2="50" stroke="#1d4ed8" stroke-width="1.2"/>
                                        <text x="50" y="46" font-size="6" font-weight="bold" fill="#1d4ed8" text-anchor="middle">SUMATERA</text>
                                        <text x="50" y="56" font-size="6" font-weight="bold" fill="#1d4ed8" text-anchor="middle">SELATAN</text>
                                    </svg>
                                </div>
                                <!-- TTD -->
                                <div style="position: absolute; right: 35px; top: 10px; width: 140px; height: 55px; opacity: 0.9; z-index: 5;">
                                    <svg viewBox="0 0 140 55" width="100%" height="100%">
                                        <path d="M 8 42 C 30 15, 28 45, 48 20 C 60 8, 54 40, 75 24 C 92 12, 84 42, 120 30 C 132 26, 135 30, 138 28" fill="none" stroke="#0f172a" stroke-width="2.2" stroke-linecap="round"/>
                                        <path d="M 32 32 L 95 34" fill="none" stroke="#0f172a" stroke-width="1.6"/>
                                    </svg>
                                </div>
                            </div>

                            <strong><u>Misral, S.Sn., M.Sn.</u></strong><br>
                            Penata Tingkat I, III/d<br>
                            NIP 196806042008011016
                        </div>
                        <div style="clear: both;"></div>
                    </div>

                </div>
            </div>
            <!-- END AREA PUTIH -->

        </div>
        <!-- END KONTEN UTAMA -->

    </div>
    <!-- END FRAME SERTIFIKAT -->

    <!-- ========================================================= -->
    <!-- HALAMAN BELAKANG: DAFTAR NILAI MAHASISWA PKL -->
    <!-- ========================================================= -->
    <div style="margin-bottom: 1rem; text-align: left; font-weight: 700; color: #1e293b; font-size: 1.1rem; font-family: sans-serif;">
        <i class="fas fa-table text-success mr-1"></i> 2. HALAMAN BELAKANG (DAFTAR NILAI PKL)
    </div>

    <div style="background-color: #ffffff; border-radius: 20px; padding: 3rem 2.5rem; border: 1px solid #cbd5e1; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 3rem; color: #000;">
        
        <div style="text-align: center; font-weight: bold; font-size: 1.4rem; margin-bottom: 2rem; line-height: 1.4;">
            DAFTAR NILAI MAHASISWA<br>PRAKTIK KERJA LAPANGAN
        </div>

        <table style="width: 100%; border-collapse: collapse; font-weight: bold; font-size: 1.05rem; margin-bottom: 1.5rem;">
            <tbody>
                <tr>
                    <td width="30%" style="padding: 4px 0;">NAMA</td>
                    <td width="3%">:</td>
                    <td width="67%">{{ strtoupper($peserta->nama) }}</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0;">JURUSAN/PROGRAM STUDI</td>
                    <td>:</td>
                    <td>{{ strtoupper($peserta->jurusan ?? '-') }}</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0;">TEMPAT PKL</td>
                    <td>:</td>
                    <td>Dinas Pendidikan Provinsi Sumatera Selatan</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem; font-size: 1rem;">
            <thead>
                <tr style="background: #f8fafc; border: 1px solid #000;">
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;" width="8%">NO</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;" width="47%">BIDANG PEKERJAAN<br>YANG DILATIHKAN</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;" width="20%">DENGAN<br>ANGKA</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;" width="25%">DENGAN HURUF</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">1</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kedisiplinan</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $kedisiplinan }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($kedisiplinan) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">2</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kerapian</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $kerapian }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($kerapian) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">3</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kebersihan</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $kebersihan }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($kebersihan) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">4</td>
                    <td style="border: 1px solid #000; padding: 8px;">Tanggung jawab</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $tanggungjawab }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($tanggungjawab) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">5</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kerjasama</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $kerjasama }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($kerjasama) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">6</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kreativitas</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $kreativitas }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($kreativitas) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">7</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kejujuran</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $kejujuran }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($kejujuran) }}</td>
                </tr>
                <tr style="font-weight: bold; background: #f8fafc;">
                    <td style="border: 1px solid #000; padding: 8px;" colspan="2">JUMLAH</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $jumlah }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($jumlah) }}</td>
                </tr>
                <tr style="font-weight: bold; background: #eff6ff;">
                    <td style="border: 1px solid #000; padding: 8px;" colspan="2">RATA-RATA</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $rataRata }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaFinalWeb($rataRata) }}</td>
                </tr>
            </tbody>
        </table>


    </div>

    @elseif(!$penilaian)
    <div class="alert-toast alert-toast-danger" style="background: #fffbeb; border-color: #fde68a; color: #d97706; text-align: left;">
        <i class="fas fa-exclamation-triangle"></i> Sertifikat belum dapat diunduh karena penilaian belum diinput oleh pembimbing.
    </div>
    @else
    <div class="alert-toast alert-toast-danger" style="text-align: left;">
        <i class="fas fa-exclamation-circle"></i> Data peserta tidak ditemukan.
    </div>
    @endif
</div>
@endsection
