@extends('layouts.adminlte')
@section('title', 'Penilaian Saya')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-star"></i> Penilaian Saya</h1>
        <p>Hasil evaluasi dan lembar nilai Praktik Kerja Lapangan (PKL) Anda.</p>
    </div>
</div>

<div class="table-container mb-4">
    <div class="table-toolbar">
        <h3><i class="fas fa-award"></i> DAFTAR NILAI MAHASISWA PRAKTIK KERJA LAPANGAN</h3>
    </div>
    <div style="padding: 1.5rem;">
        @if($penilaian)
        @php
            if (!function_exists('terbilangAngkaWeb')) {
                function terbilangAngkaWeb($angka) {
                    $angka = (int) round($angka);
                    $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
                    if ($angka < 12) return $baca[$angka];
                    elseif ($angka < 20) return terbilangAngkaWeb($angka - 10) . ' Belas';
                    elseif ($angka < 100) return terbilangAngkaWeb(floor($angka / 10)) . ' Puluh' . ($angka % 10 != 0 ? ' ' . terbilangAngkaWeb($angka % 10) : '');
                    elseif ($angka < 200) return 'Seratus' . ($angka - 100 != 0 ? ' ' . terbilangAngkaWeb($angka - 100) : '');
                    elseif ($angka < 1000) return terbilangAngkaWeb(floor($angka / 100)) . ' Ratus' . ($angka % 100 != 0 ? ' ' . terbilangAngkaWeb($angka % 100) : '');
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

        <!-- Data Info Header -->
        <div style="background: #f8fafc; border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem; border: 1px solid #e2e8f0; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <div>
                <small style="color: #64748b; font-weight: 600; display: block;">NAMA PESERTA</small>
                <strong style="color: #0f172a; font-size: 1.1rem;">{{ strtoupper($peserta->nama ?? auth()->user()->name) }}</strong>
            </div>
            <div>
                <small style="color: #64748b; font-weight: 600; display: block;">JURUSAN / PROGRAM STUDI</small>
                <strong style="color: #0f172a; font-size: 1.1rem;">{{ strtoupper($peserta->jurusan ?? '-') }}</strong>
            </div>
            <div>
                <small style="color: #64748b; font-weight: 600; display: block;">TEMPAT PKL</small>
                <strong style="color: #0f172a; font-size: 1.1rem;">Dinas Pendidikan Provinsi Sumatera Selatan</strong>
            </div>
        </div>

        <!-- Table 7 Komponen Penilaian -->
        <div class="table-scroll" style="margin-bottom: 1.5rem;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #f1f5f9;">
                        <th width="50" style="text-align: center;">NO</th>
                        <th>BIDANG PEKERJAAN YANG DILATIHKAN</th>
                        <th width="150" style="text-align: center;">DENGAN ANGKA</th>
                        <th width="250" style="text-align: center;">DENGAN HURUF</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; font-weight: 600;">1</td>
                        <td style="font-weight: 500;">Kedisiplinan</td>
                        <td style="text-align: center; font-weight: 700; color: #0f172a;">{{ $kedisiplinan }}</td>
                        <td style="text-align: center; font-weight: 500;">{{ terbilangAngkaWeb($kedisiplinan) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: 600;">2</td>
                        <td style="font-weight: 500;">Kerapian</td>
                        <td style="text-align: center; font-weight: 700; color: #0f172a;">{{ $kerapian }}</td>
                        <td style="text-align: center; font-weight: 500;">{{ terbilangAngkaWeb($kerapian) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: 600;">3</td>
                        <td style="font-weight: 500;">Kebersihan</td>
                        <td style="text-align: center; font-weight: 700; color: #0f172a;">{{ $kebersihan }}</td>
                        <td style="text-align: center; font-weight: 500;">{{ terbilangAngkaWeb($kebersihan) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: 600;">4</td>
                        <td style="font-weight: 500;">Tanggung jawab</td>
                        <td style="text-align: center; font-weight: 700; color: #0f172a;">{{ $tanggungjawab }}</td>
                        <td style="text-align: center; font-weight: 500;">{{ terbilangAngkaWeb($tanggungjawab) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: 600;">5</td>
                        <td style="font-weight: 500;">Kerjasama</td>
                        <td style="text-align: center; font-weight: 700; color: #0f172a;">{{ $kerjasama }}</td>
                        <td style="text-align: center; font-weight: 500;">{{ terbilangAngkaWeb($kerjasama) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: 600;">6</td>
                        <td style="font-weight: 500;">Kreativitas</td>
                        <td style="text-align: center; font-weight: 700; color: #0f172a;">{{ $kreativitas }}</td>
                        <td style="text-align: center; font-weight: 500;">{{ terbilangAngkaWeb($kreativitas) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: 600;">7</td>
                        <td style="font-weight: 500;">Kejujuran</td>
                        <td style="text-align: center; font-weight: 700; color: #0f172a;">{{ $kejujuran }}</td>
                        <td style="text-align: center; font-weight: 500;">{{ terbilangAngkaWeb($kejujuran) }}</td>
                    </tr>
                    <tr style="background: #f8fafc; border-top: 2px solid #cbd5e1;">
                        <td colspan="2" style="font-weight: 700; color: #0f172a;">JUMLAH</td>
                        <td style="text-align: center; font-weight: 800; font-size: 1.1rem; color: #0f172a;">{{ $jumlah }}</td>
                        <td style="text-align: center; font-weight: 700; color: #0f172a;">{{ terbilangAngkaWeb($jumlah) }}</td>
                    </tr>
                    <tr style="background: #eff6ff; border-top: 1px solid #bfdbfe;">
                        <td colspan="2" style="font-weight: 700; color: #1d4ed8;">RATA-RATA</td>
                        <td style="text-align: center; font-weight: 800; font-size: 1.2rem; color: #1d4ed8;">{{ $rataRata }}</td>
                        <td style="text-align: center; font-weight: 700; color: #1d4ed8;">{{ terbilangAngkaWeb($rataRata) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('peserta.sertifikat') }}" class="action-button" style="background: #16a34a; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.2);">
                <i class="fas fa-certificate mr-1"></i> Lihat & Unduh Sertifikat (Piagam Penghargaan)
            </a>
        </div>
        @else
        <div class="alert-toast alert-toast-danger" style="background: #fffbeb; border-color: #fde68a; color: #d97706;">
            <i class="fas fa-info-circle"></i> Penilaian belum tersedia. Hubungi pembimbing Anda untuk mengisi evaluasi 7 indikator kinerja.
        </div>
        @endif
    </div>
</div>
@endsection
