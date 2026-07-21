<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instansi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'alamat',
        'telp',
        'email',
    ];

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}
