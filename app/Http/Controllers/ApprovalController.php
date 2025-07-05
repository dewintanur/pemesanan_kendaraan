<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;
use App\Models\Log;

class ApprovalController extends Controller
{
    public function index()
    {
        // Ambil semua pemesanan yang menunggu persetujuan user ini
        $data = Approval::with('pemesanan.kendaraan', 'pemesanan.driver', 'pemesanan.user')
            ->where('approver_id', Auth::id())
            ->where('status', 'pending')
            ->get();
if (session()->missing('new_approval_notif')) {
    $jumlahPending = Approval::where('status', 'pending')->count();
    
    if ($jumlahPending > 0) {
        session()->flash('new_approval_notif', "Ada $jumlahPending pemesanan baru yang menunggu persetujuan.");
    }
}

        return view('approval.index', compact('data'));
    }

    public function approve($id)
{
    $approval = Approval::findOrFail($id);
    $approval->status = 'disetujui';
    $approval->tanggal_approve = now();
    $approval->save();

    // Catat log siapa yang menyetujui
    Log::create([
        'user_id' => Auth::id(),
        'aktivitas' => 'Menyetujui pemesanan ID ' . $approval->pemesanan_id,
        'waktu' => now(),
    ]);

    // Cek apakah semua approval sudah setuju
    $allApproved = Approval::where('pemesanan_id', $approval->pemesanan_id)
        ->where('status', '!=', 'disetujui')
        ->count() === 0;

    if ($allApproved) {
        $approval->pemesanan->update(['status' => 'disetujui']);

        // Log untuk status final disetujui
        Log::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Pemesanan ID ' . $approval->pemesanan_id . ' disetujui oleh semua approver',
            'waktu' => now(),
        ]);
    }

    return back()->with('success', 'Pemesanan telah disetujui.');
}

public function reject($id)
{
    $approval = Approval::findOrFail($id);
    $approval->status = 'ditolak';
    $approval->tanggal_approve = now();
    $approval->save();

    // Log penolakan
    Log::create([
        'user_id' => Auth::id(),
        'aktivitas' => 'Menolak pemesanan ID ' . $approval->pemesanan_id,
        'waktu' => now(),
    ]);

    // Pemesanan otomatis ditolak jika ada yang menolak
    $approval->pemesanan->update(['status' => 'ditolak']);

    Log::create([
        'user_id' => Auth::id(),
        'aktivitas' => 'Pemesanan ID ' . $approval->pemesanan_id . ' ditolak',
        'waktu' => now(),
    ]);

    return back()->with('error', 'Pemesanan ditolak.');
}
public function riwayat()
{
    // Ambil semua approval milik user login yang sudah disetujui/ditolak
    $riwayat = Approval::with('pemesanan.kendaraan', 'pemesanan.user', 'pemesanan.driver')
        ->where('approver_id', Auth::id())
        ->whereIn('status', ['disetujui', 'ditolak'])
        ->orderBy('tanggal_approve', 'desc')
        ->get();

    return view('approval.riwayat', compact('riwayat'));
}

}
