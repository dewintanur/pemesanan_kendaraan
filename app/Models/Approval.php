<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = ['pemesanan_id', 'approver_id', 'level', 'status', 'tanggal_approve'];

    public function pemesanan() {
        return $this->belongsTo(Pemesanan::class);
    }

    public function approver() {
        return $this->belongsTo(User::class, 'approver_id');
    }
    // App\Models\User.php

public function logs()
{
    return $this->hasMany(Log::class);
}

}
