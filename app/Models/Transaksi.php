<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $fillable = [
        'id_barang',
        'id_user',
        'tanggal',
        'tipe_transaksi',
        'qty',
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