<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Bidang;
use App\Models\Instansi;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use App\Models\Penilaian;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlackboxTestingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    // =========================================================================
    // MODUL 1: GUEST & LANDING PAGE (PORTAL PUBLIK)
    // =========================================================================

    public function test_TC_PUB_01_landing_page_can_be_accessed(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SIMAG-DISDIKPROV SUMSEL');
    }

    public function test_TC_PUB_02_pengajuan_form_can_be_rendered(): void
    {
        $response = $this->get('/pengajuan');
        $response->assertStatus(200);
    }

    public function test_TC_PUB_03_pengajuan_magang_validation_fails_on_empty_inputs(): void
    {
        $response = $this->post('/pengajuan', []);
        $response->assertSessionHasErrors([
            'pic_nama', 'nim_nisn', 'jenis_peserta', 'jurusan',
            'nama_instansi', 'pic_email', 'pic_telp', 'tgl_mulai',
            'tgl_selesai', 'file_surat', 'file_transkrip', 'file_surat_pernyataan'
        ]);
    }

    public function test_TC_PUB_04_pengajuan_magang_validation_fails_on_invalid_email_and_date_order(): void
    {
        $file = UploadedFile::fake()->create('surat.pdf', 500, 'application/pdf');

        $response = $this->post('/pengajuan', [
            'pic_nama'              => 'Budi Santoso',
            'nim_nisn'              => '09021182025001',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Teknik Informatika',
            'nama_instansi'         => 'Universitas Sriwijaya',
            'pic_email'             => 'budi-bukan-email',
            'pic_telp'              => '081234567890',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-08-01', // Before tgl_mulai
            'file_surat'            => $file,
            'file_transkrip'        => $file,
            'file_surat_pernyataan' => $file,
        ]);

        $response->assertSessionHasErrors(['pic_email', 'tgl_selesai']);
    }

    public function test_TC_PUB_05_pengajuan_magang_successful_submission(): void
    {
        $fileSurat = UploadedFile::fake()->create('surat.pdf', 500, 'application/pdf');
        $fileTranskrip = UploadedFile::fake()->create('transkrip.pdf', 500, 'application/pdf');
        $filePernyataan = UploadedFile::fake()->create('pernyataan.pdf', 500, 'application/pdf');

        $response = $this->post('/pengajuan', [
            'pic_nama'              => 'Ahmad Fauzi',
            'nim_nisn'              => '09021182025099',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Sistem Informasi',
            'nama_instansi'         => 'Universitas Bina Darma',
            'pic_email'             => 'ahmad@binadarma.ac.id',
            'pic_telp'              => '081234567891',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => $fileSurat,
            'file_transkrip'        => $fileTranskrip,
            'file_surat_pernyataan' => $filePernyataan,
            'keterangan'            => 'Pengajuan magang mandiri semester ganjil',
        ]);

        $response->assertRedirect(route('pengajuan.form'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pengajuans', [
            'pic_nama'      => 'Ahmad Fauzi',
            'pic_email'     => 'ahmad@binadarma.ac.id',
            'nama_instansi' => 'Universitas Bina Darma',
            'status'        => 'pending',
        ]);
    }

    public function test_TC_PUB_06_cek_status_pengajuan_with_valid_and_invalid_email(): void
    {
        Pengajuan::create([
            'jml_peserta'           => 1,
            'nama_instansi'         => 'Universitas Sriwijaya',
            'pic_nama'              => 'Siti Rahma',
            'nim_nisn'              => '09021182025005',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Manajemen',
            'pic_email'             => 'siti@unsri.ac.id',
            'pic_telp'              => '081234567892',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => 'pengajuan/surat/dummy.pdf',
            'file_transkrip'        => 'pengajuan/transkrip/dummy.pdf',
            'file_surat_pernyataan' => 'pengajuan/surat_pernyataan/dummy.pdf',
            'status'                => 'pending',
        ]);

        // Cek dengan email yang ada
        $response = $this->post('/cek-status', ['email' => 'siti@unsri.ac.id']);
        $response->assertStatus(200);
        $response->assertSee('Siti Rahma');

        // Cek dengan email yang tidak ada
        $responseNotFound = $this->post('/cek-status', ['email' => 'notfound@example.com']);
        $responseNotFound->assertStatus(200);
        $responseNotFound->assertDontSee('Siti Rahma');

        // Cek tanpa email (validasi gagal)
        $responseEmpty = $this->post('/cek-status', ['email' => '']);
        $responseEmpty->assertSessionHasErrors('email');
    }

    public function test_TC_PUB_07_download_surat_balasan_policy(): void
    {
        $pengajuanPending = Pengajuan::create([
            'jml_peserta'           => 1,
            'nama_instansi'         => 'Universitas Lampung',
            'pic_nama'              => 'Riko Putra',
            'nim_nisn'              => '1815061001',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Teknik Informatika',
            'pic_email'             => 'riko@unila.ac.id',
            'pic_telp'              => '081234567893',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => 'pengajuan/surat/dummy.pdf',
            'file_transkrip'        => 'pengajuan/transkrip/dummy.pdf',
            'file_surat_pernyataan' => 'pengajuan/surat_pernyataan/dummy.pdf',
            'status'                => 'pending',
        ]);

        // Pengajuan belum approved -> tidak bisa unduh LoA
        $responsePending = $this->get(route('pengajuan.surat_balasan', $pengajuanPending));
        $responsePending->assertRedirect();
        $responsePending->assertSessionHas('error');

        // Setelah approved -> bisa unduh LoA (PDF generated)
        $pengajuanPending->update(['status' => 'approved']);
        $responseApproved = $this->get(route('pengajuan.surat_balasan', $pengajuanPending));
        $responseApproved->assertStatus(200);
        $responseApproved->assertHeader('content-type', 'application/pdf');
    }

    // =========================================================================
    // MODUL 2: KASUBBAG (ROLE 4)
    // =========================================================================

    public function test_TC_KSB_01_kasubbag_can_view_pengajuan_list_and_detail(): void
    {
        $kasubbag = User::factory()->create(['role' => User::ROLE_KASUBBAG]);
        $pengajuan = Pengajuan::create([
            'jml_peserta'           => 1,
            'nama_instansi'         => 'Universitas Sriwijaya',
            'pic_nama'              => 'Maya Sari',
            'nim_nisn'              => '09021182025010',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Akuntansi',
            'pic_email'             => 'maya@unsri.ac.id',
            'pic_telp'              => '081234567894',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => 'pengajuan/surat/dummy.pdf',
            'file_transkrip'        => 'pengajuan/transkrip/dummy.pdf',
            'file_surat_pernyataan' => 'pengajuan/surat_pernyataan/dummy.pdf',
            'status'                => 'pending',
        ]);

        $responseIndex = $this->actingAs($kasubbag)->get(route('kasubbag.pengajuan.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Maya Sari');

        $responseShow = $this->actingAs($kasubbag)->get(route('kasubbag.pengajuan.show', $pengajuan));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Maya Sari');
    }

    public function test_TC_KSB_02_kasubbag_can_approve_pengajuan_and_auto_sync_peserta(): void
    {
        $kasubbag = User::factory()->create(['role' => User::ROLE_KASUBBAG]);
        $pengajuan = Pengajuan::create([
            'jml_peserta'           => 1,
            'nama_instansi'         => 'Politeknik Negeri Sriwijaya',
            'pic_nama'              => 'Rian Pratama',
            'nim_nisn'              => '062030801234',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Teknik Komputer',
            'pic_email'             => 'rian@polsri.ac.id',
            'pic_telp'              => '081234567895',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => 'pengajuan/surat/dummy.pdf',
            'file_transkrip'        => 'pengajuan/transkrip/dummy.pdf',
            'file_surat_pernyataan' => 'pengajuan/surat_pernyataan/dummy.pdf',
            'status'                => 'pending',
        ]);

        $response = $this->actingAs($kasubbag)->patch(route('kasubbag.pengajuan.approve', $pengajuan), [
            'keterangan' => 'Disetujui untuk penempatan Bagian IT',
        ]);

        $response->assertRedirect(route('kasubbag.pengajuan.show', $pengajuan));
        $response->assertSessionHas('success');

        $pengajuan->refresh();
        $this->assertEquals('approved', $pengajuan->status);

        // Memastikan peserta otomatis terdaftar di database
        $this->assertDatabaseHas('pesertas', [
            'pengajuan_id' => $pengajuan->id,
            'nama'         => 'Rian Pratama',
            'nim_nisn'     => '062030801234',
        ]);

        // Memastikan instansi otomatis terdaftar
        $this->assertDatabaseHas('instansis', [
            'nama' => 'Politeknik Negeri Sriwijaya',
        ]);
    }

    public function test_TC_KSB_03_kasubbag_reject_pengajuan_requires_reason(): void
    {
        $kasubbag = User::factory()->create(['role' => User::ROLE_KASUBBAG]);
        $pengajuan = Pengajuan::create([
            'jml_peserta'           => 1,
            'nama_instansi'         => 'Universitas Terbuka',
            'pic_nama'              => 'Dedi Setiawan',
            'nim_nisn'              => '041234567',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Ilmu Komunikasi',
            'pic_email'             => 'dedi@ut.ac.id',
            'pic_telp'              => '081234567896',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => 'pengajuan/surat/dummy.pdf',
            'file_transkrip'        => 'pengajuan/transkrip/dummy.pdf',
            'file_surat_pernyataan' => 'pengajuan/surat_pernyataan/dummy.pdf',
            'status'                => 'pending',
        ]);

        // Tolak tanpa alasan -> gagal validasi
        $responseFail = $this->actingAs($kasubbag)->patch(route('kasubbag.pengajuan.reject', $pengajuan), [
            'keterangan_reject' => '',
        ]);
        $responseFail->assertSessionHasErrors('keterangan_reject');

        // Tolak dengan alasan -> berhasil
        $responseSuccess = $this->actingAs($kasubbag)->patch(route('kasubbag.pengajuan.reject', $pengajuan), [
            'keterangan_reject' => 'Kuota magang bidang terkait pada periode ini sudah penuh.',
        ]);
        $responseSuccess->assertRedirect(route('kasubbag.pengajuan.show', $pengajuan));
        $responseSuccess->assertSessionHas('success');

        $pengajuan->refresh();
        $this->assertEquals('rejected', $pengajuan->status);
        $this->assertEquals('Kuota magang bidang terkait pada periode ini sudah penuh.', $pengajuan->keterangan_reject);
    }

    public function test_TC_KSB_04_kasubbag_crud_peserta(): void
    {
        $kasubbag = User::factory()->create(['role' => User::ROLE_KASUBBAG]);
        $instansi = Instansi::create(['nama' => 'Universitas Sriwijaya', 'email' => 'unsri@unsri.ac.id', 'telp' => '071112345']);
        $bidang = Bidang::create(['nama' => 'Teknologi Informasi', 'deskripsi' => 'Divisi IT']);
        $pengajuan = Pengajuan::create([
            'jml_peserta'           => 1,
            'instansi_id'           => $instansi->id,
            'nama_instansi'         => $instansi->nama,
            'pic_nama'              => 'Hendra Wijaya',
            'nim_nisn'              => '09021182025088',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Informatika',
            'pic_email'             => 'hendra@unsri.ac.id',
            'pic_telp'              => '081234567897',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => 'dummy.pdf',
            'file_transkrip'        => 'dummy.pdf',
            'file_surat_pernyataan' => 'dummy.pdf',
            'status'                => 'approved',
        ]);

        // 1. Create Peserta Manual
        $responseStore = $this->actingAs($kasubbag)->post(route('kasubbag.peserta.store'), [
            'pengajuan_id'  => $pengajuan->id,
            'bidang_id'     => $bidang->id,
            'nim_nisn'      => '09021182025088',
            'nama'          => 'Hendra Wijaya',
            'jurusan'       => 'Informatika',
            'jenis_peserta' => 'Mahasiswa',
            'tgl_mulai'     => '2026-09-01',
            'tgl_selesai'   => '2026-11-30',
            'status'        => 'aktif',
        ]);
        $responseStore->assertRedirect(route('kasubbag.peserta.index'));
        $this->assertDatabaseHas('pesertas', ['nama' => 'Hendra Wijaya']);

        $peserta = Peserta::where('nama', 'Hendra Wijaya')->first();

        // 2. Update Peserta
        $responseUpdate = $this->actingAs($kasubbag)->put(route('kasubbag.peserta.update', $peserta), [
            'pengajuan_id'  => $pengajuan->id,
            'bidang_id'     => $bidang->id,
            'nim_nisn'      => '09021182025088',
            'nama'          => 'Hendra Wijaya Updated',
            'jurusan'       => 'Sistem Informasi',
            'jenis_peserta' => 'Mahasiswa',
            'tgl_mulai'     => '2026-09-01',
            'tgl_selesai'   => '2026-11-30',
            'status'        => 'aktif',
        ]);
        $responseUpdate->assertRedirect(route('kasubbag.peserta.index'));
        $this->assertDatabaseHas('pesertas', ['nama' => 'Hendra Wijaya Updated']);

        // 3. Delete Peserta
        $responseDelete = $this->actingAs($kasubbag)->delete(route('kasubbag.peserta.destroy', $peserta));
        $responseDelete->assertRedirect(route('kasubbag.peserta.index'));
        $this->assertSoftDeleted('pesertas', ['id' => $peserta->id]);
    }

    // =========================================================================
    // MODUL 3: ADMIN (ROLE 1)
    // =========================================================================

    public function test_TC_ADM_01_admin_crud_master_bidang_with_delete_protection(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        // 1. Create Bidang
        $response = $this->actingAs($admin)->post(route('admin.bidang.store'), [
            'nama'      => 'Divisi Pemasaran',
            'deskripsi' => 'Pengelolaan marketing dan humas',
        ]);
        $response->assertRedirect(route('admin.bidang.index'));
        $this->assertDatabaseHas('bidangs', ['nama' => 'Divisi Pemasaran']);

        $bidang = Bidang::where('nama', 'Divisi Pemasaran')->first();

        // 2. Update Bidang
        $responseUpdate = $this->actingAs($admin)->put(route('admin.bidang.update', $bidang), [
            'nama'      => 'Divisi Pemasaran & Humas',
            'deskripsi' => 'Updated deskripsi',
        ]);
        $responseUpdate->assertRedirect(route('admin.bidang.index'));
        $this->assertDatabaseHas('bidangs', ['nama' => 'Divisi Pemasaran & Humas']);

        // 3. Delete Bidang (tanpa relasi -> berhasil dengan soft delete)
        $responseDelete = $this->actingAs($admin)->delete(route('admin.bidang.destroy', $bidang));
        $responseDelete->assertRedirect(route('admin.bidang.index'));
        $responseDelete->assertSessionHas('success');
        $this->assertSoftDeleted('bidangs', ['id' => $bidang->id]);
    }

    public function test_TC_ADM_02_admin_crud_master_pembimbing_auto_generates_user(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $bidang = Bidang::create(['nama' => 'Divisi SDM', 'deskripsi' => 'Sumber Daya Manusia']);

        // 1. Tambah Pembimbing (otomatis buat User role 2)
        $response = $this->actingAs($admin)->post(route('admin.pembimbing.store'), [
            'bidang_id' => $bidang->id,
            'nip'       => '198501012010011001',
            'nama'      => 'Bambang Supriyanto, M.M.',
            'no_hp'     => '081298765432',
            'email'     => 'bambang@disdik.sumselprov.go.id',
            'password'  => 'password123',
        ]);

        $response->assertRedirect(route('admin.pembimbing.index'));
        $this->assertDatabaseHas('pembimbings', ['nama' => 'Bambang Supriyanto, M.M.']);
        $this->assertDatabaseHas('users', ['email' => 'bambang@disdik.sumselprov.go.id', 'role' => User::ROLE_PEMBIMBING]);
    }

    public function test_TC_ADM_03_admin_cannot_delete_self(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->delete(route('admin.user.destroy', $admin));
        $response->assertRedirect(route('admin.user.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_TC_ADM_04_admin_penentuan_pembimbing_and_rekap_nilai(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $bidang = Bidang::create(['nama' => 'Divisi Keuangan']);
        $userPembimbing = User::factory()->create(['role' => User::ROLE_PEMBIMBING]);
        $pembimbing = Pembimbing::create([
            'user_id'   => $userPembimbing->id,
            'bidang_id' => $bidang->id,
            'nip'       => '198701012015011002',
            'nama'      => 'Dra. Ratna Juwita',
            'no_hp'     => '081377889900',
        ]);
        $peserta = Peserta::create([
            'nama'      => 'Indra Kusuma',
            'nim_nisn'  => '09021182025111',
            'status'    => 'aktif',
        ]);

        // Penentuan Pembimbing
        $responseAssign = $this->actingAs($admin)->patch(route('admin.penentuan_pembimbing.update', $peserta), [
            'bidang_id'     => $bidang->id,
            'pembimbing_id' => $pembimbing->id,
        ]);
        $responseAssign->assertRedirect();
        $responseAssign->assertSessionHas('success');

        $peserta->refresh();
        $this->assertEquals($bidang->id, $peserta->bidang_id);
        $this->assertEquals($pembimbing->id, $peserta->pembimbing_id);

        // Rekap Nilai: Cek download PDF sebelum dinilai (harus gagal)
        $responsePdfUnrated = $this->actingAs($admin)->get(route('admin.rekap_nilai.pdf', $peserta));
        $responsePdfUnrated->assertRedirect();
        $responsePdfUnrated->assertSessionHas('error');

        // Rekap Nilai: Cek download PDF setelah dinilai (harus sukses)
        Penilaian::create([
            'peserta_id'          => $peserta->id,
            'pembimbing_id'       => $pembimbing->id,
            'kedisiplinan'        => 90,
            'kerapian'            => 85,
            'kebersihan'          => 85,
            'tanggung_jawab'      => 90,
            'kerjasama'           => 95,
            'kreativitas'         => 90,
            'kejujuran'           => 90,
            'nilai_angka'         => 89.29,
            'status_administrasi' => 'dinilai_pembimbing',
        ]);

        $responsePdfRated = $this->actingAs($admin)->get(route('admin.rekap_nilai.pdf', $peserta));
        $responsePdfRated->assertStatus(200);
        $responsePdfRated->assertHeader('content-type', 'application/pdf');

        $responseSertifikat = $this->actingAs($admin)->get(route('admin.rekap_nilai.sertifikat', $peserta));
        $responseSertifikat->assertStatus(200);
        $responseSertifikat->assertHeader('content-type', 'application/pdf');
    }

    // =========================================================================
    // MODUL 4: PEMBIMBING (ROLE 2)
    // =========================================================================

    public function test_TC_PMB_01_pembimbing_absensi_management_and_authorization(): void
    {
        $userPmb1 = User::factory()->create(['role' => User::ROLE_PEMBIMBING]);
        $pmb1 = Pembimbing::create(['user_id' => $userPmb1->id, 'nama' => 'Pembimbing 1', 'nip' => '111', 'no_hp' => '0811']);
        $peserta1 = Peserta::create(['nama' => 'Bimbingan 1', 'pembimbing_id' => $pmb1->id, 'status' => 'aktif']);

        $userPmb2 = User::factory()->create(['role' => User::ROLE_PEMBIMBING]);
        $pmb2 = Pembimbing::create(['user_id' => $userPmb2->id, 'nama' => 'Pembimbing 2', 'nip' => '222', 'no_hp' => '0822']);
        $peserta2 = Peserta::create(['nama' => 'Bimbingan 2', 'pembimbing_id' => $pmb2->id, 'status' => 'aktif']);

        // Pmb 1 mencatat absensi untuk Peserta 1 -> Sukses
        $responseStore = $this->actingAs($userPmb1)->post(route('pembimbing.absensi.store'), [
            'peserta_id' => $peserta1->id,
            'tanggal'    => '2026-08-18',
            'status'     => 'hadir',
            'keterangan' => 'Hadir tepat waktu',
        ]);
        $responseStore->assertRedirect(route('pembimbing.absensi.index'));
        $this->assertDatabaseHas('absensis', ['peserta_id' => $peserta1->id, 'status' => 'hadir']);

        $absensi = Absensi::where('peserta_id', $peserta1->id)->first();

        // Pmb 2 mencoba menginput absensi untuk Peserta 1 (bukan bimbingannya) -> Ditolak validasi (302 with session errors)
        $responseUnauthorized = $this->actingAs($userPmb2)->post(route('pembimbing.absensi.store'), [
            'peserta_id' => $peserta1->id,
            'tanggal'    => '2026-08-18',
            'status'     => 'izin',
        ]);
        $responseUnauthorized->assertSessionHasErrors('peserta_id');
    }

    public function test_TC_PMB_02_pembimbing_penilaian_with_automatic_average_calculation(): void
    {
        $userPmb = User::factory()->create(['role' => User::ROLE_PEMBIMBING]);
        $pmb = Pembimbing::create(['user_id' => $userPmb->id, 'nama' => 'Pembimbing Lapangan', 'nip' => '333', 'no_hp' => '0833']);
        $peserta = Peserta::create(['nama' => 'Peserta Uji Penilaian', 'pembimbing_id' => $pmb->id, 'status' => 'aktif']);

        $response = $this->actingAs($userPmb)->post(route('pembimbing.penilaian.store'), [
            'peserta_id'     => $peserta->id,
            'kedisiplinan'   => 80,
            'kerapian'       => 80,
            'kebersihan'     => 80,
            'tanggung_jawab' => 80,
            'kerjasama'      => 80,
            'kreativitas'    => 80,
            'kejujuran'      => 80,
            'catatan'        => 'Kinerja sangat baik dan adaptif.',
        ]);

        $response->assertRedirect(route('pembimbing.penilaian.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('penilaians', [
            'peserta_id'  => $peserta->id,
            'nilai_angka' => 80.00,
        ]);
    }

    // =========================================================================
    // MODUL 5: PESERTA (ROLE 3)
    // =========================================================================

    public function test_TC_PST_01_peserta_registration_flow(): void
    {
        $peserta = Peserta::create([
            'nama'      => 'Galang Ramadhan',
            'nim_nisn'  => '09021182025777',
            'status'    => 'aktif',
            'user_id'   => null,
        ]);

        $response = $this->post('/register', [
            'peserta_id'            => $peserta->id,
            'email'                 => 'galang@student.unsri.ac.id',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $peserta->refresh();
        $this->assertNotNull($peserta->user_id);
        $this->assertEquals(User::ROLE_PESERTA, $peserta->user->role);

        // Percobaan mendaftar lagi pada peserta yang sudah punya akun -> Ditolak
        auth()->logout();
        $responseDuplicate = $this->post('/register', [
            'peserta_id'            => $peserta->id,
            'email'                 => 'galang2@student.unsri.ac.id',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);
        $responseDuplicate->assertSessionHasErrors('peserta_id');
    }

    public function test_TC_PST_02_peserta_self_absensi_and_duplicate_prevention(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_PESERTA]);
        $peserta = Peserta::create([
            'user_id'  => $user->id,
            'nama'     => 'Test Peserta Absen',
            'status'   => 'aktif',
        ]);

        // 1. Absen pertama hari ini dengan logbook dan foto -> Sukses
        \Illuminate\Support\Facades\Storage::fake('public');
        $dummyFoto = UploadedFile::fake()->image('kegiatan.jpg');

        $responseFirst = $this->actingAs($user)->post(route('peserta.absensi.self'), [
            'status'        => 'hadir',
            'keterangan'    => 'Hadir di kantor tepat waktu',
            'logbook'       => 'Mengerjakan input data pengajuan dan analisis sistem magang.',
            'foto_kegiatan' => $dummyFoto,
        ]);
        $responseFirst->assertRedirect(route('peserta.absensi'));
        $responseFirst->assertSessionHas('success');
        $this->assertDatabaseHas('absensis', [
            'peserta_id' => $peserta->id,
            'status'     => 'hadir',
            'logbook'    => 'Mengerjakan input data pengajuan dan analisis sistem magang.',
        ]);

        // Update logbook hari ini
        $responseUpdateLogbook = $this->actingAs($user)->put(route('peserta.absensi.logbook'), [
            'logbook' => 'Update logbook: Melakukan pengujian fitur absensi.',
        ]);
        $responseUpdateLogbook->assertRedirect(route('peserta.absensi'));
        $responseUpdateLogbook->assertSessionHas('success');
        $this->assertDatabaseHas('absensis', [
            'peserta_id' => $peserta->id,
            'logbook'    => 'Update logbook: Melakukan pengujian fitur absensi.',
        ]);

        // 2. Absen kedua di hari yang sama -> Ditolak / dicegah
        $responseSecond = $this->actingAs($user)->post(route('peserta.absensi.self'), [
            'status'     => 'izin',
            'keterangan' => 'Mencoba absen lagi',
        ]);
        $responseSecond->assertRedirect(route('peserta.absensi'));
        $responseSecond->assertSessionHas('info');
    }

    public function test_TC_PST_03_peserta_sertifikat_download_validation(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_PESERTA]);
        $peserta = Peserta::create([
            'user_id'  => $user->id,
            'nama'     => 'Yunita Anggraini',
            'status'   => 'aktif',
        ]);

        // Belum dinilai -> Gagal unduh
        $responseUnrated = $this->actingAs($user)->get(route('peserta.sertifikat.download'));
        $responseUnrated->assertRedirect();
        $responseUnrated->assertSessionHas('error');

        // Sudah dinilai -> Berhasil unduh PDF
        Penilaian::create([
            'peserta_id'          => $peserta->id,
            'kedisiplinan'        => 90,
            'kerapian'            => 90,
            'kebersihan'          => 90,
            'tanggung_jawab'      => 90,
            'kerjasama'           => 90,
            'kreativitas'         => 90,
            'kejujuran'           => 90,
            'nilai_angka'         => 90.00,
            'status_administrasi' => 'dinilai_pembimbing',
        ]);

        $user->refresh();
        $responseRated = $this->actingAs($user)->get(route('peserta.sertifikat.download'));
        $responseRated->assertStatus(200);
        $responseRated->assertHeader('content-type', 'application/pdf');
    }

    public function test_TC_PST_04_peserta_loa_download_validation(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_PESERTA]);
        $pengajuan = Pengajuan::create([
            'nama_instansi'         => 'Politeknik Negeri Sriwijaya',
            'pic_nama'              => 'Yunita Anggraini',
            'pic_email'             => 'yunita@polsri.ac.id',
            'pic_telp'              => '081234567899',
            'jml_peserta'           => 1,
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'status'                => 'pending',
            'file_surat'            => 'pengajuan/surat/dummy.pdf',
            'file_transkrip'        => 'pengajuan/transkrip/dummy.pdf',
            'file_surat_pernyataan' => 'pengajuan/surat_pernyataan/dummy.pdf',
        ]);

        $peserta = Peserta::create([
            'user_id'      => $user->id,
            'pengajuan_id' => $pengajuan->id,
            'nama'         => 'Yunita Anggraini',
            'status'       => 'aktif',
        ]);

        // Belum disetujui -> Gagal unduh LoA
        $responseUnapproved = $this->actingAs($user)->get(route('peserta.loa.download'));
        $responseUnapproved->assertRedirect();
        $responseUnapproved->assertSessionHas('error');

        // Disetujui -> Berhasil unduh LoA PDF
        $pengajuan->update(['status' => 'approved']);
        $responseApproved = $this->actingAs($user)->get(route('peserta.loa.download'));
        $responseApproved->assertStatus(200);
        $responseApproved->assertHeader('content-type', 'application/pdf');
    }

    // =========================================================================
    // MODUL 6: ROLE-BASED ACCESS CONTROL (RBAC) & SECURITY
    // =========================================================================

    public function test_TC_SEC_01_unauthenticated_users_redirected_to_login(): void
    {
        $this->get(route('dashboard'))->assertRedirect('/login');
        $this->get(route('admin.bidang.index'))->assertRedirect('/login');
        $this->get(route('kasubbag.pengajuan.index'))->assertRedirect('/login');
        $this->get(route('pembimbing.absensi.index'))->assertRedirect('/login');
        $this->get(route('peserta.status'))->assertRedirect('/login');
    }

    public function test_TC_SEC_02_cross_role_access_blocked_with_403_forbidden(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $kasubbag = User::factory()->create(['role' => User::ROLE_KASUBBAG]);
        $pembimbing = User::factory()->create(['role' => User::ROLE_PEMBIMBING]);
        $peserta = User::factory()->create(['role' => User::ROLE_PESERTA]);

        // Peserta coba akses Admin -> 403
        $this->actingAs($peserta)->get(route('admin.bidang.index'))->assertStatus(403);

        // Peserta coba akses Kasubbag -> 403
        $this->actingAs($peserta)->get(route('kasubbag.pengajuan.index'))->assertStatus(403);

        // Pembimbing coba akses Kasubbag -> 403
        $this->actingAs($pembimbing)->get(route('kasubbag.pengajuan.index'))->assertStatus(403);

        // Kasubbag coba akses Admin -> 403
        $this->actingAs($kasubbag)->get(route('admin.bidang.index'))->assertStatus(403);

        // Admin coba akses Pembimbing -> 403
        $this->actingAs($admin)->get(route('pembimbing.absensi.index'))->assertStatus(403);
    }

    // =========================================================================
    // MODUL 7: BOUNDARY VALUE ANALYSIS (BVA) & ERROR GUESSING / SECURITY
    // =========================================================================

    public function test_TC_BVA_01_file_upload_mime_and_size_boundary(): void
    {
        // 1. File ekstensi tidak diizinkan (.exe / .php)
        $invalidMimeFile = UploadedFile::fake()->create('script.php', 100, 'application/x-php');
        $validPdf = UploadedFile::fake()->create('valid.pdf', 500, 'application/pdf');

        $responseInvalidMime = $this->post('/pengajuan', [
            'pic_nama'              => 'Uji Ekstensi',
            'nim_nisn'              => '123456',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Sistem Informasi',
            'nama_instansi'         => 'Universitas Test',
            'pic_email'             => 'test@test.com',
            'pic_telp'              => '08123456789',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => $invalidMimeFile,
            'file_transkrip'        => $validPdf,
            'file_surat_pernyataan' => $validPdf,
        ]);
        $responseInvalidMime->assertSessionHasErrors('file_surat');

        // 2. File melebihi batas ukuran (6000 KB > 5120 KB)
        $oversizedFile = UploadedFile::fake()->create('big.pdf', 6000, 'application/pdf');
        $responseOversized = $this->post('/pengajuan', [
            'pic_nama'              => 'Uji Ukuran',
            'nim_nisn'              => '123456',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => 'Sistem Informasi',
            'nama_instansi'         => 'Universitas Test',
            'pic_email'             => 'test@test.com',
            'pic_telp'              => '08123456789',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => $oversizedFile,
            'file_transkrip'        => $validPdf,
            'file_surat_pernyataan' => $validPdf,
        ]);
        $responseOversized->assertSessionHasErrors('file_surat');
    }

    public function test_TC_BVA_02_penilaian_numeric_boundaries(): void
    {
        $userPmb = User::factory()->create(['role' => User::ROLE_PEMBIMBING]);
        $pmb = Pembimbing::create(['user_id' => $userPmb->id, 'nama' => 'Pembimbing BVA', 'nip' => '444', 'no_hp' => '0844']);
        $peserta = Peserta::create(['nama' => 'Peserta BVA', 'pembimbing_id' => $pmb->id, 'status' => 'aktif']);

        // 1. Nilai di luar batas atas (> 100) -> Gagal validasi
        $responseOver = $this->actingAs($userPmb)->post(route('pembimbing.penilaian.store'), [
            'peserta_id'   => $peserta->id,
            'kedisiplinan' => 105,
        ]);
        $responseOver->assertSessionHasErrors('kedisiplinan');

        // 2. Nilai negatif (< 0) -> Gagal validasi
        $responseUnder = $this->actingAs($userPmb)->post(route('pembimbing.penilaian.store'), [
            'peserta_id'   => $peserta->id,
            'kedisiplinan' => -5,
        ]);
        $responseUnder->assertSessionHasErrors('kedisiplinan');

        // 3. Nilai batas sah (0 dan 100) -> Sukses
        $responseValid = $this->actingAs($userPmb)->post(route('pembimbing.penilaian.store'), [
            'peserta_id'     => $peserta->id,
            'kedisiplinan'   => 100,
            'kerapian'       => 0,
            'kebersihan'     => 100,
            'tanggung_jawab' => 100,
            'kerjasama'      => 100,
            'kreativitas'    => 100,
            'kejujuran'      => 100,
        ]);
        $responseValid->assertRedirect(route('pembimbing.penilaian.index'));
        $this->assertDatabaseHas('penilaians', ['peserta_id' => $peserta->id]);
    }

    public function test_TC_SEC_03_xss_and_injection_input_sanitization(): void
    {
        $fileSurat = UploadedFile::fake()->create('surat.pdf', 500, 'application/pdf');
        $fileTranskrip = UploadedFile::fake()->create('transkrip.pdf', 500, 'application/pdf');
        $filePernyataan = UploadedFile::fake()->create('pernyataan.pdf', 500, 'application/pdf');

        $xssPayload = "<script>alert('XSS_ATTACK')</script>Budi Santoso";

        $response = $this->post('/pengajuan', [
            'pic_nama'              => $xssPayload,
            'nim_nisn'              => '<b>09021182025001</b>',
            'jenis_peserta'         => 'Mahasiswa',
            'jurusan'               => '<i>Teknik Informatika</i>',
            'nama_instansi'         => '<u>Universitas Sriwijaya</u>',
            'pic_email'             => 'xss_safe@unsri.ac.id',
            'pic_telp'              => '081234567890',
            'tgl_mulai'             => '2026-09-01',
            'tgl_selesai'           => '2026-11-30',
            'file_surat'            => $fileSurat,
            'file_transkrip'        => $fileTranskrip,
            'file_surat_pernyataan' => $filePernyataan,
            'keterangan'            => '<h1>Test XSS Sanitization</h1>',
        ]);

        $response->assertRedirect(route('pengajuan.form'));

        // Memastikan tag HTML berbahaya telah disanitasi oleh strip_tags
        $this->assertDatabaseMissing('pengajuans', [
            'pic_nama' => $xssPayload,
        ]);
        $this->assertDatabaseHas('pengajuans', [
            'pic_nama'      => "alert('XSS_ATTACK')Budi Santoso",
            'nim_nisn'      => '09021182025001',
            'jurusan'       => 'Teknik Informatika',
            'nama_instansi' => 'Universitas Sriwijaya',
            'keterangan'    => 'Test XSS Sanitization',
        ]);
    }
}
