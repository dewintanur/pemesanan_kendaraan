<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatKendaraan extends Model
{
    use HasFactory;
protected $table = 'riwayat_kendaraan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
protected $fillable = [
    'kendaraan_id',
    'pemesanan_id',
    'km_awal',
    'km_akhir',
    'bbm_pakai',
    'tanggal_mulai',
    'tanggal_selesai',
    'catatan',
];

    public function kendaraan() {
        return $this->belongsTo(Kendaraan::class);
    }

    public function pemesanan() {
        return $this->belongsTo(Pemesanan::class);
    }
}
