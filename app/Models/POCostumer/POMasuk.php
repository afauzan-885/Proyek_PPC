<?php

namespace App\Models\POCostumer;

use App\Models\PelangganPemasok\Customer;
use App\Models\PersediaanBarang\PBFinishGood;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POMasuk extends Model
{
    use HasFactory;
    protected $table = 'po__po_masuk';
    protected $fillable = [
        'kode_customer',
        'tanggal_po',
        'term_of_payment',
        'qty',
        'total_pesanan',
        'harga',
        'no_po',
        'tanggal_pengiriman',
        'kode_barang',
        'total_amount',
    ];

    public function finishgoods()
    {
        return $this->belongsTo(PBFinishGood::class, 'kode_barang', 'kode_barang');
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'kode_customer', 'kode_customer');
    }

    public function jadwalpengiriman()
    {
        return $this->hasMany(POJadwalPengiriman::class, 'no_po', 'no_po');
    }
}
