<?php

namespace App\Models\PelangganPemasok;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Supplier extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'suppliers';
    protected $fillable  = [
        'nama_supplier',
        'kode_supplier',
        'no_telepon_pt',
        'alamat_supplier',
        'kontak_supplier',
        'email_supplier',
    ];
}
