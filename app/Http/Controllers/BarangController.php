<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return response()->json($barang);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:barangs',
            'stok' => 'required|integer|min:0',
            'lokasi_rak' => 'required',
        ]);

        $barang = Barang::create($request->all());

        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return response()->json($barang);
    }

    public function destroy($id)
    {
        Barang::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}