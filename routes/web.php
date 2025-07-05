<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\RiwayatKendaraanController;
use App\Http\Controllers\JadwalServiceController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

Route::resource('kendaraan', KendaraanController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/riwayat', [RiwayatKendaraanController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/create', [RiwayatKendaraanController::class, 'create'])->name('riwayat.create');
    Route::post('/riwayat', [RiwayatKendaraanController::class, 'store'])->name('riwayat.store');
    Route::get('/riwayat/export', [RiwayatKendaraanController::class, 'export'])->name('riwayat.export');
    Route::get('/riwayat/form/{pemesanan}', [RiwayatKendaraanController::class, 'form'])->name('riwayat.form');
    Route::post('/riwayat/simpan', [RiwayatKendaraanController::class, 'store'])->name('riwayat.store');
    Route::resource('jadwal_service', JadwalServiceController::class);
    Route::get('/get-kendaraan/{id}', function ($id) {
        return \App\Models\Kendaraan::findOrFail($id);
    })->name('get.kendaraan');
    Route::get('/get-pemesanan/{kendaraan_id}', function ($id) {
        return \App\Models\Pemesanan::with('user')
            ->where('kendaraan_id', $id)
            ->where('status', 'disetujui') // Atau bisa 'dipakai'
            ->latest('tanggal_pakai')
            ->take(1)
            ->get();
    })->name('get.pemesanan.kendaraan');
Route::post('/kendaraan/{id}/update-status', [KendaraanController::class, 'updateStatus'])->name('kendaraan.updateStatus');
Route::get('/kendaraan/{id}', [KendaraanController::class, 'show'])->name('kendaraan.show');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/create', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');

});
Route::middleware(['auth'])->group(function () {
    Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    Route::get('/approval/riwayat', [ApprovalController::class, 'riwayat'])->name('approval.riwayat');

});


require __DIR__ . '/auth.php';
