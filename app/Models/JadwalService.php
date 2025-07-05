<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalService extends Model
{
    use HasFactory;
    protected $table = 'jadwal_service';

    protected $fillable = ['kendaraan_id', 'tanggal_service', 'deskripsi'];

    public function kendaraan() {
        return $this->belongsTo(Kendaraan::class);
    }
}
