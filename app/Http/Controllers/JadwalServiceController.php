<?php

namespace App\Http\Controllers;

use App\Models\JadwalService;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class JadwalServiceController extends Controller
{
    public function index()
    {
        $jadwals = JadwalService::with('kendaraan')->orderBy('tanggal_service', 'desc')->paginate(10);
        return view('jadwal_service.index', compact('jadwals'));
    }

    public function create()
    {
        $kendaraan = Kendaraan::all();
        return view('jadwal_service.create', compact('kendaraan'));
    }

   public function store(Request $request)
{
    $request->validate([
        'kendaraan_id' => 'required|exists:kendaraan,id',
        'tanggal_service' => 'required|date',
        'deskripsi' => 'nullable|string|max:255',
    ]);

    $jadwal = JadwalService::create($request->all());

    // ✅ Update kolom jadwal_service_berikutnya di tabel kendaraan
    $kendaraan = $jadwal->kendaraan;
    $kendaraan->jadwal_service_berikutnya = $jadwal->tanggal_service;
    $kendaraan->save();

    return redirect()->route('jadwal_service.index')->with('success', 'Jadwal servis berhasil ditambahkan.');
}


    public function edit($id)
    {
        $jadwal = JadwalService::findOrFail($id);
        $kendaraan = Kendaraan::all();
        return view('jadwal_service.edit', compact('jadwal', 'kendaraan'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'kendaraan_id' => 'required|exists:kendaraan,id',
        'tanggal_service' => 'required|date',
        'deskripsi' => 'nullable|string|max:255',
    ]);

    $jadwal = JadwalService::findOrFail($id);
    $jadwal->update($request->all());

    // ✅ Update kolom jadwal_service_berikutnya
    $kendaraan = $jadwal->kendaraan;
    $kendaraan->jadwal_service_berikutnya = $jadwal->tanggal_service;
    $kendaraan->save();

    return redirect()->route('jadwal_service.index')->with('success', 'Jadwal servis berhasil diperbarui.');
}


    public function destroy($id)
    {
        $jadwal = JadwalService::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal_service.index')->with('success', 'Jadwal servis berhasil dihapus.');
    }
}
