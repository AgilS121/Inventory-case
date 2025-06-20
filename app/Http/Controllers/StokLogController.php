<?php

namespace App\Http\Controllers;

use App\Models\StokLog;

class StokLogController extends Controller
{
    public function index()
    {
        $logs = StokLog::with('barang', 'user')->orderByDesc('created_at')->get();
        return response()->json($logs);
    }
}