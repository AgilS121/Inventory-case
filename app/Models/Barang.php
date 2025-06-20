<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $fillable = [
        'nama',
        'kode',
        'stok',
        'lokasi_rak',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_barang');
    }

    public function stokLogs()
    {
        return $this->hasMany(StokLog::class, 'id_barang');
    }
}