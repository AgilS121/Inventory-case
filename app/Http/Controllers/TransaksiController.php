<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StokLog;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('barang', 'user')->get();
        return response()->json($transaksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'tanggal' => 'required|date',
            'tipe_transaksi' => 'required|in:masuk,keluar',
            'qty' => 'nullable|integer|min:1'
        ]);

        DB::transaction(function() use ($request) {
            $barang = Barang::where('id', $request->id_barang)
                        ->lockForUpdate()
                        ->first();

            $qty_before = $barang->stok;

            if ($request->tipe_transaksi == 'masuk') {
                $barang->stok += $request->qty;
            } elseif ($request->tipe_transaksi == 'keluar') {
                if ($barang->stok < $request->qty) {
                    throw new \Exception("Stok barang tidak mencukupi.");
                }
                $barang->stok -= $request->qty;
            }


            $barang->save();

            $transaksi = Transaksi::create([
                'id_barang' => $request->id_barang,
                'tanggal' => $request->tanggal,
                'tipe_transaksi' => $request->tipe_transaksi,
                'qty' => $request->qty ?? 1,
                'id_user' => $request->user()->id,
            ]);

            StokLog::create([
                'id_barang' => $barang->id,
                'qty_before' => $qty_before,
                'qty_after' => $barang->stok,
                'id_user' => $request->user()->id
            ]);
        });

        return response()->json(['message' => 'Transaksi berhasil ditambahkan dan stok diupdate']);
    }


    public function show($id)
    {
        $transaksi = Transaksi::with('barang', 'user')->findOrFail($id);
        return response()->json($transaksi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tipe_transaksi' => 'required|in:masuk,keluar',
            'qty' => 'required|integer|min:1'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        if (auth()->user()->role == 'operator' && $transaksi->id_user != auth()->id()) {
            return response()->json(['message' => 'Tidak diizinkan mengedit transaksi ini'], 403);
        }

        $barang = $transaksi->barang;

        if ($transaksi->tipe_transaksi == 'masuk') {
            $barang->stok -= $transaksi->qty;
        } else {
            $barang->stok += $transaksi->qty;
        }

        if ($request->tipe_transaksi == 'masuk') {
            $barang->stok += $request->qty;
        } else {
            if ($barang->stok < $request->qty) {
                return response()->json(['message' => 'Stok tidak mencukupi'], 422);
            }
            $barang->stok -= $request->qty;
        }

        $barang->save();

        $transaksi->tanggal = $request->tanggal;
        $transaksi->tipe_transaksi = $request->tipe_transaksi;
        $transaksi->qty = $request->qty;
        $transaksi->save();

        return response()->json(['message' => 'Berhasil diupdate']);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (auth()->user()->role == 'operator' && $transaksi->id_user != auth()->id()) {
            return response()->json(['message' => 'Tidak diizinkan menghapus transaksi ini'], 403);
        }

        $barang = $transaksi->barang;

        if ($transaksi->tipe_transaksi == 'masuk') {
            $barang->stok -= $transaksi->qty;
        } else {
            $barang->stok += $transaksi->qty;
        }

        $barang->save();
        $transaksi->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }

}