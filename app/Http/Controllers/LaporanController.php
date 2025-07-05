<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PemesananExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Pemesanan;

class LaporanController extends Controller
{
 public function index(Request $request)
{
    $from = $request->from;
    $to = $request->to;
    $data = [];

    if ($from && $to) {
        $data = Pemesanan::with(['user', 'kendaraan', 'driver'])
            ->whereBetween('tanggal_pakai', [$from, $to])
            ->get();
    }

    return view('laporan.index', compact('data', 'from', 'to'));
}


    public function export(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to'   => 'required|date|after_or_equal:from'
        ]);

        return Excel::download(new PemesananExport($request->from, $request->to), 'laporan_pemesanan.xlsx');
    }
}
