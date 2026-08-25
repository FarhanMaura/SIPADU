@extends('layouts.adminlte')
@section('title', 'Sertifikat & Daftar Nilai Magang')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-certificate"></i> Sertifikat Magang & Daftar Nilai (2 Halaman)</h1>
        <p>Pratinjau Halaman Depan (Piagam Penghargaan) dan Halaman Belakang (Daftar Nilai PKL).</p>
    </div>
</div>

<div style="max-width: 1000px; margin: 0 auto; font-family: 'Times New Roman', serif;">
    @if($peserta && $penilaian)

    @php
        if (!function_exists('terbilangAngkaSertifikatWeb')) {
            function terbilangAngkaSertifikatWeb($angka) {
                $angka = (int) round($angka);
                $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
                if ($angka < 12) return $baca[$angka];
                elseif ($angka < 20) return terbilangAngkaSertifikatWeb($angka - 10) . ' Belas';
                elseif ($angka < 100) return terbilangAngkaSertifikatWeb(floor($angka / 10)) . ' Puluh' . ($angka % 10 != 0 ? ' ' . terbilangAngkaSertifikatWeb($angka % 10) : '');
                elseif ($angka < 200) return 'Seratus' . ($angka - 100 != 0 ? ' ' . terbilangAngkaSertifikatWeb($angka - 100) : '');
                elseif ($angka < 1000) return terbilangAngkaSertifikatWeb(floor($angka / 100)) . ' Ratus' . ($angka % 100 != 0 ? ' ' . terbilangAngkaSertifikatWeb($angka % 100) : '');
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

        // Logo & TTD
        $logoSumselSrc = asset('images/logo_sumsel.png');
        $ttdSrc = asset('images/stempel_ttd_disdik.png');

        $tglMulaiFormatted = $peserta->tgl_mulai ? \Carbon\Carbon::parse($peserta->tgl_mulai)->translatedFormat('d F Y') : '01 Januari 2026';
        $tglSelesaiFormatted = $peserta->tgl_selesai ? \Carbon\Carbon::parse($peserta->tgl_selesai)->translatedFormat('d F Y') : '31 Desember 2026';
        $tglSertifikatFormatted = $penilaian->created_at ? \Carbon\Carbon::parse($penilaian->created_at)->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
        
        $nomorRaw = $penilaian->no_sertifikat ?? $peserta->no_sertifikat ?? '5152';
        $noSertifikat = str_contains($nomorRaw, '/') ? $nomorRaw : "420/{$nomorRaw}/Set.3-Disdik.SS/III/2026";
    @endphp

    <!-- ACTION BUTTONS -->
    <div style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
        <a href="{{ route('peserta.sertifikat.download') }}" class="action-button" style="background: #2563eb; color: white; padding: 0.85rem 2rem; font-size: 1.05rem; text-decoration: none; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 0.6rem; box-shadow: 0 6px 20px rgba(37,99,235,0.35);">
            <i class="fas fa-file-pdf fa-lg"></i> Unduh PDF Sertifikat (2 Halaman)
        </a>
        <button type="button" onclick="window.print()" class="action-button" style="background: #0f172a; color: white; padding: 0.85rem 1.75rem; font-size: 1.05rem; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.6rem; box-shadow: 0 6px 20px rgba(15,23,42,0.2);">
            <i class="fas fa-print fa-lg"></i> Cetak Dokumen
        </button>
    </div>

    <!-- ========================================================= -->
    <!-- HALAMAN DEPAN: PIAGAM PENGHARGAAN -->
    <!-- ========================================================= -->
    <div style="margin-bottom: 1rem; text-align: left; font-weight: 700; color: #1e293b; font-size: 1.1rem; font-family: sans-serif;">
        <i class="fas fa-award text-warning mr-1"></i> 1. HALAMAN DEPAN (PIAGAM PENGHARGAAN)
    </div>

    <!-- FRAME KUNING EMAS DISDIK SUMSEL (FULL COVERAGE) -->
    <div style="
        background: #f3c72b;
        border-radius: 12px;
        padding: 6px;
        box-shadow: 0 16px 40px rgba(0,0,0,0.18);
        margin-bottom: 3rem;
        color: #000;
    ">
        <div style="
            background: #d4990a;
            border: 3px solid #78350f;
            padding: 6px;
            border-radius: 8px;
        ">
            <div style="
                background: #fffef5;
                border: 1.5px solid #92400e;
                padding: 2rem 2.5rem;
                border-radius: 6px;
            ">
                <!-- HEADER ROW -->
                <div style="display: flex; align-items: center; margin-bottom: 0.8rem;">
                    <div style="flex: 0 0 80px;">
                        <img src="{{ $logoSumselSrc }}" alt="Logo Sumsel" style="width: 75px; height: auto; display: block;">
                    </div>
                    <div style="flex: 1; text-align: center;">
                        <div style="font-size: 1.35rem; font-weight: 800; text-transform: uppercase; color: #111827; letter-spacing: 0.5px; line-height: 1.2;">
                            PEMERINTAH PROVINSI SUMATERA SELATAN
                        </div>
                        <div style="font-size: 2rem; font-weight: 900; text-transform: uppercase; color: #111827; letter-spacing: 1.5px; line-height: 1.2; margin-top: 2px;">
                            DINAS PENDIDIKAN
                        </div>
                        <div style="font-size: 0.85rem; font-style: italic; color: #374151; margin-top: 2px;">
                            Jalan Kapten A. Rivai No. 47 Palembang, Pos-el: disdiksumselprov47@gmail.com
                        </div>
                    </div>
                    <div style="flex: 0 0 80px;"></div>
                </div>

                <!-- DIVIDER -->
                <div style="border-top: 2.5px solid #78350f; border-bottom: 1px solid #78350f; height: 4px; margin-bottom: 1rem;"></div>

                <!-- TITLE -->
                <div style="text-align: center; margin-bottom: 1.2rem;">
                    <h1 style="font-size: 2.3rem; font-weight: 900; letter-spacing: 2px; margin: 0; color: #111827; text-transform: uppercase;">
                        PIAGAM PENGHARGAAN
                    </h1>
                    <div style="font-size: 1.05rem; font-style: italic; font-weight: bold; margin-top: 3px; color: #1f2937;">
                        Nomor: {{ $noSertifikat }}
                    </div>
                </div>

                <!-- WHITE BOX -->
                <div style="
                    background: #ffffff;
                    border: 1.5px solid #ca8a04;
                    border-radius: 12px;
                    padding: 1.8rem 2.2rem;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
                ">
                    <div style="font-size: 1.1rem; color: #000; margin-bottom: 0.9rem; line-height: 1.4;">
                        Kepala Dinas Pendidikan Provinsi Sumatera Selatan memberikan penghargaan kepada:
                    </div>

                    <table style="width: 100%; border-collapse: collapse; font-size: 1.1rem; color: #000; margin-bottom: 1.2rem;">
                        <tbody>
                            <tr>
                                <td style="width: 26%; padding: 4px 0;">Nama</td>
                                <td style="width: 3%;">:</td>
                                <td style="width: 71%; font-weight: bold; text-transform: uppercase;">{{ strtoupper($peserta->nama) }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0;">NISN / NIM</td>
                                <td>:</td>
                                <td style="font-weight: bold;">{{ $peserta->nim_nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0;">Asal Sekolah / Perguruan Tinggi</td>
                                <td>:</td>
                                <td style="font-weight: bold; text-transform: uppercase;">{{ strtoupper($peserta->instansi?->nama ?? $peserta->asal_sekolah ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0;">Jurusan / Program Studi</td>
                                <td>:</td>
                                <td style="font-weight: bold; text-transform: uppercase;">{{ strtoupper($peserta->jurusan ?? '-') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="font-size: 1.05rem; line-height: 1.6; text-align: justify; color: #000; margin-bottom: 1.5rem;">
                        yang telah mengikuti program pelatihan dalam pelaksanaan <strong>Praktik Kerja Lapangan (PKL) / Magang</strong> di Dinas Pendidikan
                        Provinsi Sumatera Selatan yang dilaksanakan dari tanggal {{ $tglMulaiFormatted }} sampai dengan {{ $tglSelesaiFormatted }} dengan predikat kelulusan <strong>{{ strtoupper($predikat) }}</strong>.
                    </div>

                    <!-- TTD & CAP -->
                    <div style="display: flex; justify-content: flex-end;">
                        <div style="text-align: center; width: 290px; font-size: 1rem; line-height: 1.35;">
                            Palembang, {{ $tglSertifikatFormatted }}<br>
                            a.n. <strong>Kepala Dinas Pendidikan</strong><br>
                            <strong>Plt. Sekretaris,</strong><br>

                            <div style="height: 75px; margin: 4px 0; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ $ttdSrc }}" alt="Stempel & TTD" style="max-height: 75px; max-width: 200px; object-fit: contain;">
                            </div>

                            <strong><u>Dra. PONIYEM, M.Pd.</u></strong><br>
                            Pembina Utama Muda, IV/c<br>
                            NIP. 196806042008012016
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- HALAMAN BELAKANG: DAFTAR NILAI PKL -->
    <!-- ========================================================= -->
    <div style="margin-bottom: 1rem; text-align: left; font-weight: 700; color: #1e293b; font-size: 1.1rem; font-family: sans-serif;">
        <i class="fas fa-list-ol text-success mr-1"></i> 2. HALAMAN BELAKANG (DAFTAR NILAI PKL)
    </div>

    <div style="
        background: #ffffff;
        border-radius: 12px;
        padding: 2.5rem 3rem;
        border: 2.5px solid #334155;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        margin-bottom: 3rem;
        color: #0f172a;
    ">
        <div style="text-align: center; font-weight: bold; font-size: 1.35rem; margin-bottom: 1.5rem; line-height: 1.35; text-transform: uppercase;">
            DAFTAR NILAI PRAKTIK KERJA LAPANGAN (PKL)<br>DINAS PENDIDIKAN PROVINSI SUMATERA SELATAN
        </div>

        <table style="width: 100%; border-collapse: collapse; font-weight: bold; font-size: 1.05rem; margin-bottom: 1.25rem;">
            <tbody>
                <tr>
                    <td style="width: 28%; padding: 4px 0;">NAMA</td>
                    <td style="width: 3%;">:</td>
                    <td style="width: 69%;">{{ strtoupper($peserta->nama) }}</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0;">NISN / NIM</td>
                    <td>:</td>
                    <td>{{ $peserta->nim_nisn ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0;">JURUSAN / PROGRAM STUDI</td>
                    <td>:</td>
                    <td>{{ strtoupper($peserta->jurusan ?? '-') }}</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0;">TEMPAT MAGANG / PKL</td>
                    <td>:</td>
                    <td>Dinas Pendidikan Provinsi Sumatera Selatan</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; font-size: 1rem;">
            <thead>
                <tr style="background: #f1f5f9;">
                    <th style="border: 1px solid #000; padding: 9px; text-align: center;" width="7%">NO</th>
                    <th style="border: 1px solid #000; padding: 9px; text-align: center;" width="45%">BIDANG PEKERJAAN / ASPEK PENILAIAN</th>
                    <th style="border: 1px solid #000; padding: 9px; text-align: center;" width="18%">NILAI ANGKA</th>
                    <th style="border: 1px solid #000; padding: 9px; text-align: center;" width="30%">DENGAN HURUF</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">1</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kedisiplinan</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ $kedisiplinan }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaSertifikatWeb($kedisiplinan) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">2</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kerapian</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ $kerapian }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaSertifikatWeb($kerapian) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">3</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kebersihan</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ $kebersihan }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaSertifikatWeb($kebersihan) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">4</td>
                    <td style="border: 1px solid #000; padding: 8px;">Tanggung Jawab</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ $tanggungjawab }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaSertifikatWeb($tanggungjawab) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">5</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kerjasama</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ $kerjasama }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaSertifikatWeb($kerjasama) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">6</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kreativitas</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ $kreativitas }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaSertifikatWeb($kreativitas) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">7</td>
                    <td style="border: 1px solid #000; padding: 8px;">Kejujuran</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ $kejujuran }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ terbilangAngkaSertifikatWeb($kejujuran) }}</td>
                </tr>
                <tr style="font-weight: bold; background: #f8fafc;">
                    <td style="border: 1px solid #000; padding: 9px; text-align: center;" colspan="2">JUMLAH</td>
                    <td style="border: 1px solid #000; padding: 9px; text-align: center;">{{ $jumlah }}</td>
                    <td style="border: 1px solid #000; padding: 9px; text-align: center;">{{ terbilangAngkaSertifikatWeb($jumlah) }}</td>
                </tr>
                <tr style="font-weight: bold; background: #e0f2fe;">
                    <td style="border: 1px solid #000; padding: 9px; text-align: center;" colspan="2">RATA-RATA (NILAI AKHIR)</td>
                    <td style="border: 1px solid #000; padding: 9px; text-align: center;">{{ $rataRata }}</td>
                    <td style="border: 1px solid #000; padding: 9px; text-align: center;">{{ terbilangAngkaSertifikatWeb($rataRata) }} ({{ $predikat }})</td>
                </tr>
            </tbody>
        </table>

        <!-- TTD PEMBIMBING LAPANGAN -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 1rem;">
            <div style="font-size: 0.9rem; color: #475569; padding-top: 0.5rem; line-height: 1.4;">
                <strong>Keterangan Predikat:</strong><br>
                85 - 100 : Amat Baik (A)<br>
                75 - 84 &nbsp; : Baik (B)<br>
                60 - 74 &nbsp; : Cukup (C)
            </div>
            <div style="text-align: center; width: 290px; font-size: 1rem; line-height: 1.35;">
                Palembang, {{ $tglSertifikatFormatted }}<br>
                Pembimbing Lapangan,<br>
                <div style="height: 60px;"></div>
                <strong><u>{{ $peserta->pembimbing?->nama ?? 'Pembimbing Lapangan' }}</u></strong><br>
                NIP. {{ $peserta->pembimbing?->nip ?? '-' }}
            </div>
        </div>
    </div>

    @elseif(!$penilaian)
    <div class="alert-toast alert-toast-danger" style="background: #fffbeb; border-color: #fde68a; color: #d97706; text-align: left; padding: 1rem 1.5rem; border-radius: 12px;">
        <i class="fas fa-exclamation-triangle"></i> Sertifikat belum dapat diunduh karena penilaian belum diinput oleh pembimbing.
    </div>
    @else
    <div class="alert-toast alert-toast-danger" style="text-align: left; padding: 1rem 1.5rem; border-radius: 12px;">
        <i class="fas fa-exclamation-circle"></i> Data peserta tidak ditemukan.
    </div>
    @endif
</div>
@endsection
