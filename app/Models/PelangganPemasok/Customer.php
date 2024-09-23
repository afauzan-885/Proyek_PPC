<?php

namespace App\Models\PelangganPemasok;

use App\Models\POCostumer\POMasuk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customer';
    protected $fillable  = [
        'nama_customer',
        'kode_customer',
        'no_telepon_pt',
        'alamat_customer',
        'kontak_customer',
        'email_customer',
    ];
}
