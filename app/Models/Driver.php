<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'telp'];

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class);
    }
}
