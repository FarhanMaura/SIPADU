<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_PEMBIMBING = 2;
    const ROLE_PESERTA = 3;
    const ROLE_KASUBBAG = 4;

    const STATUS_AKTIF = 'aktif';
    const STATUS_PENDING = 'pending';
    const STATUS_DITOLAK = 'ditolak';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function peserta()
    {
        return $this->hasOne(Peserta::class);
    }

    public function pengajuan()
    {
        return $this->hasOne(Pengajuan::class);
    }

    public function pembimbing()
    {
        return $this->hasOne(Pembimbing::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_AKTIF;
    }

    public function isDitolak(): bool
    {
        return $this->status === self::STATUS_DITOLAK;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPembimbing(): bool
    {
        return $this->role === self::ROLE_PEMBIMBING;
    }

    public function isPeserta(): bool
    {
        return $this->role === self::ROLE_PESERTA;
    }

    public function isKasubbag(): bool
    {
        return $this->role === self::ROLE_KASUBBAG;
    }
}
