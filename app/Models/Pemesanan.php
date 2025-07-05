<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';
    protected $fillable = [
        'user_id', 'kendaraan_id', 'driver_id', 'tanggal_pakai', 'lokasi', 'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kendaraan() {
        return $this->belongsTo(Kendaraan::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function approvals() {
        return $this->hasMany(Approval::class);
    }

    public function riwayat() {
        return $this->hasOne(RiwayatKendaraan::class);
    }
}
