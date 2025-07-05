<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pemesanan;
use App\Models\RiwayatKendaraan;
use Illuminate\Http\Request;
use App\Exports\RiwayatExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
class RiwayatKendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatKendaraan::with(['kendaraan', 'pemesanan.user']);

        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_mulai', [$request->from, $request->to]);
        }

        $riwayat = $query->latest()->get();

        return view('riwayat.index', compact('riwayat'));
    }

    public function export(Request $request)
    {
        // Pastikan sudah install laravel-excel
        $data = RiwayatKendaraan::with(['kendaraan', 'pemesanan.user'])
            ->when($request->from && $request->to, function ($q) use ($request) {
                $q->whereBetween('tanggal_mulai', [$request->from, $request->to]);
            })->get();

        return Excel::download(new RiwayatExport($data), 'riwayat-kendaraan.xlsx');
    }

    public function form($id)
    {
        $pemesanan = Pemesanan::with('kendaraan')->findOrFail($id);
        return view('riwayat.form', compact('pemesanan'));
    }

    public function create()
    {
        $kendaraan = Kendaraan::all();
        $pemesanan = Pemesanan::with('user')->orderBy('tanggal_pakai', 'desc')->get();
        return view('riwayat.create', compact('kendaraan', 'pemesanan'));
    }

  public function store(Request $request)
{
    $request->validate([
        'pemesanan_id' => 'required',
        'kendaraan_id' => 'required',
        'km_awal' => 'required|integer',
        'km_akhir' => 'required|integer|gte:km_awal',
        'bbm_pakai' => 'nullable|integer',
        'catatan' => 'nullable|string',
        'tanggal_mulai' => 'nullable|date',
        'tanggal_selesai' => 'nullable|date',
    ]);

    // ✅ Cek apakah riwayat untuk pemesanan ini sudah ada
    $cek = RiwayatKendaraan::where('pemesanan_id', $request->pemesanan_id)->first();
    if ($cek) {
        return redirect()->back()->with('warning', 'Riwayat untuk pemesanan ini sudah pernah dibuat.');
    }

    // Simpan data riwayat kendaraan
    $riwayat = RiwayatKendaraan::create($request->all());

    // Update kendaraan
    $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
    $kendaraan->km_terakhir = $request->km_akhir;
    $kendaraan->tanggal_terakhir_bbm = now();

    $tanggalTerakhirService = $request->tanggal_selesai ?? now()->toDateString();
    $kendaraan->jadwal_service_berikutnya = \Carbon\Carbon::parse($tanggalTerakhirService)->addMonths(3)->toDateString();
    $kendaraan->save();

    // Tandai pemesanan selesai
    Pemesanan::where('id', $request->pemesanan_id)->update(['status' => 'selesai']);

    // Simpan log aktivitas
    Log::create([
        'user_id' => Auth::id(),
        'aktivitas' => 'Mengembalikan kendaraan ' . $kendaraan->nomor_plat .
            ' (ID Pemesanan: ' . $request->pemesanan_id . ')',
        'waktu' => now(),
    ]);

    return redirect()->route('pemesanan.index')->with('success', 'Riwayat disimpan & kendaraan dikembalikan.');
}


    /**
     * Tandai kendaraan sudah servis, update status & tanggal servis terakhir.
     */
    public function tandaiServis(Request $request, $kendaraanId)
    {
        $kendaraan = Kendaraan::findOrFail($kendaraanId);

        // Update status kendaraan jadi 'servis'
        $kendaraan->status = 'servis';

        // Update tanggal terakhir servis ke tanggal sekarang atau tanggal input user
        $tanggalServis = $request->input('tanggal_servis', now()->toDateString());
        $kendaraan->tanggal_terakhir_service = $tanggalServis;

        // Hitung ulang jadwal servis berikutnya dari tanggal servis terakhir yang baru
        $kendaraan->jadwal_service_berikutnya = \Carbon\Carbon::parse($tanggalServis)->addMonths(3)->toDateString();

        $kendaraan->save();
        Log::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menandai kendaraan ' . $kendaraan->nomor_plat . ' sebagai servis pada ' . $tanggalServis,
            'waktu' => now(),
        ]);

        return redirect()->back()->with('success', 'Status servis kendaraan berhasil diperbarui.');
    }
}
