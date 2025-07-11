<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password'];

    public function pemesanan() {
        return $this->hasMany(Pemesanan::class);
    }
    // App\Models\User.php

public function logs()
{
    return $this->hasMany(Log::class);
}

}
