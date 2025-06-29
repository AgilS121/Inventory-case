<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;    
    protected $table = 'users';
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_user');
    }

    public function stokLogs()
    {
        return $this->hasMany(StokLog::class, 'id_user');
    }
    
}