<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'pengajuan_id',
        'instansi_id',
        'bidang_id',
        'pembimbing_id',
        'nim_nisn',
        'nama',
        'jurusan',
        'jenis_peserta',
        'tgl_mulai',
        'tgl_selesai',
        'status',
    ];

    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function penilaian()
    {
        return $this->hasOne(Penilaian::class);
    }
}
