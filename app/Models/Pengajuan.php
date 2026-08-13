<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'instansi_id',
        'nama_instansi',
        'pic_nama',
        'nim_nisn',
        'jenis_peserta',
        'jurusan',
        'pic_email',
        'pic_telp',
        'jml_peserta',
        'tgl_mulai',
        'tgl_selesai',
        'file_surat',
        'file_peserta',
        'file_transkrip',
        'file_surat_pernyataan',
        'status',
        'keterangan',
        'keterangan_reject',
        'rekomendasi_instansi',
    ];

    protected $casts = [
        'tgl_mulai'  => 'date',
        'tgl_selesai' => 'date',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }

    public function syncPesertaOnApproval(): Peserta
    {
        $instansiId = $this->instansi_id;
        if (!$instansiId && !empty($this->nama_instansi)) {
            $instansi = Instansi::firstOrCreate(
                ['nama' => $this->nama_instansi],
                [
                    'email' => $this->pic_email,
                    'telp'  => $this->pic_telp,
                ]
            );
            $instansiId = $instansi->id;
            $this->update(['instansi_id' => $instansiId]);
        }

        $peserta = Peserta::where('pengajuan_id', $this->id)->first();
        if (!$peserta) {
            $peserta = Peserta::create([
                'pengajuan_id'  => $this->id,
                'instansi_id'   => $instansiId,
                'user_id'       => null, // Peserta mendaftar akun sendiri di /register setelah disetujui Kasubbag
                'nama'          => $this->pic_nama ?? 'Peserta Magang',
                'nim_nisn'      => $this->nim_nisn,
                'jurusan'       => $this->jurusan,
                'jenis_peserta' => $this->jenis_peserta ?? 'Mahasiswa',
                'tgl_mulai'     => $this->tgl_mulai,
                'tgl_selesai'   => $this->tgl_selesai,
                'status'        => 'aktif',
                'bidang_id'     => null,
            ]);
        } else {
            $peserta->update([
                'instansi_id'   => $instansiId,
                'nama'          => $this->pic_nama ?? $peserta->nama,
                'nim_nisn'      => $this->nim_nisn ?? $peserta->nim_nisn,
                'jurusan'       => $this->jurusan ?? $peserta->jurusan,
                'jenis_peserta' => $this->jenis_peserta ?? $peserta->jenis_peserta,
                'tgl_mulai'     => $this->tgl_mulai ?? $peserta->tgl_mulai,
                'tgl_selesai'   => $this->tgl_selesai ?? $peserta->tgl_selesai,
            ]);
        }

        return $peserta;
    }
}
