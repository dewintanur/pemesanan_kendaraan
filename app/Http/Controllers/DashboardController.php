<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Kendaraan;
use App\Models\Driver;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Pemesanan per bulan (chart 1)
        $pemesananPerBulan = Pemesanan::selectRaw('MONTH(tanggal_pakai) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $bulanLabels = [];
        $jumlahData = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = Carbon::create()->month($i)->format('M');
            $jumlahData[] = $pemesananPerBulan->get($i, 0);
        }

        // Pemesanan per kendaraan (chart 2)
        $perKendaraan = Pemesanan::with('kendaraan')
            ->selectRaw('kendaraan_id, COUNT(*) as total')
            ->groupBy('kendaraan_id')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->kendaraan->nomor_plat . ' - ' . $item->kendaraan->jenis,
                    'total' => $item->total,
                ];
            });

        $kendaraanLabels = $perKendaraan->pluck('nama');
        $kendaraanData = $perKendaraan->pluck('total');

        // Tambahan statistik untuk dashboard
        $totalKendaraan = Kendaraan::count();
        $totalPemesanan = Pemesanan::count();
        $totalDriver = Driver::count();
        $totalApprover = User::where('role', 'approver')->count();

        return view('dashboard', compact(
            'bulanLabels',
            'jumlahData',
            'kendaraanLabels',
            'kendaraanData',
            'totalKendaraan',
            'totalPemesanan',
            'totalDriver',
            'totalApprover'
        ));
    }
}
