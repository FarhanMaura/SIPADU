<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'                  => ['required', 'string', 'max:255'],
            'nim_nisn'              => ['required', 'string', 'max:100'],
            'jenis_peserta'         => ['required', 'string', 'max:100'],
            'nama_instansi'         => ['required', 'string', 'max:255'],
            'jurusan'               => ['required', 'string', 'max:255'],
            'no_wa'                 => ['required', 'string', 'max:25'],
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'tgl_mulai'             => ['required', 'date'],
            'tgl_selesai'           => ['required', 'date', 'after:tgl_mulai'],
            'file_surat'            => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_transkrip'        => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_surat_pernyataan' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'keterangan'            => ['nullable', 'string', 'max:1000'],
        ], [
            'nama.required'                  => 'Nama lengkap wajib diisi.',
            'nim_nisn.required'              => 'NIM / NIS / NISN wajib diisi.',
            'jenis_peserta.required'         => 'Kategori peserta wajib dipilih.',
            'nama_instansi.required'         => 'Asal sekolah / kampus wajib diisi.',
            'jurusan.required'               => 'Jurusan / program studi wajib diisi.',
            'no_wa.required'                 => 'Nomor WhatsApp / HP wajib diisi.',
            'email.required'                 => 'Alamat email wajib diisi.',
            'email.email'                    => 'Format email tidak valid.',
            'email.unique'                   => 'Alamat email ini sudah terdaftar. Silakan login atau gunakan email lain.',
            'password.required'              => 'Password wajib diisi.',
            'password.confirmed'             => 'Konfirmasi password tidak cocok.',
            'tgl_mulai.required'             => 'Tanggal mulai magang wajib diisi.',
            'tgl_selesai.required'           => 'Tanggal selesai magang wajib diisi.',
            'tgl_selesai.after'              => 'Tanggal selesai magang harus setelah tanggal mulai.',
            'file_surat.required'            => 'Surat pengantar permohonan magang wajib diunggah.',
            'file_surat.mimes'               => 'Surat pengantar harus berformat PDF, JPG, atau PNG.',
            'file_surat.max'                 => 'Surat pengantar maksimal berukuran 5MB.',
            'file_transkrip.required'        => 'Transkrip nilai wajib diunggah.',
            'file_transkrip.mimes'           => 'Transkrip nilai harus berformat PDF, JPG, atau PNG.',
            'file_transkrip.max'             => 'Transkrip nilai maksimal berukuran 5MB.',
            'file_surat_pernyataan.required' => 'Surat pernyataan magang berdampak wajib diunggah.',
            'file_surat_pernyataan.mimes'    => 'Surat pernyataan harus berformat PDF, JPG, atau PNG.',
            'file_surat_pernyataan.max'      => 'Surat pernyataan maksimal berukuran 5MB.',
        ]);

        $fileSuratPath = $request->file('file_surat')->store('pengajuan/surat', 'local');
        $fileTranskripPath = $request->file('file_transkrip')->store('pengajuan/transkrip', 'local');
        $filePernyataanPath = $request->file('file_surat_pernyataan')->store('pengajuan/surat_pernyataan', 'local');

        $namaSanitized = strip_tags($validated['nama']);
        $nimSanitized = strip_tags($validated['nim_nisn']);
        $jenisSanitized = strip_tags($validated['jenis_peserta']);
        $instansiSanitized = strip_tags($validated['nama_instansi']);
        $jurusanSanitized = strip_tags($validated['jurusan']);
        $waSanitized = strip_tags($validated['no_wa']);
        $keteranganSanitized = !empty($validated['keterangan']) ? strip_tags($validated['keterangan']) : null;

        DB::transaction(function () use (
            $validated,
            $namaSanitized,
            $nimSanitized,
            $jenisSanitized,
            $instansiSanitized,
            $jurusanSanitized,
            $waSanitized,
            $keteranganSanitized,
            $fileSuratPath,
            $fileTranskripPath,
            $filePernyataanPath
        ) {
            $user = User::create([
                'name'     => $namaSanitized,
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => User::ROLE_PESERTA,
                'status'   => User::STATUS_PENDING,
            ]);

            Pengajuan::create([
                'user_id'               => $user->id,
                'pic_nama'              => $namaSanitized,
                'nim_nisn'              => $nimSanitized,
                'jenis_peserta'         => $jenisSanitized,
                'nama_instansi'         => $instansiSanitized,
                'jurusan'               => $jurusanSanitized,
                'pic_email'             => $validated['email'],
                'pic_telp'              => $waSanitized,
                'jml_peserta'           => 1,
                'tgl_mulai'             => $validated['tgl_mulai'],
                'tgl_selesai'           => $validated['tgl_selesai'],
                'file_surat'            => $fileSuratPath,
                'file_transkrip'        => $fileTranskripPath,
                'file_surat_pernyataan' => $filePernyataanPath,
                'status'                => 'pending',
                'keterangan'            => $keteranganSanitized,
            ]);

            event(new Registered($user));
        });

        return redirect()->route('login')->with(
            'status',
            'Pendaftaran dan registrasi akun berhasil! Status akun Anda saat ini PENDING menunggu verifikasi Kasubbag. Pengumuman status penerimaan (LoA) akan dikirimkan ke WhatsApp (' . $waSanitized . ') dan Email (' . $validated['email'] . ').'
        );
    }
}
