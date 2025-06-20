<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\LoginLog;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_produk' => Barang::count(),
            'produk_ditambah' => Barang::whereDate('created_at', today())->count(),
            'produk_diubah' => Barang::whereDate('updated_at', today())->count(),
            'login_terakhir' => LoginLog::orderByDesc('login_at')->with('user')->first(),
        ]);
    }

    public function summary()
    {
        $totalBarang = Barang::count();
        $totalTransaksiHariIni = Transaksi::whereDate('tanggal', today())->count();
        $totalUsers = User::where('role', 'operator')->count();
        $stokMenipis = Barang::where('stok', '<', 10)->count();

        return response()->json([
            'total_barang' => $totalBarang,
            'transaksi_hari_ini' => $totalTransaksiHariIni,
            'total_users' => $totalUsers,
            'stok_menipis' => $stokMenipis,
        ]);
    }
}