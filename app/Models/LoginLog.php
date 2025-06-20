<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = ['id_user', 'login_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}