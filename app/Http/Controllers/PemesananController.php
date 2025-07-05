<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Kendaraan;
use App\Models\Driver;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class PemesananController extends Controller
{
 public function index()
{
    $data = Auth::user()->role === 'admin'
        ? Pemesanan::with('kendaraan', 'driver', 'user')->latest()->get()
        : Pemesanan::where('user_id', Auth::id())->with('kendaraan', 'driver')->get();

    $pemesanan = Pemesanan::with('user', 'kendaraan', 'driver')->get();

    return view('pemesanan.index', compact('data', 'pemesanan'));
}


  public function create()
{
    $kendaraan = Kendaraan::all();
    $driver = Driver::all();
    $approverLevel1 = \App\Models\User::where('role', 'approver')->where('approver_level', 1)->get();
    $approverLevel2 = \App\Models\User::where('role', 'approver')->where('approver_level', 2)->get();

    return view('pemesanan.create', compact('kendaraan', 'driver', 'approverLevel1', 'approverLevel2'));
}


public function store(Request $req)
{
    $req->validate([
        'kendaraan_id' => 'required',
        'driver_id' => 'required',
        'tanggal_pakai' => 'required|date',
        'lokasi' => 'required',
        'approver1' => 'required',
        'approver2' => 'required',
    ]);

    $p = Pemesanan::create([
        'user_id' => Auth::id(),
        'kendaraan_id' => $req->kendaraan_id,
        'driver_id' => $req->driver_id,
        'tanggal_pakai' => $req->tanggal_pakai,
        'lokasi' => $req->lokasi,
        'status' => 'pending'
    ]);

    // Buat entry approval level 1
    Approval::create([
        'pemesanan_id' => $p->id,
        'approver_id' => $req->approver1,
        'level' => 1,
        'status' => 'pending'
    ]);

    // Buat entry approval level 2
    Approval::create([
        'pemesanan_id' => $p->id,
        'approver_id' => $req->approver2,
        'level' => 2,
        'status' => 'pending'
    ]);

    return redirect()->route('pemesanan.index')->with('success','Pemesanan dibuat. Menunggu persetujuan.');
}
public function show($id)
{
    $pemesanan = Pemesanan::with(['user', 'driver', 'kendaraan'])->findOrFail($id);

    $logs = [];

    // Log: Pemesanan dibuat
    $logs[] = [
        'waktu' => $pemesanan->created_at,
        'user' => $pemesanan->user->name,
        'aktivitas' => 'Membuat pemesanan',
    ];

    // Log: Approval
    foreach ($pemesanan->approvals as $approval) {
        if ($approval->status === 'disetujui') {
            $logs[] = [
                'waktu' => $approval->tanggal_approve,
                'user' => $approval->approver->name,
                'aktivitas' => 'Menyetujui pemesanan',
            ];
        } elseif ($approval->status === 'ditolak') {
            $logs[] = [
                'waktu' => $approval->tanggal_approve,
                'user' => $approval->approver->name,
                'aktivitas' => 'Menolak pemesanan',
            ];
        }
    }

    // Log: Jika sudah dikembalikan → dari tabel riwayat_kendaraan
    if ($pemesanan->riwayat) {
        $logs[] = [
            'waktu' => $pemesanan->riwayat->created_at,
            'user' => optional($pemesanan->riwayat->petugas)->name ?? 'Petugas',
            'aktivitas' => 'Mengembalikan kendaraan',
        ];
    }

    // Log: Tambahan dari tabel logs
    $logTambahan = \App\Models\Log::with('user')
        ->where('aktivitas', 'like', '%ID: '.$pemesanan->id.'%')
        ->get();

    foreach ($logTambahan as $log) {
        $logs[] = [
            'waktu' => $log->waktu,
            'user' => $log->user->name,
            'aktivitas' => $log->aktivitas,
        ];
    }

    // Urutkan berdasarkan waktu
    usort($logs, function ($a, $b) {
        return strtotime($a['waktu']) <=> strtotime($b['waktu']);
    });

    return view('pemesanan.show', compact('pemesanan', 'logs'));
}

}
