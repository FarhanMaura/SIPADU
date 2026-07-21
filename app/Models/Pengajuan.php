<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'instansi_id',
        'nama_instansi',
        'pic_nama',
        'pic_email',
        'pic_telp',
        'jml_peserta',
        'tgl_mulai',
        'tgl_selesai',
        'file_surat',
        'file_peserta',
        'status',
        'keterangan',
        'keterangan_reject',
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
}
