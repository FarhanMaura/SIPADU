<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembimbing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'bidang_id',
        'nip',
        'nama',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }
}
