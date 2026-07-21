<?php

namespace App\Console\Commands;

use App\Models\Pembimbing;
use App\Models\Penilaian;
use App\Models\Peserta;
use Illuminate\Console\Command;

class InsertPenilaian extends Command
{
    protected $signature   = 'magang:insert-penilaian';
    protected $description = 'Insert data penilaian dari Excel untuk peserta yang ada';

    public function handle(): int
    {
        // Data penilaian dari Excel sheet SERTIFIKAT (sample representatif)
        $penilaianData = [
            ['no_sertifikat' => '5152', 'kedisiplinan' => 88, 'kerapian' => 86, 'kebersihan' => 86, 'tanggung_jawab' => 86, 'kerjasama' => 87, 'kreativitas' => 87, 'kejujuran' => 86, 'nilai_angka' => 86.57],
            ['no_sertifikat' => '5152', 'kedisiplinan' => 88, 'kerapian' => 86, 'kebersihan' => 86, 'tanggung_jawab' => 86, 'kerjasama' => 87, 'kreativitas' => 87, 'kejujuran' => 86, 'nilai_angka' => 86.57],
            ['no_sertifikat' => '5152', 'kedisiplinan' => 88, 'kerapian' => 86, 'kebersihan' => 86, 'tanggung_jawab' => 87, 'kerjasama' => 88, 'kreativitas' => 88, 'kejujuran' => 87, 'nilai_angka' => 87.14],
            ['no_sertifikat' => '5152', 'kedisiplinan' => 90, 'kerapian' => 90, 'kebersihan' => 90, 'tanggung_jawab' => 90, 'kerjasama' => 90, 'kreativitas' => 90, 'kejujuran' => 90, 'nilai_angka' => 90.00],
            ['no_sertifikat' => '5152', 'kedisiplinan' => 90, 'kerapian' => 90, 'kebersihan' => 90, 'tanggung_jawab' => 90, 'kerjasama' => 90, 'kreativitas' => 90, 'kejujuran' => 90, 'nilai_angka' => 90.00],
            ['no_sertifikat' => '7185', 'kedisiplinan' => 98, 'kerapian' => 100, 'kebersihan' => 100, 'tanggung_jawab' => 98, 'kerjasama' => 100, 'kreativitas' => 95, 'kejujuran' => 100, 'nilai_angka' => 98.71],
            ['no_sertifikat' => '7188', 'kedisiplinan' => 92, 'kerapian' => 90, 'kebersihan' => 89, 'tanggung_jawab' => 91, 'kerjasama' => 93, 'kreativitas' => 88, 'kejujuran' => 90, 'nilai_angka' => 90.43],
            ['no_sertifikat' => '7189', 'kedisiplinan' => 91, 'kerapian' => 90, 'kebersihan' => 89, 'tanggung_jawab' => 91, 'kerjasama' => 93, 'kreativitas' => 88, 'kejujuran' => 91, 'nilai_angka' => 90.43],
            ['no_sertifikat' => '7190', 'kedisiplinan' => 90, 'kerapian' => 90, 'kebersihan' => 90, 'tanggung_jawab' => 90, 'kerjasama' => 90, 'kreativitas' => 90, 'kejujuran' => 90, 'nilai_angka' => 90.00],
            ['no_sertifikat' => '7191', 'kedisiplinan' => 88, 'kerapian' => 87, 'kebersihan' => 88, 'tanggung_jawab' => 88, 'kerjasama' => 90, 'kreativitas' => 85, 'kejujuran' => 88, 'nilai_angka' => 87.71],
            ['no_sertifikat' => '7192', 'kedisiplinan' => 90, 'kerapian' => 89, 'kebersihan' => 89, 'tanggung_jawab' => 90, 'kerjasama' => 91, 'kreativitas' => 88, 'kejujuran' => 90, 'nilai_angka' => 89.57],
            ['no_sertifikat' => '7217', 'kedisiplinan' => 85, 'kerapian' => 85, 'kebersihan' => 85, 'tanggung_jawab' => 85, 'kerjasama' => 85, 'kreativitas' => 85, 'kejujuran' => 85, 'nilai_angka' => 85.00],
            ['no_sertifikat' => '7218', 'kedisiplinan' => 87, 'kerapian' => 86, 'kebersihan' => 86, 'tanggung_jawab' => 87, 'kerjasama' => 88, 'kreativitas' => 85, 'kejujuran' => 87, 'nilai_angka' => 86.57],
            ['no_sertifikat' => '7219', 'kedisiplinan' => 88, 'kerapian' => 87, 'kebersihan' => 87, 'tanggung_jawab' => 88, 'kerjasama' => 89, 'kreativitas' => 86, 'kejujuran' => 88, 'nilai_angka' => 87.57],
            ['no_sertifikat' => '7300', 'kedisiplinan' => 92, 'kerapian' => 91, 'kebersihan' => 91, 'tanggung_jawab' => 92, 'kerjasama' => 93, 'kreativitas' => 89, 'kejujuran' => 92, 'nilai_angka' => 91.43],
            ['no_sertifikat' => '7301', 'kedisiplinan' => 89, 'kerapian' => 88, 'kebersihan' => 88, 'tanggung_jawab' => 89, 'kerjasama' => 90, 'kreativitas' => 87, 'kejujuran' => 89, 'nilai_angka' => 88.57],
            ['no_sertifikat' => '7302', 'kedisiplinan' => 86, 'kerapian' => 85, 'kebersihan' => 85, 'tanggung_jawab' => 86, 'kerjasama' => 87, 'kreativitas' => 84, 'kejujuran' => 86, 'nilai_angka' => 85.57],
            ['no_sertifikat' => '7303', 'kedisiplinan' => 90, 'kerapian' => 89, 'kebersihan' => 89, 'tanggung_jawab' => 90, 'kerjasama' => 91, 'kreativitas' => 88, 'kejujuran' => 90, 'nilai_angka' => 89.57],
            ['no_sertifikat' => '7304', 'kedisiplinan' => 87, 'kerapian' => 86, 'kebersihan' => 86, 'tanggung_jawab' => 87, 'kerjasama' => 88, 'kreativitas' => 85, 'kejujuran' => 87, 'nilai_angka' => 86.57],
            ['no_sertifikat' => '7305', 'kedisiplinan' => 91, 'kerapian' => 90, 'kebersihan' => 90, 'tanggung_jawab' => 91, 'kerjasama' => 92, 'kreativitas' => 89, 'kejujuran' => 91, 'nilai_angka' => 90.57],
            ['no_sertifikat' => '7500', 'kedisiplinan' => 85, 'kerapian' => 84, 'kebersihan' => 84, 'tanggung_jawab' => 85, 'kerjasama' => 86, 'kreativitas' => 83, 'kejujuran' => 85, 'nilai_angka' => 84.57],
            ['no_sertifikat' => '7501', 'kedisiplinan' => 88, 'kerapian' => 87, 'kebersihan' => 87, 'tanggung_jawab' => 88, 'kerjasama' => 89, 'kreativitas' => 86, 'kejujuran' => 88, 'nilai_angka' => 87.57],
            ['no_sertifikat' => '7502', 'kedisiplinan' => 93, 'kerapian' => 92, 'kebersihan' => 92, 'tanggung_jawab' => 93, 'kerjasama' => 94, 'kreativitas' => 90, 'kejujuran' => 93, 'nilai_angka' => 92.43],
            ['no_sertifikat' => '7600', 'kedisiplinan' => 90, 'kerapian' => 89, 'kebersihan' => 89, 'tanggung_jawab' => 90, 'kerjasama' => 91, 'kreativitas' => 88, 'kejujuran' => 90, 'nilai_angka' => 89.57],
            ['no_sertifikat' => '7601', 'kedisiplinan' => 87, 'kerapian' => 86, 'kebersihan' => 86, 'tanggung_jawab' => 87, 'kerjasama' => 88, 'kreativitas' => 85, 'kejujuran' => 87, 'nilai_angka' => 86.57],
            ['no_sertifikat' => '7602', 'kedisiplinan' => 88, 'kerapian' => 87, 'kebersihan' => 87, 'tanggung_jawab' => 88, 'kerjasama' => 89, 'kreativitas' => 86, 'kejujuran' => 88, 'nilai_angka' => 87.57],
            ['no_sertifikat' => '7700', 'kedisiplinan' => 92, 'kerapian' => 91, 'kebersihan' => 91, 'tanggung_jawab' => 92, 'kerjasama' => 93, 'kreativitas' => 89, 'kejujuran' => 92, 'nilai_angka' => 91.43],
            ['no_sertifikat' => '7701', 'kedisiplinan' => 86, 'kerapian' => 85, 'kebersihan' => 85, 'tanggung_jawab' => 86, 'kerjasama' => 87, 'kreativitas' => 84, 'kejujuran' => 86, 'nilai_angka' => 85.57],
            ['no_sertifikat' => '7800', 'kedisiplinan' => 89, 'kerapian' => 88, 'kebersihan' => 88, 'tanggung_jawab' => 89, 'kerjasama' => 90, 'kreativitas' => 87, 'kejujuran' => 89, 'nilai_angka' => 88.57],
            ['no_sertifikat' => '7801', 'kedisiplinan' => 91, 'kerapian' => 90, 'kebersihan' => 90, 'tanggung_jawab' => 91, 'kerjasama' => 92, 'kreativitas' => 89, 'kejujuran' => 91, 'nilai_angka' => 90.57],
            ['no_sertifikat' => '7900', 'kedisiplinan' => 85, 'kerapian' => 84, 'kebersihan' => 84, 'tanggung_jawab' => 85, 'kerjasama' => 86, 'kreativitas' => 83, 'kejujuran' => 85, 'nilai_angka' => 84.57],
            ['no_sertifikat' => '7901', 'kedisiplinan' => 90, 'kerapian' => 89, 'kebersihan' => 89, 'tanggung_jawab' => 90, 'kerjasama' => 91, 'kreativitas' => 88, 'kejujuran' => 90, 'nilai_angka' => 89.57],
            ['no_sertifikat' => '8000', 'kedisiplinan' => 88, 'kerapian' => 87, 'kebersihan' => 87, 'tanggung_jawab' => 88, 'kerjasama' => 89, 'kreativitas' => 86, 'kejujuran' => 88, 'nilai_angka' => 87.57],
            ['no_sertifikat' => '8001', 'kedisiplinan' => 92, 'kerapian' => 91, 'kebersihan' => 91, 'tanggung_jawab' => 92, 'kerjasama' => 93, 'kreativitas' => 89, 'kejujuran' => 92, 'nilai_angka' => 91.43],
        ];

        $pesertas = Peserta::with(['bidang', 'penilaian'])->get();
        $inserted = 0;
        $total    = count($penilaianData);

        foreach ($pesertas as $idx => $peserta) {
            // Skip if already has penilaian
            if ($peserta->penilaian) {
                continue;
            }

            $pd = $penilaianData[$idx % $total];

            $pembimbing = $peserta->bidang_id
                ? Pembimbing::where('bidang_id', $peserta->bidang_id)->first()
                : null;

            Penilaian::create([
                'peserta_id'     => $peserta->id,
                'pembimbing_id'  => $pembimbing?->id,
                'no_sertifikat'  => $pd['no_sertifikat'],
                'kedisiplinan'   => $pd['kedisiplinan'],
                'kerapian'       => $pd['kerapian'],
                'kebersihan'     => $pd['kebersihan'],
                'tanggung_jawab' => $pd['tanggung_jawab'],
                'kerjasama'      => $pd['kerjasama'],
                'kreativitas'    => $pd['kreativitas'],
                'kejujuran'      => $pd['kejujuran'],
                'nilai_angka'    => $pd['nilai_angka'],
            ]);

            $inserted++;
        }

        $this->info("Penilaian berhasil diinsert: {$inserted} records");
        $this->info("Total penilaian di database: " . Penilaian::count());

        return Command::SUCCESS;
    }
}
