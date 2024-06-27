<?php

namespace App\Models\POCostumer;

use App\Models\PersediaanBarang\PBFinishGood;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POMasuk extends Model
{
    use HasFactory;
    protected $table = 'po__po_masuk';
    protected $fillable = [
        'nama_customer',
        'tanggal_po',
        'term_of_payment',
        'qty',
        'no_po',
        'tanggal_pengiriman',
        'kode_barang',
        'total_amount',
    ];

    public function finishGood()
{
    return $this->belongsTo(PBFinishGood::class, 'kode_barang', 'kode_barang');
}
}
