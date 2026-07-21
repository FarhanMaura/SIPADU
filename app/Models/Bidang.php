<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidang extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function pembimbings()
    {
        return $this->hasMany(Pembimbing::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}
