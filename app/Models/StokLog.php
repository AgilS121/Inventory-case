<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    protected $table = 'stok_logs';
    protected $fillable = [
        'id_barang',
        'qty_before',
        'qty_after',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}