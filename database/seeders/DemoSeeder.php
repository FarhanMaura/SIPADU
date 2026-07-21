<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\Instansi;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use App\Models\Peserta;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================
        // MASTER DATA: Bidang (dari Excel, col TEMPAT PKL)
        // =========================================
        $bidangs = [];
        $bidang_subbagian_umum_dan_kepegawaian = Bidang::create(['nama' => 'Subbagian Umum dan Kepegawaian', 'deskripsi' => null]);
        $bidangs['Subbagian Umum dan Kepegawaian'] = $bidang_subbagian_umum_dan_kepegawaian;
        $bidang_subbagian_keuangan = Bidang::create(['nama' => 'Subbagian Keuangan', 'deskripsi' => null]);
        $bidangs['Subbagian Keuangan'] = $bidang_subbagian_keuangan;
        $bidang_seksi_peserta_didik_smk = Bidang::create(['nama' => 'Seksi Peserta Didik SMK', 'deskripsi' => null]);
        $bidangs['Seksi Peserta Didik SMK'] = $bidang_seksi_peserta_didik_smk;
        $bidang_seksi_tugas_pembantuan = Bidang::create(['nama' => 'Seksi Tugas Pembantuan', 'deskripsi' => null]);
        $bidangs['Seksi Tugas Pembantuan'] = $bidang_seksi_tugas_pembantuan;
        $bidang_sapras = Bidang::create(['nama' => 'SAPRAS', 'deskripsi' => null]);
        $bidangs['SAPRAS'] = $bidang_sapras;
        $bidang_seksi_kurikulum_dan_peserta_di = Bidang::create(['nama' => 'Seksi Kurikulum dan Peserta Didik', 'deskripsi' => null]);
        $bidangs['Seksi Kurikulum dan Peserta Didik'] = $bidang_seksi_kurikulum_dan_peserta_di;
        $bidang_subbagian_perencanaan_evaluasi = Bidang::create(['nama' => 'Subbagian Perencanaan Evaluasi dan Pelaporan', 'deskripsi' => null]);
        $bidangs['Subbagian Perencanaan Evaluasi dan Pelaporan'] = $bidang_subbagian_perencanaan_evaluasi;
        $bidang_seksi_ptk_sma = Bidang::create(['nama' => 'Seksi PTK SMA', 'deskripsi' => null]);
        $bidangs['Seksi PTK SMA'] = $bidang_seksi_ptk_sma;
        $bidang_seksi_kurikulum_sma = Bidang::create(['nama' => 'Seksi Kurikulum SMA', 'deskripsi' => null]);
        $bidangs['Seksi Kurikulum SMA'] = $bidang_seksi_kurikulum_sma;
        $bidang_seksi_peserta_didik_sma = Bidang::create(['nama' => 'Seksi Peserta Didik SMA', 'deskripsi' => null]);
        $bidangs['Seksi Peserta Didik SMA'] = $bidang_seksi_peserta_didik_sma;
        $bidang_seksi_ptk_smk = Bidang::create(['nama' => 'Seksi PTK SMK', 'deskripsi' => null]);
        $bidangs['Seksi PTK SMK'] = $bidang_seksi_ptk_smk;
        $bidang_seksi_kurikulum_smk = Bidang::create(['nama' => 'Seksi Kurikulum SMK', 'deskripsi' => null]);
        $bidangs['Seksi Kurikulum SMK'] = $bidang_seksi_kurikulum_smk;
        $bidang_seksi_sarana_prasarana_pklk = Bidang::create(['nama' => 'Seksi Sarana Prasarana PKLK', 'deskripsi' => null]);
        $bidangs['Seksi Sarana Prasarana PKLK'] = $bidang_seksi_sarana_prasarana_pklk;

        // =========================================
        // MASTER DATA: Instansi (dari Excel, col UNIT KERJA ASAL)
        // =========================================
        $instansis = [];
        $instansi_stia_bala_putra_dewa = Instansi::create(['nama' => 'STIA Bala Putra Dewa', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['STIA Bala Putra Dewa'] = $instansi_stia_bala_putra_dewa;
        $instansi_smkn_bakti_ibu_3 = Instansi::create(['nama' => 'SMKN BAKTI IBU 3', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['SMKN BAKTI IBU 3'] = $instansi_smkn_bakti_ibu_3;
        $instansi_polsri = Instansi::create(['nama' => 'POLSRI', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['POLSRI'] = $instansi_polsri;
        $instansi_smk_negeri_2_palembang = Instansi::create(['nama' => 'SMK Negeri 2 Palembang', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['SMK Negeri 2 Palembang'] = $instansi_smk_negeri_2_palembang;
        $instansi_uin_raden_fatah_palembang = Instansi::create(['nama' => 'UIN Raden Fatah Palembang', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['UIN Raden Fatah Palembang'] = $instansi_uin_raden_fatah_palembang;
        $instansi_universitas_bina_darma_palemba = Instansi::create(['nama' => 'Universitas Bina Darma Palembang', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['Universitas Bina Darma Palembang'] = $instansi_universitas_bina_darma_palemba;
        $instansi_smk_bistek_palembang = Instansi::create(['nama' => 'SMK Bistek Palembang', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['SMK Bistek Palembang'] = $instansi_smk_bistek_palembang;
        $instansi_smk_bina_jaya_palembang = Instansi::create(['nama' => 'SMK Bina Jaya Palembang', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['SMK Bina Jaya Palembang'] = $instansi_smk_bina_jaya_palembang;
        $instansi_smk_pembina_1_palembang = Instansi::create(['nama' => 'SMK Pembina 1 Palembang', 'alamat' => null, 'telp' => null, 'email' => null]);
        $instansis['SMK Pembina 1 Palembang'] = $instansi_smk_pembina_1_palembang;

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

        // Peserta #1: Yunita
        {
            $userP = User::create([
                'name'     => 'Yunita',
                'email'    => 'yunita_1@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Umum dan Kepegawaian'] ?? null;
            $instansiPeserta = $instansis['STIA Bala Putra Dewa'] ?? null;
            $pengajuanPeserta = $pengajuans['STIA Bala Putra Dewa'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Yunita',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-04-10',
                'tgl_selesai'   => '2026-05-10',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #2: Sri Wulandari
        {
            $userP = User::create([
                'name'     => 'Sri Wulandari',
                'email'    => 'sri_wulandari_2@magang.id',
                'password' => Hash::make('22320220'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Umum dan Kepegawaian'] ?? null;
            $instansiPeserta = $instansis['STIA Bala Putra Dewa'] ?? null;
            $pengajuanPeserta = $pengajuans['STIA Bala Putra Dewa'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '22320220',
                'nama'          => 'Sri Wulandari',
                'jurusan'       => 'S1 Ilmu Administrasi Negara',
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-04-10',
                'tgl_selesai'   => '2026-05-10',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #3: M. Galang Ramadhan
        {
            $userP = User::create([
                'name'     => 'M. Galang Ramadhan',
                'email'    => 'm_galang_ramadhan_3@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Keuangan'] ?? null;
            $instansiPeserta = $instansis['SMKN BAKTI IBU 3'] ?? null;
            $pengajuanPeserta = $pengajuans['SMKN BAKTI IBU 3'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'M. Galang Ramadhan',
                'jurusan'       => null,
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-02-02',
                'tgl_selesai'   => '2026-05-04',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #4: Nanda Dimas Firmansyah
        {
            $userP = User::create([
                'name'     => 'Nanda Dimas Firmansyah',
                'email'    => 'nanda_dimas_firmansyah_4@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Peserta Didik SMK'] ?? null;
            $instansiPeserta = $instansis['SMKN BAKTI IBU 3'] ?? null;
            $pengajuanPeserta = $pengajuans['SMKN BAKTI IBU 3'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Nanda Dimas Firmansyah',
                'jurusan'       => null,
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-02-02',
                'tgl_selesai'   => '2026-05-04',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #5: Rapit Angga Saputra
        {
            $userP = User::create([
                'name'     => 'Rapit Angga Saputra',
                'email'    => 'rapit_angga_saputra_5@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Peserta Didik SMK'] ?? null;
            $instansiPeserta = $instansis['SMKN BAKTI IBU 3'] ?? null;
            $pengajuanPeserta = $pengajuans['SMKN BAKTI IBU 3'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Rapit Angga Saputra',
                'jurusan'       => null,
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-02-02',
                'tgl_selesai'   => '2026-05-04',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #6: Satria Fahri Kencana
        {
            $userP = User::create([
                'name'     => 'Satria Fahri Kencana',
                'email'    => 'satria_fahri_kencana_6@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Keuangan'] ?? null;
            $instansiPeserta = $instansis['SMKN BAKTI IBU 3'] ?? null;
            $pengajuanPeserta = $pengajuans['SMKN BAKTI IBU 3'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Satria Fahri Kencana',
                'jurusan'       => null,
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-02-02',
                'tgl_selesai'   => '2026-05-04',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #7: Keysha Amanda Dinanti
        {
            $userP = User::create([
                'name'     => 'Keysha Amanda Dinanti',
                'email'    => 'keysha_amanda_dinanti_7@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Tugas Pembantuan'] ?? null;
            $instansiPeserta = $instansis['SMKN BAKTI IBU 3'] ?? null;
            $pengajuanPeserta = $pengajuans['SMKN BAKTI IBU 3'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Keysha Amanda Dinanti',
                'jurusan'       => null,
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-02-02',
                'tgl_selesai'   => '2026-05-04',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #8: Meli Nabila Sasia
        {
            $userP = User::create([
                'name'     => 'Meli Nabila Sasia',
                'email'    => 'meli_nabila_sasia_8@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['SAPRAS'] ?? null;
            $instansiPeserta = $instansis['SMKN BAKTI IBU 3'] ?? null;
            $pengajuanPeserta = $pengajuans['SMKN BAKTI IBU 3'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Meli Nabila Sasia',
                'jurusan'       => null,
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-02-02',
                'tgl_selesai'   => '2026-05-04',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #9: Nadia Adinda Riyanti
        {
            $userP = User::create([
                'name'     => 'Nadia Adinda Riyanti',
                'email'    => 'nadia_adinda_riyanti_9@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Kurikulum dan Peserta Didik'] ?? null;
            $instansiPeserta = $instansis['SMKN BAKTI IBU 3'] ?? null;
            $pengajuanPeserta = $pengajuans['SMKN BAKTI IBU 3'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Nadia Adinda Riyanti',
                'jurusan'       => null,
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-02-02',
                'tgl_selesai'   => '2026-05-04',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #10: Silvi Ramalia
        {
            $userP = User::create([
                'name'     => 'Silvi Ramalia',
                'email'    => 'silvi_ramalia_10@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Kurikulum dan Peserta Didik'] ?? null;
            $instansiPeserta = $instansis['SMKN BAKTI IBU 3'] ?? null;
            $pengajuanPeserta = $pengajuans['SMKN BAKTI IBU 3'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Silvi Ramalia',
                'jurusan'       => null,
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-02-02',
                'tgl_selesai'   => '2026-05-04',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #11: Ahmad Nurdin
        {
            $userP = User::create([
                'name'     => 'Ahmad Nurdin',
                'email'    => 'ahmad_nurdin_11@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Perencanaan Evaluasi dan Pelaporan'] ?? null;
            $instansiPeserta = $instansis['POLSRI'] ?? null;
            $pengajuanPeserta = $pengajuans['POLSRI'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Ahmad Nurdin',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-02-09',
                'tgl_selesai'   => '2026-06-12',
                'status'        => 'selesai',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #12: M. Arif Kurniawan
        {
            $userP = User::create([
                'name'     => 'M. Arif Kurniawan',
                'email'    => 'm_arif_kurniawan_12@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Keuangan'] ?? null;
            $instansiPeserta = $instansis['POLSRI'] ?? null;
            $pengajuanPeserta = $pengajuans['POLSRI'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'M. Arif Kurniawan',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-02-09',
                'tgl_selesai'   => '2026-06-12',
                'status'        => 'selesai',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #13: Muhammad Hazel S.
        {
            $userP = User::create([
                'name'     => 'Muhammad Hazel S.',
                'email'    => 'muhammad_hazel_s_13@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi PTK SMA'] ?? null;
            $instansiPeserta = $instansis['POLSRI'] ?? null;
            $pengajuanPeserta = $pengajuans['POLSRI'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Muhammad Hazel S.',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-02-09',
                'tgl_selesai'   => '2026-06-12',
                'status'        => 'selesai',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #14: M. Ibnu Athailah F.
        {
            $userP = User::create([
                'name'     => 'M. Ibnu Athailah F.',
                'email'    => 'm_ibnu_athailah_f_14@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Perencanaan Evaluasi dan Pelaporan'] ?? null;
            $instansiPeserta = $instansis['POLSRI'] ?? null;
            $pengajuanPeserta = $pengajuans['POLSRI'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'M. Ibnu Athailah F.',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-02-09',
                'tgl_selesai'   => '2026-06-12',
                'status'        => 'selesai',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #15: Muhammad Ilham
        {
            $userP = User::create([
                'name'     => 'Muhammad Ilham',
                'email'    => 'muhammad_ilham_15@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Kurikulum SMA'] ?? null;
            $instansiPeserta = $instansis['POLSRI'] ?? null;
            $pengajuanPeserta = $pengajuans['POLSRI'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Muhammad Ilham',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-02-09',
                'tgl_selesai'   => '2026-06-12',
                'status'        => 'selesai',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #16: M.  Rafli Nazwan
        {
            $userP = User::create([
                'name'     => 'M.  Rafli Nazwan',
                'email'    => 'm_rafli_nazwan_16@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi PTK SMA'] ?? null;
            $instansiPeserta = $instansis['POLSRI'] ?? null;
            $pengajuanPeserta = $pengajuans['POLSRI'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'M.  Rafli Nazwan',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-02-09',
                'tgl_selesai'   => '2026-06-12',
                'status'        => 'selesai',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #17: R.M. Hidayatullah
        {
            $userP = User::create([
                'name'     => 'R.M. Hidayatullah',
                'email'    => 'rm_hidayatullah_17@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Kurikulum SMA'] ?? null;
            $instansiPeserta = $instansis['POLSRI'] ?? null;
            $pengajuanPeserta = $pengajuans['POLSRI'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'R.M. Hidayatullah',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-02-09',
                'tgl_selesai'   => '2026-06-12',
                'status'        => 'selesai',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #18: Restu Bernandy
        {
            $userP = User::create([
                'name'     => 'Restu Bernandy',
                'email'    => 'restu_bernandy_18@magang.id',
                'password' => Hash::make('password123'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Keuangan'] ?? null;
            $instansiPeserta = $instansis['POLSRI'] ?? null;
            $pengajuanPeserta = $pengajuans['POLSRI'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => null,
                'nama'          => 'Restu Bernandy',
                'jurusan'       => null,
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-02-09',
                'tgl_selesai'   => '2026-06-12',
                'status'        => 'selesai',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #19: Wulan Priyatma Putri
        {
            $userP = User::create([
                'name'     => 'Wulan Priyatma Putri',
                'email'    => 'wulan_priyatma_putri_19@magang.id',
                'password' => Hash::make('42742'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Kurikulum SMA'] ?? null;
            $instansiPeserta = $instansis['SMK Negeri 2 Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Negeri 2 Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '42742',
                'nama'          => 'Wulan Priyatma Putri',
                'jurusan'       => 'TKJ',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-20',
                'tgl_selesai'   => '2026-12-06',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #20: Tiara Merva Mafira
        {
            $userP = User::create([
                'name'     => 'Tiara Merva Mafira',
                'email'    => 'tiara_merva_mafira_20@magang.id',
                'password' => Hash::make('42738'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Peserta Didik SMA'] ?? null;
            $instansiPeserta = $instansis['SMK Negeri 2 Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Negeri 2 Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '42738',
                'nama'          => 'Tiara Merva Mafira',
                'jurusan'       => 'TKJ',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-20',
                'tgl_selesai'   => '2026-12-06',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #21: M. Ezra Hilmidin Kafa
        {
            $userP = User::create([
                'name'     => 'M. Ezra Hilmidin Kafa',
                'email'    => 'm_ezra_hilmidin_kafa_21@magang.id',
                'password' => Hash::make('23051450187'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Umum dan Kepegawaian'] ?? null;
            $instansiPeserta = $instansis['UIN Raden Fatah Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['UIN Raden Fatah Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '23051450187',
                'nama'          => 'M. Ezra Hilmidin Kafa',
                'jurusan'       => 'Program Studi Sistem Informasi',
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-04-14',
                'tgl_selesai'   => '2026-07-14',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #22: Rahmat Yusuf
        {
            $userP = User::create([
                'name'     => 'Rahmat Yusuf',
                'email'    => 'rahmat_yusuf_22@magang.id',
                'password' => Hash::make('231420109'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Perencanaan Evaluasi dan Pelaporan'] ?? null;
            $instansiPeserta = $instansis['Universitas Bina Darma Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['Universitas Bina Darma Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '231420109',
                'nama'          => 'Rahmat Yusuf',
                'jurusan'       => 'Program Studi Teknik Informatika',
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-04-14',
                'tgl_selesai'   => '2026-07-14',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #23: Ferdy Pratama
        {
            $userP = User::create([
                'name'     => 'Ferdy Pratama',
                'email'    => 'ferdy_pratama_23@magang.id',
                'password' => Hash::make('231420077'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Perencanaan Evaluasi dan Pelaporan'] ?? null;
            $instansiPeserta = $instansis['Universitas Bina Darma Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['Universitas Bina Darma Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '231420077',
                'nama'          => 'Ferdy Pratama',
                'jurusan'       => 'Program Studi Teknik Informatika',
                'jenis_peserta' => 'Mahasiswa',
                'tgl_mulai'     => '2026-04-14',
                'tgl_selesai'   => '2026-07-14',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #24: Putri Anggraini
        {
            $userP = User::create([
                'name'     => 'Putri Anggraini',
                'email'    => 'putri_anggraini_24@magang.id',
                'password' => Hash::make('0096319461'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Umum dan Kepegawaian'] ?? null;
            $instansiPeserta = $instansis['SMK Bistek Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Bistek Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '0096319461',
                'nama'          => 'Putri Anggraini',
                'jurusan'       => 'Otomatisasi Tata Kelola Perkantoran',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-01',
                'tgl_selesai'   => '2026-09-30',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #25: Nadila Brilian
        {
            $userP = User::create([
                'name'     => 'Nadila Brilian',
                'email'    => 'nadila_brilian_25@magang.id',
                'password' => Hash::make('0083073689'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Umum dan Kepegawaian'] ?? null;
            $instansiPeserta = $instansis['SMK Bistek Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Bistek Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '0083073689',
                'nama'          => 'Nadila Brilian',
                'jurusan'       => 'Otomatisasi Tata Kelola Perkantoran',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-01',
                'tgl_selesai'   => '2026-09-30',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #26: Muhammad Ilham
        {
            $userP = User::create([
                'name'     => 'Muhammad Ilham',
                'email'    => 'muhammad_ilham_26@magang.id',
                'password' => Hash::make('13.089'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Umum dan Kepegawaian'] ?? null;
            $instansiPeserta = $instansis['SMK Bina Jaya Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Bina Jaya Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '13.089',
                'nama'          => 'Muhammad Ilham',
                'jurusan'       => 'Manajemen Perkantoran',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-16',
                'tgl_selesai'   => '2027-01-15',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #27: Annisa Nur Safira
        {
            $userP = User::create([
                'name'     => 'Annisa Nur Safira',
                'email'    => 'annisa_nur_safira_27@magang.id',
                'password' => Hash::make('14.116'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Subbagian Umum dan Kepegawaian'] ?? null;
            $instansiPeserta = $instansis['SMK Bina Jaya Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Bina Jaya Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '14.116',
                'nama'          => 'Annisa Nur Safira',
                'jurusan'       => 'Manajemen Perkantoran',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-16',
                'tgl_selesai'   => '2027-01-15',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #28: Nadia Alaika
        {
            $userP = User::create([
                'name'     => 'Nadia Alaika',
                'email'    => 'nadia_alaika_28@magang.id',
                'password' => Hash::make('14.094'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi PTK SMK'] ?? null;
            $instansiPeserta = $instansis['SMK Bina Jaya Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Bina Jaya Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '14.094',
                'nama'          => 'Nadia Alaika',
                'jurusan'       => 'Manajemen Perkantoran',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-16',
                'tgl_selesai'   => '2027-01-15',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #29: Rizkah Aulia Khoirunnisa
        {
            $userP = User::create([
                'name'     => 'Rizkah Aulia Khoirunnisa',
                'email'    => 'rizkah_aulia_khoirunnisa_29@magang.id',
                'password' => Hash::make('14.151'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi PTK SMA'] ?? null;
            $instansiPeserta = $instansis['SMK Bina Jaya Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Bina Jaya Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '14.151',
                'nama'          => 'Rizkah Aulia Khoirunnisa',
                'jurusan'       => 'Manajemen Perkantoran',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-16',
                'tgl_selesai'   => '2027-01-15',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #30: Yuhanis Apriani
        {
            $userP = User::create([
                'name'     => 'Yuhanis Apriani',
                'email'    => 'yuhanis_apriani_30@magang.id',
                'password' => Hash::make('08217'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Kurikulum SMA'] ?? null;
            $instansiPeserta = $instansis['SMK Pembina 1 Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Pembina 1 Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '08217',
                'nama'          => 'Yuhanis Apriani',
                'jurusan'       => 'Manajemen Perkantoran dan Layanan Bisnis',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-06',
                'tgl_selesai'   => '2026-11-28',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #31: Khorra Fadia Salsabila
        {
            $userP = User::create([
                'name'     => 'Khorra Fadia Salsabila',
                'email'    => 'khorra_fadia_salsabila_31@magang.id',
                'password' => Hash::make('08199'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Peserta Didik SMA'] ?? null;
            $instansiPeserta = $instansis['SMK Pembina 1 Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Pembina 1 Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '08199',
                'nama'          => 'Khorra Fadia Salsabila',
                'jurusan'       => 'Manajemen Perkantoran dan Layanan Bisnis',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-06',
                'tgl_selesai'   => '2026-11-28',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #32: Novita Salsa Billa
        {
            $userP = User::create([
                'name'     => 'Novita Salsa Billa',
                'email'    => 'novita_salsa_billa_32@magang.id',
                'password' => Hash::make('08187'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Kurikulum SMK'] ?? null;
            $instansiPeserta = $instansis['SMK Pembina 1 Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Pembina 1 Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '08187',
                'nama'          => 'Novita Salsa Billa',
                'jurusan'       => 'Manajemen Perkantoran dan Layanan Bisnis',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-06',
                'tgl_selesai'   => '2026-11-28',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #33: Esli Abelia
        {
            $userP = User::create([
                'name'     => 'Esli Abelia',
                'email'    => 'esli_abelia_33@magang.id',
                'password' => Hash::make('09208'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Peserta Didik SMK'] ?? null;
            $instansiPeserta = $instansis['SMK Pembina 1 Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Pembina 1 Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '09208',
                'nama'          => 'Esli Abelia',
                'jurusan'       => 'Manajemen Perkantoran dan Layanan Bisnis',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-06',
                'tgl_selesai'   => '2026-11-28',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }
        // Peserta #34: Ahmad Denny Al-Farizi
        {
            $userP = User::create([
                'name'     => 'Ahmad Denny Al-Farizi',
                'email'    => 'ahmad_denny_alfarizi_34@magang.id',
                'password' => Hash::make('08467'),
                'role'     => User::ROLE_PESERTA,
            ]);
            $bidangPeserta = $bidangs['Seksi Sarana Prasarana PKLK'] ?? null;
            $instansiPeserta = $instansis['SMK Pembina 1 Palembang'] ?? null;
            $pengajuanPeserta = $pengajuans['SMK Pembina 1 Palembang'] ?? null;
            $pembimbingPeserta = $bidangPeserta ? ($defaultPembimbing[$bidangPeserta->nama] ?? null) : null;
            $peserta = Peserta::create([
                'user_id'       => $userP->id,
                'pengajuan_id'  => $pengajuanPeserta?->id,
                'instansi_id'   => $instansiPeserta?->id,
                'bidang_id'     => $bidangPeserta?->id,
                'pembimbing_id' => $pembimbingPeserta?->id,
                'nim_nisn'      => '08467',
                'nama'          => 'Ahmad Denny Al-Farizi',
                'jurusan'       => 'Manajemen Perkantoran dan Layanan Bisnis',
                'jenis_peserta' => 'Peserta Didik',
                'tgl_mulai'     => '2026-07-06',
                'tgl_selesai'   => '2026-11-28',
                'status'        => 'aktif',
            ]);
            $pesertaObjs[] = $peserta;
        }

        // =========================================
        // PENILAIAN (dari Excel, sheet SERTIFIKAT - match by nama)
        // =========================================
        $penilaianData = [
            [
                'nama' => 'BIMA IRAWAN',
                'no_sertifikat' => '5152',
                'kedisiplinan'  => 88,
                'kerapian'      => 86,
                'kebersihan'    => 86,
                'tanggung_jawab'=> 86,
                'kerjasama'     => 87,
                'kreativitas'   => 87,
                'kejujuran'     => 86,
                'nilai_angka'   => 86.57,
            ],
            [
                'nama' => 'ANNISA',
                'no_sertifikat' => '5152',
                'kedisiplinan'  => 88,
                'kerapian'      => 86,
                'kebersihan'    => 86,
                'tanggung_jawab'=> 86,
                'kerjasama'     => 87,
                'kreativitas'   => 87,
                'kejujuran'     => 86,
                'nilai_angka'   => 86.57,
            ],
            [
                'nama' => 'SEPTI RISQI',
                'no_sertifikat' => '5152',
                'kedisiplinan'  => 88,
                'kerapian'      => 86,
                'kebersihan'    => 86,
                'tanggung_jawab'=> 87,
                'kerjasama'     => 88,
                'kreativitas'   => 88,
                'kejujuran'     => 87,
                'nilai_angka'   => 87.14,
            ],
            [
                'nama' => 'ENJELINA AGUSTI',
                'no_sertifikat' => '5152',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.00,
            ],
            [
                'nama' => 'INDRI SAPUTRI',
                'no_sertifikat' => '5152',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.00,
            ],
            [
                'nama' => 'NOPI',
                'no_sertifikat' => '5152',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.00,
            ],
            [
                'nama' => 'EXCEL RAMADHAN',
                'no_sertifikat' => '7185',
                'kedisiplinan'  => 98,
                'kerapian'      => 100,
                'kebersihan'    => 100,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 100,
                'kreativitas'   => 95,
                'kejujuran'     => 100,
                'nilai_angka'   => 98.71,
            ],
            [
                'nama' => 'ANGGUN GUSTIANI',
                'no_sertifikat' => '7188',
                'kedisiplinan'  => 92,
                'kerapian'      => 90,
                'kebersihan'    => 89,
                'tanggung_jawab'=> 91,
                'kerjasama'     => 93,
                'kreativitas'   => 88,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.43,
            ],
            [
                'nama' => 'ANGGI MARDANI',
                'no_sertifikat' => '7189',
                'kedisiplinan'  => 91,
                'kerapian'      => 90,
                'kebersihan'    => 89,
                'tanggung_jawab'=> 91,
                'kerjasama'     => 93,
                'kreativitas'   => 88,
                'kejujuran'     => 91,
                'nilai_angka'   => 90.43,
            ],
            [
                'nama' => 'HERAU WATI',
                'no_sertifikat' => '7190',
                'kedisiplinan'  => 90,
                'kerapian'      => 98,
                'kebersihan'    => 96,
                'tanggung_jawab'=> 89,
                'kerjasama'     => 85,
                'kreativitas'   => 85,
                'kejujuran'     => 89,
                'nilai_angka'   => 90.29,
            ],
            [
                'nama' => 'PRINCE NAZAL PRATAMA',
                'no_sertifikat' => '7191',
                'kedisiplinan'  => 87,
                'kerapian'      => 88,
                'kebersihan'    => 76,
                'tanggung_jawab'=> 85,
                'kerjasama'     => 87,
                'kreativitas'   => 88,
                'kejujuran'     => 89,
                'nilai_angka'   => 85.71,
            ],
            [
                'nama' => 'MARCHELLINDA UTAMI',
                'no_sertifikat' => '7348',
                'kedisiplinan'  => 98,
                'kerapian'      => 97,
                'kebersihan'    => 98,
                'tanggung_jawab'=> 92,
                'kerjasama'     => 95,
                'kreativitas'   => 95,
                'kejujuran'     => 92,
                'nilai_angka'   => 95.29,
            ],
            [
                'nama' => 'NATASYA SYAWALNA',
                'no_sertifikat' => '7485',
                'kedisiplinan'  => 95,
                'kerapian'      => 93,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 94,
                'kerjasama'     => 95,
                'kreativitas'   => 95,
                'kejujuran'     => 95,
                'nilai_angka'   => 94.57,
            ],
            [
                'nama' => 'WULAN RAMADHANI',
                'no_sertifikat' => '7486',
                'kedisiplinan'  => 92,
                'kerapian'      => 93,
                'kebersihan'    => 92,
                'tanggung_jawab'=> 93,
                'kerjasama'     => 95,
                'kreativitas'   => 92,
                'kejujuran'     => 93,
                'nilai_angka'   => 92.86,
            ],
            [
                'nama' => 'MERCI APRILIA',
                'no_sertifikat' => '7487',
                'kedisiplinan'  => 95,
                'kerapian'      => 97,
                'kebersihan'    => 97,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 91,
                'kreativitas'   => 95,
                'kejujuran'     => 98,
                'nilai_angka'   => 94.71,
            ],
            [
                'nama' => 'RANA CANTIKA TAMRIN',
                'no_sertifikat' => '7521',
                'kedisiplinan'  => 95,
                'kerapian'      => 93,
                'kebersihan'    => 91,
                'tanggung_jawab'=> 92,
                'kerjasama'     => 95,
                'kreativitas'   => 92,
                'kejujuran'     => 92,
                'nilai_angka'   => 92.86,
            ],
            [
                'nama' => 'INTAN BAIDURI',
                'no_sertifikat' => '8962',
                'kedisiplinan'  => 87,
                'kerapian'      => 87,
                'kebersihan'    => 88,
                'tanggung_jawab'=> 87,
                'kerjasama'     => 87,
                'kreativitas'   => 88,
                'kejujuran'     => 90,
                'nilai_angka'   => 87.71,
            ],
            [
                'nama' => 'MUHAMMAD RIZKI SAPUTRA',
                'no_sertifikat' => '8961',
                'kedisiplinan'  => 86,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 85,
                'kreativitas'   => 83,
                'kejujuran'     => 90,
                'nilai_angka'   => 87.71,
            ],
            [
                'nama' => 'HAJITA',
                'no_sertifikat' => '13324',
                'kedisiplinan'  => 90,
                'kerapian'      => 86,
                'kebersihan'    => 86,
                'tanggung_jawab'=> 88,
                'kerjasama'     => 87,
                'kreativitas'   => 86,
                'kejujuran'     => 90,
                'nilai_angka'   => 87.57,
            ],
            [
                'nama' => 'DEVI DONA TRIANI',
                'no_sertifikat' => '13325',
                'kedisiplinan'  => 90,
                'kerapian'      => 87,
                'kebersihan'    => 88,
                'tanggung_jawab'=> 86,
                'kerjasama'     => 87,
                'kreativitas'   => 86,
                'kejujuran'     => 90,
                'nilai_angka'   => 87.71,
            ],
            [
                'nama' => 'M. ADITIA SAPUTRA',
                'no_sertifikat' => '13326',
                'kedisiplinan'  => 94,
                'kerapian'      => 90,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 94,
                'kerjasama'     => 95,
                'kreativitas'   => 90,
                'kejujuran'     => 96,
                'nilai_angka'   => 93.43,
            ],
            [
                'nama' => 'DIMAS ARANGGA',
                'no_sertifikat' => '13327',
                'kedisiplinan'  => 95,
                'kerapian'      => 90,
                'kebersihan'    => 94,
                'tanggung_jawab'=> 94,
                'kerjasama'     => 95,
                'kreativitas'   => 90,
                'kejujuran'     => 96,
                'nilai_angka'   => 93.43,
            ],
            [
                'nama' => 'AHMAD CHANDRA AIKAMIN',
                'no_sertifikat' => '13328',
                'kedisiplinan'  => 98,
                'kerapian'      => 98,
                'kebersihan'    => 98,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 98,
                'kreativitas'   => 98,
                'kejujuran'     => 98,
                'nilai_angka'   => 98.00,
            ],
            [
                'nama' => 'NESYA ADELIA',
                'no_sertifikat' => '14513',
                'kedisiplinan'  => 98,
                'kerapian'      => 98,
                'kebersihan'    => 98,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 98,
                'kreativitas'   => 98,
                'kejujuran'     => 98,
                'nilai_angka'   => 98.00,
            ],
            [
                'nama' => 'RAHMA INDAH SARI',
                'no_sertifikat' => '14514',
                'kedisiplinan'  => 90,
                'kerapian'      => 95,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 95,
                'kreativitas'   => 95,
                'kejujuran'     => 95,
                'nilai_angka'   => 94.29,
            ],
            [
                'nama' => 'NABILA TRI AZZAHRO',
                'no_sertifikat' => '14515',
                'kedisiplinan'  => 97,
                'kerapian'      => 98,
                'kebersihan'    => 96,
                'tanggung_jawab'=> 97,
                'kerjasama'     => 96,
                'kreativitas'   => 97,
                'kejujuran'     => 99,
                'nilai_angka'   => 97.14,
            ],
            [
                'nama' => 'PRITY ZINTA',
                'no_sertifikat' => '14516',
                'kedisiplinan'  => 97,
                'kerapian'      => 98,
                'kebersihan'    => 96,
                'tanggung_jawab'=> 97,
                'kerjasama'     => 96,
                'kreativitas'   => 97,
                'kejujuran'     => 99,
                'nilai_angka'   => 97.14,
            ],
            [
                'nama' => 'HENIY KARLINAH',
                'no_sertifikat' => '14517',
                'kedisiplinan'  => 97,
                'kerapian'      => 97,
                'kebersihan'    => 97,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 97,
                'kreativitas'   => 98,
                'kejujuran'     => 97,
                'nilai_angka'   => 97.29,
            ],
            [
                'nama' => 'AHMAD FADILAH',
                'no_sertifikat' => '14518',
                'kedisiplinan'  => 98,
                'kerapian'      => 90,
                'kebersihan'    => 88,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 98,
                'kreativitas'   => 95,
                'kejujuran'     => 98,
                'nilai_angka'   => 95.00,
            ],
            [
                'nama' => 'AHMAD FAHREZY',
                'no_sertifikat' => '14519',
                'kedisiplinan'  => 80,
                'kerapian'      => 87,
                'kebersihan'    => 85,
                'tanggung_jawab'=> 88,
                'kerjasama'     => 88,
                'kreativitas'   => 85,
                'kejujuran'     => 88,
                'nilai_angka'   => 85.86,
            ],
            [
                'nama' => 'AULYA RAFNAS FAUZIAH PUTRI',
                'no_sertifikat' => '14520',
                'kedisiplinan'  => 80,
                'kerapian'      => 87,
                'kebersihan'    => 88,
                'tanggung_jawab'=> 88,
                'kerjasama'     => 88,
                'kreativitas'   => 87,
                'kejujuran'     => 88,
                'nilai_angka'   => 86.57,
            ],
            [
                'nama' => 'NENG AISYAH',
                'no_sertifikat' => '14521',
                'kedisiplinan'  => 90,
                'kerapian'      => 95,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 90,
                'kreativitas'   => 85,
                'kejujuran'     => 90,
                'nilai_angka'   => 91.43,
            ],
            [
                'nama' => 'ALIYA SALSABILA',
                'no_sertifikat' => '14522',
                'kedisiplinan'  => 90,
                'kerapian'      => 95,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 90,
                'kreativitas'   => 85,
                'kejujuran'     => 90,
                'nilai_angka'   => 91.43,
            ],
            [
                'nama' => 'DEVI MUSTIKA SARI',
                'no_sertifikat' => '14523',
                'kedisiplinan'  => 90,
                'kerapian'      => 95,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 90,
                'kreativitas'   => 85,
                'kejujuran'     => 90,
                'nilai_angka'   => 91.43,
            ],
            [
                'nama' => 'PUTRI MUHAIROH',
                'no_sertifikat' => '14524',
                'kedisiplinan'  => 88,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 89.71,
            ],
            [
                'nama' => 'EKA NURCAHYANI',
                'no_sertifikat' => '14525',
                'kedisiplinan'  => 88,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 89.71,
            ],
            [
                'nama' => 'INTAN NURANI',
                'no_sertifikat' => '14526',
                'kedisiplinan'  => 88,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 89.71,
            ],
            [
                'nama' => 'POOJA MAYNISA',
                'no_sertifikat' => '14532',
                'kedisiplinan'  => 95,
                'kerapian'      => 94,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 93,
                'kerjasama'     => 90,
                'kreativitas'   => 85,
                'kejujuran'     => 90,
                'nilai_angka'   => 91.71,
            ],
            [
                'nama' => 'SERLY NURAINI',
                'no_sertifikat' => '14533',
                'kedisiplinan'  => 95,
                'kerapian'      => 95,
                'kebersihan'    => 94,
                'tanggung_jawab'=> 91,
                'kerjasama'     => 93,
                'kreativitas'   => 85,
                'kejujuran'     => 90,
                'nilai_angka'   => 91.86,
            ],
            [
                'nama' => 'MEGA MUSTIKA SARI',
                'no_sertifikat' => '16131',
                'kedisiplinan'  => 90,
                'kerapian'      => 88,
                'kebersihan'    => 89,
                'tanggung_jawab'=> 92,
                'kerjasama'     => 93,
                'kreativitas'   => 94,
                'kejujuran'     => 95,
                'nilai_angka'   => 91.57,
            ],
            [
                'nama' => 'NURBAITI',
                'no_sertifikat' => '16148',
                'kedisiplinan'  => 97.5,
                'kerapian'      => 96.5,
                'kebersihan'    => 96,
                'tanggung_jawab'=> 97,
                'kerjasama'     => 96,
                'kreativitas'   => 96,
                'kejujuran'     => 97,
                'nilai_angka'   => 96.57,
            ],
            [
                'nama' => 'DEVRA PRATAMA',
                'no_sertifikat' => '16164',
                'kedisiplinan'  => 92,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.29,
            ],
            [
                'nama' => 'RAMA TAMA',
                'no_sertifikat' => '16165',
                'kedisiplinan'  => 92,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.29,
            ],
            [
                'nama' => 'SUBI RISKI',
                'no_sertifikat' => '16166',
                'kedisiplinan'  => 92,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.29,
            ],
            [
                'nama' => 'M. ALIEF ELVANI',
                'no_sertifikat' => '17073',
                'kedisiplinan'  => 88,
                'kerapian'      => 90,
                'kebersihan'    => 89,
                'tanggung_jawab'=> 91,
                'kerjasama'     => 89,
                'kreativitas'   => 88,
                'kejujuran'     => 87,
                'nilai_angka'   => 88.86,
            ],
            [
                'nama' => 'M. UWAIS AL-QARANI',
                'no_sertifikat' => '17074',
                'kedisiplinan'  => 87,
                'kerapian'      => 89,
                'kebersihan'    => 91,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 89,
                'kreativitas'   => 88,
                'kejujuran'     => 88,
                'nilai_angka'   => 88.86,
            ],
            [
                'nama' => 'DELA MONICA',
                'no_sertifikat' => '17075',
                'kedisiplinan'  => 95,
                'kerapian'      => 95,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 98,
                'kreativitas'   => 98,
                'kejujuran'     => 98,
                'nilai_angka'   => 96.71,
            ],
            [
                'nama' => 'RANGGA SAPUTRA',
                'no_sertifikat' => '17076',
                'kedisiplinan'  => 98,
                'kerapian'      => 98,
                'kebersihan'    => 98,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 98,
                'kreativitas'   => 98,
                'kejujuran'     => 98,
                'nilai_angka'   => 98.00,
            ],
            [
                'nama' => 'MSY. PUTRI NABILA',
                'no_sertifikat' => '17077',
                'kedisiplinan'  => 98,
                'kerapian'      => 97,
                'kebersihan'    => 98,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 98,
                'kreativitas'   => 97,
                'kejujuran'     => 98,
                'nilai_angka'   => 97.71,
            ],
            [
                'nama' => 'MUHAMMAD FAJRY',
                'no_sertifikat' => '17961',
                'kedisiplinan'  => 89,
                'kerapian'      => 88,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 84,
                'kejujuran'     => 90,
                'nilai_angka'   => 88.71,
            ],
            [
                'nama' => 'M. HUD SOLEH',
                'no_sertifikat' => '18067',
                'kedisiplinan'  => 84,
                'kerapian'      => 83,
                'kebersihan'    => 84,
                'tanggung_jawab'=> 85,
                'kerjasama'     => 85,
                'kreativitas'   => 84,
                'kejujuran'     => 85,
                'nilai_angka'   => 84.29,
            ],
            [
                'nama' => 'M. RIZKY FATRIA IF GIZA',
                'no_sertifikat' => '18068',
                'kedisiplinan'  => 86,
                'kerapian'      => 87,
                'kebersihan'    => 87,
                'tanggung_jawab'=> 87,
                'kerjasama'     => 86,
                'kreativitas'   => 86,
                'kejujuran'     => 88,
                'nilai_angka'   => 86.71,
            ],
            [
                'nama' => 'RESAH OKTARINA',
                'no_sertifikat' => '18173',
                'kedisiplinan'  => 97,
                'kerapian'      => 85,
                'kebersihan'    => 93,
                'tanggung_jawab'=> 85,
                'kerjasama'     => 89,
                'kreativitas'   => 95,
                'kejujuran'     => 89,
                'nilai_angka'   => 90.43,
            ],
            [
                'nama' => 'ZIRA YASCER',
                'no_sertifikat' => '18174',
                'kedisiplinan'  => 97,
                'kerapian'      => 94,
                'kebersihan'    => 94,
                'tanggung_jawab'=> 96,
                'kerjasama'     => 95,
                'kreativitas'   => 94,
                'kejujuran'     => 95,
                'nilai_angka'   => 95.00,
            ],
            [
                'nama' => 'HENNY AMELIA',
                'no_sertifikat' => '18175',
                'kedisiplinan'  => 90,
                'kerapian'      => 87,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 88,
                'kreativitas'   => 87,
                'kejujuran'     => 92,
                'nilai_angka'   => 89.14,
            ],
            [
                'nama' => 'TARISA AMALIA CATUR PANGESTUS',
                'no_sertifikat' => '18176',
                'kedisiplinan'  => 92,
                'kerapian'      => 87,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 91,
                'kerjasama'     => 91,
                'kreativitas'   => 88,
                'kejujuran'     => 90,
                'nilai_angka'   => 89.86,
            ],
            [
                'nama' => 'BAYU DWI PRASETYO',
                'no_sertifikat' => '155',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.00,
            ],
            [
                'nama' => 'SELLY OKTALIZA',
                'no_sertifikat' => '145',
                'kedisiplinan'  => 80,
                'kerapian'      => 83,
                'kebersihan'    => 83,
                'tanggung_jawab'=> 80,
                'kerjasama'     => 82,
                'kreativitas'   => 81,
                'kejujuran'     => 85,
                'nilai_angka'   => 82.00,
            ],
            [
                'nama' => 'DESSY CAHYA UTAMY',
                'no_sertifikat' => '146',
                'kedisiplinan'  => 80,
                'kerapian'      => 83,
                'kebersihan'    => 83,
                'tanggung_jawab'=> 80,
                'kerjasama'     => 82,
                'kreativitas'   => 81,
                'kejujuran'     => 85,
                'nilai_angka'   => 82.00,
            ],
            [
                'nama' => 'JOSSY DESANJAYA',
                'no_sertifikat' => '147',
                'kedisiplinan'  => 99,
                'kerapian'      => 90,
                'kebersihan'    => 99,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 99,
                'kreativitas'   => 99,
                'kejujuran'     => 99,
                'nilai_angka'   => 97.57,
            ],
            [
                'nama' => 'BEBBY AGUSTIN',
                'no_sertifikat' => '148',
                'kedisiplinan'  => 99,
                'kerapian'      => 98,
                'kebersihan'    => 97,
                'tanggung_jawab'=> 99,
                'kerjasama'     => 99,
                'kreativitas'   => 98,
                'kejujuran'     => 97,
                'nilai_angka'   => 98.14,
            ],
            [
                'nama' => 'DIAN MEINI PUJA RAHAYU',
                'no_sertifikat' => '149',
                'kedisiplinan'  => 98,
                'kerapian'      => 97,
                'kebersihan'    => 99,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 97,
                'kreativitas'   => 99,
                'kejujuran'     => 99,
                'nilai_angka'   => 98.14,
            ],
            [
                'nama' => 'HEVY KURNIA DWI LESTARI',
                'no_sertifikat' => '150',
                'kedisiplinan'  => 99,
                'kerapian'      => 90,
                'kebersihan'    => 99,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 99,
                'kreativitas'   => 96,
                'kejujuran'     => 99,
                'nilai_angka'   => 97.14,
            ],
            [
                'nama' => 'DELLA PUSPITA',
                'no_sertifikat' => '151',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.00,
            ],
            [
                'nama' => 'AZAKRI RAMA HIDAYA',
                'no_sertifikat' => '152',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.00,
            ],
            [
                'nama' => 'HAWA RIYINI',
                'no_sertifikat' => '153',
                'kedisiplinan'  => 96,
                'kerapian'      => 95,
                'kebersihan'    => 97,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 96,
                'kreativitas'   => 94,
                'kejujuran'     => 99,
                'nilai_angka'   => 96.00,
            ],
            [
                'nama' => 'ZULAEHA',
                'no_sertifikat' => '154',
                'kedisiplinan'  => 96,
                'kerapian'      => 95,
                'kebersihan'    => 97,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 96,
                'kreativitas'   => 94,
                'kejujuran'     => 99,
                'nilai_angka'   => 96.00,
            ],
            [
                'nama' => 'A. RIFQI SAHPUTRA',
                'no_sertifikat' => '171',
                'kedisiplinan'  => 86,
                'kerapian'      => 86,
                'kebersihan'    => 87,
                'tanggung_jawab'=> 87,
                'kerjasama'     => 87,
                'kreativitas'   => 86,
                'kejujuran'     => 87,
                'nilai_angka'   => 86.57,
            ],
            [
                'nama' => 'ANANDA THAREGH MAULANA',
                'no_sertifikat' => '172',
                'kedisiplinan'  => 86,
                'kerapian'      => 86,
                'kebersihan'    => 87,
                'tanggung_jawab'=> 87,
                'kerjasama'     => 87,
                'kreativitas'   => 86,
                'kejujuran'     => 87,
                'nilai_angka'   => 86.57,
            ],
            [
                'nama' => 'YEARLLY PUTERI GHANIA',
                'no_sertifikat' => '1501',
                'kedisiplinan'  => 91,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 88,
                'kerjasama'     => 86,
                'kreativitas'   => 86,
                'kejujuran'     => 88,
                'nilai_angka'   => 88.43,
            ],
            [
                'nama' => 'MELISYA FEBIOLA',
                'no_sertifikat' => '1502',
                'kedisiplinan'  => 90,
                'kerapian'      => 88,
                'kebersihan'    => 87,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 87,
                'kreativitas'   => 88,
                'kejujuran'     => 90,
                'nilai_angka'   => 88.57,
            ],
            [
                'nama' => 'M. WAHYU HIDAYATULLAH',
                'no_sertifikat' => '1503',
                'kedisiplinan'  => 92,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 91,
                'kejujuran'     => 93,
                'nilai_angka'   => 90.86,
            ],
            [
                'nama' => 'M. RIZKI',
                'no_sertifikat' => '1504',
                'kedisiplinan'  => 88,
                'kerapian'      => 87,
                'kebersihan'    => 87,
                'tanggung_jawab'=> 87,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 92,
                'nilai_angka'   => 88.71,
            ],
            [
                'nama' => 'SALSHA NUR AISSYAH',
                'no_sertifikat' => '1505',
                'kedisiplinan'  => 90,
                'kerapian'      => 88,
                'kebersihan'    => 88,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 89,
                'kreativitas'   => 89,
                'kejujuran'     => 90,
                'nilai_angka'   => 89.14,
            ],
            [
                'nama' => 'WIRA KARWANA',
                'no_sertifikat' => '1506',
                'kedisiplinan'  => 89,
                'kerapian'      => 88,
                'kebersihan'    => 88,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 89,
                'kejujuran'     => 90,
                'nilai_angka'   => 89.14,
            ],
            [
                'nama' => 'ALYA REFANI',
                'no_sertifikat' => '3256',
                'kedisiplinan'  => 96,
                'kerapian'      => 97,
                'kebersihan'    => 98,
                'tanggung_jawab'=> 99,
                'kerjasama'     => 95,
                'kreativitas'   => 97,
                'kejujuran'     => 99,
                'nilai_angka'   => 97.29,
            ],
            [
                'nama' => 'FAUZIAH IFTITAH',
                'no_sertifikat' => '3257',
                'kedisiplinan'  => 97,
                'kerapian'      => 98,
                'kebersihan'    => 97,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 97,
                'kreativitas'   => 96,
                'kejujuran'     => 99,
                'nilai_angka'   => 97.43,
            ],
            [
                'nama' => 'MARSHANDA AYUDIA JUVEN',
                'no_sertifikat' => '3258',
                'kedisiplinan'  => 98,
                'kerapian'      => 98,
                'kebersihan'    => 99,
                'tanggung_jawab'=> 99,
                'kerjasama'     => 98,
                'kreativitas'   => 99,
                'kejujuran'     => 98,
                'nilai_angka'   => 98.43,
            ],
            [
                'nama' => 'ZELLCHA JULIA PUTRI',
                'no_sertifikat' => '9781',
                'kedisiplinan'  => 79,
                'kerapian'      => 85,
                'kebersihan'    => 83,
                'tanggung_jawab'=> 85,
                'kerjasama'     => 77,
                'kreativitas'   => 78,
                'kejujuran'     => 84,
                'nilai_angka'   => 81.57,
            ],
            [
                'nama' => 'WAHYUDI',
                'no_sertifikat' => '9780',
                'kedisiplinan'  => 75,
                'kerapian'      => 78,
                'kebersihan'    => 78,
                'tanggung_jawab'=> 76,
                'kerjasama'     => 74,
                'kreativitas'   => 76,
                'kejujuran'     => 80,
                'nilai_angka'   => 76.71,
            ],
            [
                'nama' => 'SUCI RAMADANI',
                'no_sertifikat' => '9779',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 89,
                'tanggung_jawab'=> 93,
                'kerjasama'     => 92,
                'kreativitas'   => 92,
                'kejujuran'     => 94,
                'nilai_angka'   => 91.43,
            ],
            [
                'nama' => 'BAYU SATRIANI',
                'no_sertifikat' => '9778',
                'kedisiplinan'  => 92,
                'kerapian'      => 92,
                'kebersihan'    => 93,
                'tanggung_jawab'=> 92,
                'kerjasama'     => 94,
                'kreativitas'   => 92,
                'kejujuran'     => 92,
                'nilai_angka'   => 92.43,
            ],
            [
                'nama' => 'REVI SHAMARA PUTRI',
                'no_sertifikat' => '9987',
                'kedisiplinan'  => 88,
                'kerapian'      => 95,
                'kebersihan'    => 95,
                'tanggung_jawab'=> 88,
                'kerjasama'     => 86,
                'kreativitas'   => 89,
                'kejujuran'     => 95,
                'nilai_angka'   => 90.86,
            ],
            [
                'nama' => 'NOLA JANTIKA',
                'no_sertifikat' => '9777',
                'kedisiplinan'  => 93,
                'kerapian'      => 93,
                'kebersihan'    => 94,
                'tanggung_jawab'=> 93,
                'kerjasama'     => 95,
                'kreativitas'   => 93,
                'kejujuran'     => 93,
                'nilai_angka'   => 93.43,
            ],
            [
                'nama' => 'SRI AGUSTINA',
                'no_sertifikat' => '13124',
                'kedisiplinan'  => 92,
                'kerapian'      => 92,
                'kebersihan'    => 92,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 95,
                'kreativitas'   => 95,
                'kejujuran'     => 93,
                'nilai_angka'   => 92.71,
            ],
            [
                'nama' => 'JUWITA ESTIANTI',
                'no_sertifikat' => '13125',
                'kedisiplinan'  => 92,
                'kerapian'      => 92,
                'kebersihan'    => 92,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 95,
                'kreativitas'   => 95,
                'kejujuran'     => 93,
                'nilai_angka'   => 92.71,
            ],
            [
                'nama' => 'GRACIA MARGARETHA',
                'no_sertifikat' => '13126',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 90,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.00,
            ],
            [
                'nama' => 'DEA PUSPITA SARI',
                'no_sertifikat' => '13127',
                'kedisiplinan'  => 92,
                'kerapian'      => 92,
                'kebersihan'    => 92,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 95,
                'kreativitas'   => 95,
                'kejujuran'     => 93,
                'nilai_angka'   => 92.71,
            ],
            [
                'nama' => 'M. HAFIZ HAFIDUDDIN',
                'no_sertifikat' => '13128',
                'kedisiplinan'  => 89,
                'kerapian'      => 89,
                'kebersihan'    => 86,
                'tanggung_jawab'=> 88,
                'kerjasama'     => 88,
                'kreativitas'   => 88,
                'kejujuran'     => 88,
                'nilai_angka'   => 88.00,
            ],
            [
                'nama' => 'DECHA AULIA METHA',
                'no_sertifikat' => '13129',
                'kedisiplinan'  => 86,
                'kerapian'      => 88,
                'kebersihan'    => 86,
                'tanggung_jawab'=> 87,
                'kerjasama'     => 88,
                'kreativitas'   => 88,
                'kejujuran'     => 86,
                'nilai_angka'   => 87.00,
            ],
            [
                'nama' => 'ADETYA KURNIAWAN',
                'no_sertifikat' => '13132',
                'kedisiplinan'  => 99,
                'kerapian'      => 98,
                'kebersihan'    => 99,
                'tanggung_jawab'=> 98,
                'kerjasama'     => 98,
                'kreativitas'   => 98,
                'kejujuran'     => 99,
                'nilai_angka'   => 98.43,
            ],
            [
                'nama' => 'M. RISKI',
                'no_sertifikat' => '13133',
                'kedisiplinan'  => 91,
                'kerapian'      => 91,
                'kebersihan'    => 88.3,
                'tanggung_jawab'=> 88.3,
                'kerjasama'     => 85,
                'kreativitas'   => 82.6,
                'kejujuran'     => 88.3,
                'nilai_angka'   => 87.79,
            ],
            [
                'nama' => 'SINDI ARISTA',
                'no_sertifikat' => '13134',
                'kedisiplinan'  => 90,
                'kerapian'      => 92,
                'kebersihan'    => 91,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 90,
                'kreativitas'   => 88,
                'kejujuran'     => 91,
                'nilai_angka'   => 90.29,
            ],
            [
                'nama' => 'LIDIA FITRI',
                'no_sertifikat' => '13135',
                'kedisiplinan'  => 90,
                'kerapian'      => 90,
                'kebersihan'    => 90,
                'tanggung_jawab'=> 91,
                'kerjasama'     => 91,
                'kreativitas'   => 91,
                'kejujuran'     => 91,
                'nilai_angka'   => 90.57,
            ],
            [
                'nama' => 'RINTAN TRINANDA RESTA',
                'no_sertifikat' => '13768',
                'kedisiplinan'  => 90,
                'kerapian'      => 92,
                'kebersihan'    => 89,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 95,
                'kreativitas'   => 88,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.57,
            ],
            [
                'nama' => 'JULIANI PUSPITA DINI',
                'no_sertifikat' => '13769',
                'kedisiplinan'  => 90,
                'kerapian'      => 89,
                'kebersihan'    => 92,
                'tanggung_jawab'=> 90,
                'kerjasama'     => 95,
                'kreativitas'   => 88,
                'kejujuran'     => 90,
                'nilai_angka'   => 90.57,
            ],
            [
                'nama' => 'JENNIFER OLIVIA SITORUS',
                'no_sertifikat' => '13770',
                'kedisiplinan'  => 95,
                'kerapian'      => 92.5,
                'kebersihan'    => 91.3,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 93.8,
                'kreativitas'   => 91.5,
                'kejujuran'     => 95,
                'nilai_angka'   => 93.44,
            ],
            [
                'nama' => 'NUR FITRI ANGRAINI',
                'no_sertifikat' => '13771',
                'kedisiplinan'  => 95,
                'kerapian'      => 93.8,
                'kebersihan'    => 91.3,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 93.8,
                'kreativitas'   => 90,
                'kejujuran'     => 95,
                'nilai_angka'   => 93.41,
            ],
            [
                'nama' => 'INTAN SALSABILLAH',
                'no_sertifikat' => '13772',
                'kedisiplinan'  => 91,
                'kerapian'      => 89,
                'kebersihan'    => 88,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 95,
                'kreativitas'   => 88,
                'kejujuran'     => 95,
                'nilai_angka'   => 91.57,
            ],
            [
                'nama' => 'MUTIARA NATHANIA NURHASANI',
                'no_sertifikat' => '13773',
                'kedisiplinan'  => 92,
                'kerapian'      => 89,
                'kebersihan'    => 88,
                'tanggung_jawab'=> 95,
                'kerjasama'     => 95,
                'kreativitas'   => 89,
                'kejujuran'     => 95,
                'nilai_angka'   => 91.86,
            ],
        ];

        foreach ($pesertaObjs as $pesertaObj) {
            foreach ($penilaianData as $pd) {
                if (strtolower(trim($pd['nama'])) === strtolower(trim($pesertaObj->nama))) {
                    $pembimbingForPenilaian = $pesertaObj->bidang_id 
                        ? ($defaultPembimbing[\App\Models\Bidang::find($pesertaObj->bidang_id)?->nama] ?? null) 
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
