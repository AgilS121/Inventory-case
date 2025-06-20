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
            'tipe_transaksi' => 'required|in:masuk,keluar'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->tanggal = $request->tanggal;
        $transaksi->tipe_transaksi = $request->tipe_transaksi;
        $transaksi->save();

        return response()->json(['message' => 'Transaksi diupdate']);
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            $transaksi = Transaksi::findOrFail($id);
            $barang = $transaksi->barang()->lockForUpdate()->first();

            $qty_before = $barang->stok;

            if ($transaksi->tipe_transaksi == 'masuk') {
                $barang->stok -= 1;
            } elseif ($transaksi->tipe_transaksi == 'keluar') {
                $barang->stok += 1;
            }

            if ($barang->stok < 0) {
                throw new \Exception("Stok tidak mencukupi untuk menghapus transaksi.");
            }

            $barang->save();

            $transaksi->delete();

            StokLog::create([
                'id_barang' => $barang->id,
                'qty_before' => $qty_before,
                'qty_after' => $barang->stok,
                'id_user' => auth()->user()->id
            ]);
        });

        return response()->json(['message' => 'Transaksi dihapus, stok diperbaiki, dan log dicatat']);
    }




}