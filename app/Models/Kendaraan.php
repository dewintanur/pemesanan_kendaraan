<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    protected $fillable = [
        'nomor_plat',
        'jenis',
        'merk',
        'tahun',
        'tanggal_terakhir_bbm',
        'tanggal_terakhir_service',
        'km_terakhir',
        'jadwal_service_berikutnya',
        'status'
    ];

    /**
     * Relasi ke tabel pemesanan
     */
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class);
    }

    /**
     * Relasi ke tabel riwayat kendaraan
     */
    public function riwayat()
    {
        return $this->hasMany(RiwayatKendaraan::class);
    }

    /**
     * Relasi ke tabel jadwal service
     */
    public function jadwalService()
{
    return $this->hasMany(JadwalService::class);
}

}
