const fs = require('fs');
const data = JSON.parse(fs.readFileSync('excel_data.json', 'utf8'));

// Since SERTIFIKAT data is from different years than peserta in DATA sheet,
// we'll assign penilaian to existing peserta based on instansi matching,
// or just create standalone penilaian records linked to existing pesertas

// Generate SQL INSERT for penilaians
// We'll insert penilaians for the peserta that exist

// Get peserta list
const pesertas = data.pesertas;
const penilaians = data.penilaians;

// Create a PHP command to insert penilaians
let php = `<?php
// artisan tinker command to insert penilaians
// Run: php artisan tinker < insert_penilaian.php

use App\\Models\\Peserta;
use App\\Models\\Penilaian;
use App\\Models\\Pembimbing;

$pesertas = Peserta::with('bidang')->get();
$penilaianData = [
`;

// Only insert up to 50 penilaians, assign to existing peserta
const samplePenilaian = penilaians.slice(0, 50);
samplePenilaian.forEach(p => {
  php += `    [\n`;
  php += `        'no_sertifikat' => ${p.no_sertifikat !== null ? `'${p.no_sertifikat}'` : 'null'},\n`;
  php += `        'kedisiplinan'  => ${p.kedisiplinan !== null ? p.kedisiplinan : 'null'},\n`;
  php += `        'kerapian'      => ${p.kerapian !== null ? p.kerapian : 'null'},\n`;
  php += `        'kebersihan'    => ${p.kebersihan !== null ? p.kebersihan : 'null'},\n`;
  php += `        'tanggung_jawab'=> ${p.tanggung_jawab !== null ? p.tanggung_jawab : 'null'},\n`;
  php += `        'kerjasama'     => ${p.kerjasama !== null ? p.kerjasama : 'null'},\n`;
  php += `        'kreativitas'   => ${p.kreativitas !== null ? p.kreativitas : 'null'},\n`;
  php += `        'kejujuran'     => ${p.kejujuran !== null ? p.kejujuran : 'null'},\n`;
  php += `        'nilai_angka'   => ${p.rata_rata !== null ? Number(p.rata_rata).toFixed(2) : 'null'},\n`;
  php += `    ],\n`;
});

php += `];

// Distribute penilaian to peserta (round robin)
foreach ($pesertas as $idx => $peserta) {
    if (!isset($penilaianData[$idx % count($penilaianData)])) continue;
    $pd = $penilaianData[$idx % count($penilaianData)];
    
    // Skip if penilaian already exists
    if ($peserta->penilaian) continue;
    
    $pembimbing = $peserta->bidang_id 
        ? \\App\\Models\\Pembimbing::where('bidang_id', $peserta->bidang_id)->first() 
        : null;
    
    Penilaian::create([
        'peserta_id'    => $peserta->id,
        'pembimbing_id' => $pembimbing?->id,
        'no_sertifikat' => $pd['no_sertifikat'],
        'kedisiplinan'  => $pd['kedisiplinan'],
        'kerapian'      => $pd['kerapian'],
        'kebersihan'    => $pd['kebersihan'],
        'tanggung_jawab'=> $pd['tanggung_jawab'],
        'kerjasama'     => $pd['kerjasama'],
        'kreativitas'   => $pd['kreativitas'],
        'kejujuran'     => $pd['kejujuran'],
        'nilai_angka'   => $pd['nilai_angka'],
    ]);
}

echo "Penilaian count: " . Penilaian::count() . PHP_EOL;
`;

fs.writeFileSync('insert_penilaian.php', php);
console.log('insert_penilaian.php created');
