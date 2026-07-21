const fs = require('fs');
const data = JSON.parse(fs.readFileSync('excel_data.json', 'utf8'));

// Helper to convert "10 April 2026" to "2026-04-10"
const bulanMap = {
  'Januari': '01', 'Februari': '02', 'Maret': '03', 'April': '04',
  'Mei': '05', 'Juni': '06', 'Juli': '07', 'Agustus': '08',
  'September': '09', 'Oktober': '10', 'November': '11', 'Desember': '12'
};

function parseDate(str) {
  if (!str) return 'null';
  const parts = str.trim().split(' ');
  if (parts.length === 3) {
    const day = parts[0].padStart(2, '0');
    const month = bulanMap[parts[1]] || '01';
    const year = parts[2];
    return `'${year}-${month}-${day}'`;
  }
  return 'null';
}

function esc(v) {
  if (v === null || v === undefined) return 'null';
  return "'" + String(v).replace(/'/g, "\\'").trim() + "'";
}

function slug(str) {
  return str.toLowerCase()
    .replace(/[^a-z0-9\s]/g, '')
    .replace(/\s+/g, '_')
    .substring(0, 30);
}

// Group penilaians by nama+nis for lookup
const penilaianByNama = {};
data.penilaians.forEach(p => {
  const key = p.nama.toLowerCase().trim();
  if (!penilaianByNama[key]) penilaianByNama[key] = p;
});

let php = `<?php

namespace Database\\Seeders;

use App\\Models\\Bidang;
use App\\Models\\Instansi;
use App\\Models\\Pembimbing;
use App\\Models\\Pengajuan;
use App\\Models\\Peserta;
use App\\Models\\Penilaian;
use App\\Models\\User;
use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================
        // MASTER DATA: Bidang (dari Excel, col TEMPAT PKL)
        // =========================================
        $bidangs = [];
`;

data.bidangs.forEach(b => {
  const varName = '$bidang_' + slug(b);
  php += `        ${varName} = Bidang::create(['nama' => ${esc(b)}, 'deskripsi' => null]);\n`;
  php += `        $bidangs[${esc(b)}] = ${varName};\n`;
});

php += `
        // =========================================
        // MASTER DATA: Instansi (dari Excel, col UNIT KERJA ASAL)
        // =========================================
        $instansis = [];
`;

data.instansis.forEach(i => {
  const varName = '$instansi_' + slug(i);
  php += `        ${varName} = Instansi::create(['nama' => ${esc(i)}, 'alamat' => null, 'telp' => null, 'email' => null]);\n`;
  php += `        $instansis[${esc(i)}] = ${varName};\n`;
});

php += `
        // =========================================
        // PEMBIMBING (satu default per bidang)
        // =========================================
        $defaultPembimbing = [];
        foreach ($bidangs as $namaBidang => $bidangObj) {
            $userPemb = User::create([
                'name'     => 'Pembimbing ' . $bidangObj->nama,
                'email'    => 'pemb_' . $bidangObj->id . '@magang.id',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_PEMBIMBING,
            ]);
            $pemb = Pembimbing::create([
                'user_id'   => $userPemb->id,
                'bidang_id' => $bidangObj->id,
                'nip'       => null,
                'nama'      => 'Pembimbing ' . $bidangObj->nama,
                'no_hp'     => null,
            ]);
            $defaultPembimbing[$namaBidang] = $pemb;
        }

        // =========================================
        // PENGAJUAN (satu per instansi)
        // =========================================
        $pengajuans = [];
        foreach ($instansis as $namaInstansi => $instansiObj) {
            $pengajuan = Pengajuan::create([
                'instansi_id'   => $instansiObj->id,
                'nama_instansi' => $instansiObj->nama,
                'pic_nama'      => 'PIC ' . $instansiObj->nama,
                'pic_email'     => 'pic@' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $instansiObj->nama)) . '.id',
                'pic_telp'      => '08' . rand(1000000000, 9999999999),
                'jml_peserta'   => 1,
                'tgl_mulai'     => '2026-01-01',
                'tgl_selesai'   => '2026-12-31',
                'status'        => 'approved',
            ]);
            $pengajuans[$namaInstansi] = $pengajuan;
        }

        // =========================================
        // PESERTA (dari Excel, sheet DATA)
        // =========================================
        $pesertaObjs = [];
`;

data.pesertas.forEach((p, idx) => {
  const emailBase = slug(p.nama) + '_' + (idx + 1);
  const tglMulai = parseDate(p.tgl_mulai);
  const tglSelesai = parseDate(p.tgl_selesai);
  const status = (p.keterangan === 'SELESAI' || (p.tgl_selesai && new Date(p.tgl_selesai.split(' ').reverse().join('-')) < new Date())) ? 'selesai' : 'aktif';
  
  php += `
        // Peserta #${idx + 1}: ${p.nama}
        {
            $userP = User::create([
                'name'     => ${esc(p.nama)},
                'email'    => '${emailBase}@magang.id',
                'password' => Hash::make(${esc(p.nim_nisn || 'password123')}),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs[${esc(p.bidang)}] ?? null;
            $instansiPeserta = $instansis[${esc(p.instansi)}] ?? null;
            $pengajuanPeserta = $pengajuans[${esc(p.instansi)}] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => ${esc(p.nim_nisn)},
                'nama'          => ${esc(p.nama)},
                'jurusan'       => ${esc(p.jurusan)},
                'jenis_peserta' => ${esc(p.jenis_peserta)},
                'tgl_mulai'     => ${tglMulai},
                'tgl_selesai'   => ${tglSelesai},
                'status'        => '${status}',
            ]);
            $pesertaObjs[] = $peserta;
        }`;
});

// Add penilaian for peserta who have data in SERTIFIKAT
php += `

        // =========================================
        // PENILAIAN (dari Excel, sheet SERTIFIKAT - match by nama)
        // =========================================
        $penilaianData = [\n`;

// Take first 50 penilaian as sample
const samplePenilaian = data.penilaians.slice(0, 100);
samplePenilaian.forEach(p => {
  php += `            [\n`;
  php += `                'nama' => ${esc(p.nama)},\n`;
  php += `                'no_sertifikat' => ${esc(p.no_sertifikat)},\n`;
  php += `                'kedisiplinan'  => ${p.kedisiplinan !== null ? p.kedisiplinan : 'null'},\n`;
  php += `                'kerapian'      => ${p.kerapian !== null ? p.kerapian : 'null'},\n`;
  php += `                'kebersihan'    => ${p.kebersihan !== null ? p.kebersihan : 'null'},\n`;
  php += `                'tanggung_jawab'=> ${p.tanggung_jawab !== null ? p.tanggung_jawab : 'null'},\n`;
  php += `                'kerjasama'     => ${p.kerjasama !== null ? p.kerjasama : 'null'},\n`;
  php += `                'kreativitas'   => ${p.kreativitas !== null ? p.kreativitas : 'null'},\n`;
  php += `                'kejujuran'     => ${p.kejujuran !== null ? p.kejujuran : 'null'},\n`;
  php += `                'nilai_angka'   => ${p.rata_rata !== null ? Number(p.rata_rata).toFixed(2) : 'null'},\n`;
  php += `            ],\n`;
});

php += `        ];

        foreach ($pesertaObjs as $pesertaObj) {
            foreach ($penilaianData as $pd) {
                if (strtolower(trim($pd['nama'])) === strtolower(trim($pesertaObj->nama))) {
                    $pembimbingForPenilaian = $pesertaObj->bidang_id 
                        ? ($defaultPembimbing[\\App\\Models\\Bidang::find($pesertaObj->bidang_id)?->nama] ?? null) 
                        : null;
                    Penilaian::create([
                        'peserta_id'    => $pesertaObj->id,
                        'pembimbing_id' => $pembimbingForPenilaian?->id,
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
                    break;
                }
            }
        }
    }
}
`;

fs.writeFileSync('database/seeders/DemoSeeder.php', php);
console.log('DemoSeeder.php generated successfully!');
console.log(`- ${data.bidangs.length} bidangs`);
console.log(`- ${data.instansis.length} instansis`);
console.log(`- ${data.pesertas.length} pesertas`);
console.log(`- ${samplePenilaian.length} penilaians (sample from ${data.penilaians.length})`);
