<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$peserta = \App\Models\Peserta::with(['bidang', 'pembimbing', 'instansi', 'pengajuan'])->first();
$penilaian = $peserta?->penilaian;
if (!$penilaian) {
    $penilaian = new \App\Models\Penilaian([
        'kedisiplinan' => 90,
        'kerapian' => 88,
        'kebersihan' => 88,
        'tanggung_jawab' => 90,
        'kerjasama' => 92,
        'kreativitas' => 90,
        'kejujuran' => 95,
    ]);
}

$pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('peserta.sertifikat_pdf', compact('peserta', 'penilaian'))
          ->setPaper('a4', 'landscape');
$pdf->save(public_path('test_landscape_sertifikat.pdf'));
echo "SUCCESS: " . public_path('test_landscape_sertifikat.pdf') . "\n";
