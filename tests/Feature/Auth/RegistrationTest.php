<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Pendaftaran Peserta Magang Mandiri');
    }

    public function test_new_users_can_self_register_and_require_kasubbag_validation(): void
    {
        $response = $this->post('/register', [
            'nama'                  => 'Ahmad Fadhil',
            'nim_nisn'              => '09021182025999',
            'jenis_peserta'         => 'Mahasiswa',
            'nama_instansi'         => 'Universitas Sriwijaya',
            'jurusan'               => 'Teknik Informatika',
            'no_wa'                 => '083826383761',
            'email'                 => 'fadhil@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'tgl_mulai'             => '2026-10-01',
            'tgl_selesai'           => '2026-12-31',
            'file_surat'            => UploadedFile::fake()->create('surat.pdf', 500, 'application/pdf'),
            'file_transkrip'        => UploadedFile::fake()->create('transkrip.pdf', 500, 'application/pdf'),
            'file_surat_pernyataan' => UploadedFile::fake()->create('pernyataan.pdf', 500, 'application/pdf'),
        ]);

        $response->assertRedirect(route('login'));
        $this->assertGuest(); // User TIDAK langsung login

        $this->assertDatabaseHas('users', [
            'email'  => 'fadhil@example.com',
            'role'   => User::ROLE_PESERTA,
            'status' => User::STATUS_PENDING,
        ]);

        $this->assertDatabaseHas('pengajuans', [
            'pic_email' => 'fadhil@example.com',
            'pic_telp'  => '083826383761',
            'status'    => 'pending',
        ]);

        // Percobaan login saat status masih pending harus ditolak
        $responseLogin = $this->post('/login', [
            'email'    => 'fadhil@example.com',
            'password' => 'password123',
        ]);
        $this->assertGuest();
        $responseLogin->assertSessionHasErrors('email');
    }
}
