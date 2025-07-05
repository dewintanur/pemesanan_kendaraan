<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\JadwalService;
class KendaraanController extends Controller
{
    // Tampil list kendaraan
    public function index()
    {
        $kendaraan = Kendaraan::latest()->get();
        return view('kendaraan.index', compact('kendaraan'));
    }

    // Form tambah kendaraan
    public function create()
    {
        return view('kendaraan.create');
    }

    // Simpan kendaraan baru
    public function store(Request $request)
    {
        $request->validate([
            'nomor_plat' => 'required',
            'jenis' => 'required',
            'merk' => 'required',
            'tahun' => 'required|digits:4',
        ]);

        Kendaraan::create($request->all());

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil disimpan.');
    }

    // Form edit kendaraan
    public function edit($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        return view('kendaraan.edit', compact('kendaraan'));
    }

    // Update data kendaraan (nomor plat, merk, jenis, dll)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_plat' => 'required',
            'jenis' => 'required',
            'merk' => 'required',
            'tahun' => 'required|digits:4',
            // validasi tambahan jika ingin update status manual di sini juga
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update($request->all());

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    // Update status kendaraan dan tanggal servis
   
public function updateStatus(Request $request, $id)
{
    $kendaraan = Kendaraan::findOrFail($id);
    $statusBaru = $request->input('status');

    $kendaraan->status = $statusBaru;

    if ($statusBaru == 'servis') {
        $tanggalServis = $request->input('tanggal_servis') ?? now()->toDateString();

        // Simpan tanggal terakhir servis
        $kendaraan->tanggal_terakhir_service = $tanggalServis;

        // Simpan ke tabel jadwal_service
        JadwalService::create([
            'kendaraan_id' => $kendaraan->id,
            'tanggal_service' => $tanggalServis,
            'deskripsi' => 'Servis telah Dilakukan', // kamu bisa ubah jadi input kalau mau dinamis
        ]);
    }

    $kendaraan->save();

    return back()->with('success', 'Status kendaraan diperbarui.');
}

    public function show($id)
{
    $kendaraan = Kendaraan::with(['jadwalService'])->findOrFail($id);
    $riwayat = $kendaraan->riwayat()->latest()->get(); // jika relasi ada

    return view('kendaraan.show', compact('kendaraan', 'riwayat'));
}

}
