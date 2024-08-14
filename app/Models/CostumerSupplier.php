<?php

namespace App\Models;

use App\Models\PersediaanBarang\PBFinishGood;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CostumerSupplier extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable  = [
        'nama_costumer',
        'kode_costumer',
        'no_telepon_pt',
        'alamat_costumer',
        'kontak_costumer',
        'email_costumer',
    ];

    public function finishGoods()
    {
        return $this->hasMany(PBFinishGood::class);
    }

}
